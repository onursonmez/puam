<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getAppName() }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    {{-- Header --}}
    <div style="text-align: center; margin-bottom: 30px; padding: 20px; border-bottom: 1px solid #eee;">
        <img src="{{ asset(getAppLogo()) }}" style="max-height: 60px;" alt="{{ getAppName() }}">
    </div>

    {{-- Body --}}
    <div>
        <h2>{!! __('emails.patient_appointment_booked.hello', ['name' => '<b>' . $name . '</b>']) !!}</h2>
        <p>{!! __('emails.appointment_booked.success_message', ['date' => '<b>' . $date . '</b>', 'time' => '<b>' . $time . '</b>']) !!}</p>
        <p>{{ __('emails.appointment_booked.cancel_instruction') }}</p>
        <div style="display: flex;justify-content: center">
            <a href="{{ route('cancelAppointment',['patient_id'=>$patientId,'appointment_unique_id'=>$appointmentUniqueId]) }}" style="padding: 7px 15px;text-decoration: none;font-size: 14px;background-color: #df4645;font-weight: 500;border: none;border-radius: 8px;color: white">
                    {{ __('emails.appointment_booked.cancel_button') }}
            </a>
        </div>

        <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-left: 4px solid #007bff;">
            <p style="margin-bottom: 15px; font-weight: 600; color: #333;">
                Ödemenizi banka havalesi/EFT ile aşağıdaki banka hesap bilgilerine gönderebilirsiniz. Açıklama kısmına <strong>{{ $appointmentUniqueIdUnencrypted }}</strong> yazmayı unutmayınız.
            </p>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background-color: #e9ecef;">
                        <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6; font-weight: 600;">Alıcı</th>
                        <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6; font-weight: 600;">Hesap Numarası</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 12px; border: 1px solid #dee2e6;">Fatih Sultan Mehmet Vakıf Üniversitesi İktisadi İşletmesi</td>
                        <td style="padding: 12px; border: 1px solid #dee2e6; font-family: monospace; font-weight: 600;">TR30 0021 0000 0000 2145 3000 04</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer --}}
    <div style="text-align: center; margin-top: 40px; padding: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;">
        <h6>{{ __('emails.footer', ['year' => date('Y'), 'app_name' => getAppName()]) }}</h6>
    </div>
</body>
</html>
