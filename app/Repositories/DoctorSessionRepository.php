<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\DoctorSession;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class DoctorSessionRepository
 *
 * @version July 31, 2021, 6:04 am UTC
 */
class DoctorSessionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'session_time',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DoctorSession::class;
    }

    public function getSyncList(): Collection
    {
        if (getLogInUser()->hasRole('doctor')) {
            return Doctor::toBase()->where('user_id', getLogInUserId())->get()->pluck('user.full_name', 'id');
        }

        return Doctor::with('user')->whereNotIn('id',
            DoctorSession::pluck('doctor_id')->toArray())->get()->where('user.status',
                User::ACTIVE)->pluck('user.full_name', 'id');
    }

    /**
     * @return array|bool[]|false
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();
            /** @var DoctorSession $doctorSession */
            $doctorSession = DoctorSession::create(Arr::only($input, app(DoctorSession::class)->getFillable()));
            $result['success'] = true;
            if (! empty($input['checked_week_days']) && count($input['checked_week_days']) > 0) {
                foreach ($input['checked_week_days'] as $day) {
                    $exists = DB::table('session_week_days')
                        ->where('doctor_id', $input['doctor_id'])
                        ->where('day_of_week', $day)
                        ->exists();

                    if ($exists) {
                        return false;
                    }
                    $result = $this->validateSlotTiming($input, $day);
                    if (! $result['success']) {
                        return $result;
                    }
                    $this->saveSlots($input, $day, $doctorSession);
                }
            }

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return array|bool[]
     */
    public function updateDoctorSession(array $input, DoctorSession $doctorSession)
    {
        try {
            DB::beginTransaction();
            $doctorId = $doctorSession->doctor_id;
            $doctorSession->update($input);
            $result['success'] = true;

            $doctorSession->sessionWeekDays()->delete();
            if (! empty($input['checked_week_days'])) {
                foreach ($input['checked_week_days'] as $day) {
                    $result = $this->validateSlotTiming($input, $day);
                    if (! $result['success']) {
                        return $result;
                    }
                    $this->saveSlots($input, $day, $doctorSession);
                }
            }

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function saveSlots($input, $day, $doctorSession): bool
    {
        /** @var DoctorSession $doctorSession */
        $startTimeArr = $input['startTimes'][$day] ?? [];
        $endTimeArr = $input['endTimes'][$day] ?? [];
        if (count($startTimeArr) != 0 && count($endTimeArr) != 0) {
            foreach ($startTimeArr as $key => $startTime) {
                // Parse time format and convert if necessary
                $startTimeData = $this->parseTimeString($startTime);
                $endTimeData = $this->parseTimeString($endTimeArr[$key]);
                
                $doctorSession->sessionWeekDays()->create([
                    'doctor_id' => $doctorSession->doctor_id,
                    'doctor_session_id' => $doctorSession->id,
                    'day_of_week' => $day,
                    'start_time' => $startTimeData['time'],
                    'start_time_type' => $startTimeData['type'],
                    'end_time' => $endTimeData['time'],
                    'end_time_type' => $endTimeData['type'],
                ]);
            }
        }

        return true;
    }

    /**
     * Parse time string and handle both 24-hour and 12-hour formats
     *
     * @param string $timeString - Can be "00:00", "23:45", "12:00 AM", "11:45 PM", etc.
     * @return array - ['time' => 'HH:MM', 'type' => 'AM'|'PM']
     */
    private function parseTimeString($timeString): array
    {
        $timeString = trim($timeString);
        
        // Check if it contains AM/PM (12-hour format)
        if (preg_match('/^(\d{1,2}:\d{2})\s*(AM|PM)$/i', $timeString, $matches)) {
            // Already in 12-hour format
            return [
                'time' => $matches[1],
                'type' => strtoupper($matches[2])
            ];
        }
        
        // Check if it's 24-hour format (HH:MM)
        if (preg_match('/^(\d{1,2}):(\d{2})$/', $timeString, $matches)) {
            $hour = (int)$matches[1];
            $minute = $matches[2];
            
            // Convert 24-hour to 12-hour format
            if ($hour == 0) {
                // 00:xx becomes 12:xx AM
                return [
                    'time' => "12:{$minute}",
                    'type' => 'AM'
                ];
            } elseif ($hour < 12) {
                // 01:xx to 11:xx becomes 1:xx to 11:xx AM
                return [
                    'time' => "{$hour}:{$minute}",
                    'type' => 'AM'
                ];
            } elseif ($hour == 12) {
                // 12:xx becomes 12:xx PM
                return [
                    'time' => "12:{$minute}",
                    'type' => 'PM'
            ];
            } else {
                // 13:xx to 23:xx becomes 1:xx to 11:xx PM
                $hour12 = $hour - 12;
                return [
                    'time' => "{$hour12}:{$minute}",
                    'type' => 'PM'
                ];
            }
        }
        
        // Fallback - if format is unrecognized, assume it's already proper format
        $parts = explode(' ', $timeString);
        return [
            'time' => $parts[0] ?? '12:00',
            'type' => $parts[1] ?? 'AM'
        ];
    }

    public function validateSlotTiming($input, $day)
    {
        $startTimeArr = $input['startTimes'][$day] ?? [];
        $endTimeArr = $input['endTimes'][$day] ?? [];
        foreach ($startTimeArr as $key => $startTime) {
            // Convert the time to 24-hour format for validation
            $startTime24 = $this->convertTo24Hour($startTime);
            $slotStartTime = Carbon::instance(DateTime::createFromFormat('H:i', $startTime24));
            
            $tempArr = Arr::except($startTimeArr, [$key]);
            foreach ($tempArr as $tempKey => $tempStartTime) {
                $tempStartTime24 = $this->convertTo24Hour($tempStartTime);
                $tempEndTime24 = $this->convertTo24Hour($endTimeArr[$tempKey]);
                
                $start = Carbon::instance(DateTime::createFromFormat('H:i', $tempStartTime24));
                $end = Carbon::instance(DateTime::createFromFormat('H:i', $tempEndTime24));
                if ($slotStartTime->isBetween($start, $end)) {
                    return ['day' => $day, 'startTime' => $startTime, 'success' => false, 'key' => $key];
                }
            }
        }

        return ['success' => true];
    }

    /**
     * Convert time string to 24-hour format for validation purposes
     *
     * @param string $timeString
     * @return string
     */
    private function convertTo24Hour($timeString): string
    {
        $timeString = trim($timeString);
        
        // Check if it contains AM/PM (12-hour format)
        if (preg_match('/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i', $timeString, $matches)) {
            $hour = (int)$matches[1];
            $minute = $matches[2];
            $ampm = strtoupper($matches[3]);
            
            if ($ampm === 'AM') {
                if ($hour == 12) {
                    $hour = 0; // 12 AM becomes 00
                }
            } else { // PM
                if ($hour != 12) {
                    $hour += 12; // Add 12 hours for PM (except 12 PM)
                }
            }
            
            return sprintf('%02d:%s', $hour, $minute);
        }
        
        // If it's already in 24-hour format, return as is
        if (preg_match('/^(\d{1,2}):(\d{2})$/', $timeString)) {
            return $timeString;
        }
        
        // Fallback
        return $timeString;
    }
}
