<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WeekDay
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $doctor_session_id
 * @property string $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property string $start_time_type
 * @property string $end_time_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereDayOfWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereDoctorSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereEndTimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereStartTimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekDay whereUpdatedAt($value)
 *
 * @mixin Eloquent
 *
 * @property-read mixed $full_end_time
 * @property-read mixed $full_start_time
 * @property-read \App\Models\DoctorSession $doctorSession
 */
class WeekDay extends Model
{
    use HasFactory;

    public $table = 'session_week_days';

    public $fillable = [
        'doctor_id',
        'doctor_session_id',
        'day_of_week',
        'start_time',
        'end_time',
        'start_time_type',
        'end_time_type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'doctor_session_id' => 'integer',
        'day' => 'string',
        'doctor_id' => 'integer',
        'day_of_week' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
        'start_time_type' => 'string',
        'end_time_type' => 'string',
    ];

    public function getFullStartTimeAttribute()
    {
        return $this->start_time.' '.$this->start_time_type;
    }

    public function getFullEndTimeAttribute()
    {
        return $this->end_time.' '.$this->end_time_type;
    }

    /**
     * Get start time in 24-hour format for dropdown selection
     */
    public function getStartTime24HAttribute()
    {
        return $this->convertTo24HourFormat($this->start_time, $this->start_time_type);
    }

    /**
     * Get end time in 24-hour format for dropdown selection
     */
    public function getEndTime24HAttribute()
    {
        return $this->convertTo24HourFormat($this->end_time, $this->end_time_type);
    }

    /**
     * Convert 12-hour format to 24-hour format
     */
    private function convertTo24HourFormat($time, $type)
    {
        $timeParts = explode(':', $time);
        $hour = (int)$timeParts[0];
        $minute = $timeParts[1];
        
        if ($type === 'AM') {
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

    public function doctorSession()
    {
        return $this->belongsTo(DoctorSession::class);
    }
}
