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
        <h2>{!! __('emails.doctor_appointment_booked.hello', ['name' => '<b>' . $name . '</b>']) !!}</h2>
        <p><b>{{ $patientName }}</b> size <b>{{ $service }}</b> hizmeti için randevu talep etti.</p>
        <p><b>{{ __('emails.doctor_appointment_booked.appointment_time') }}: </b>{{ $date }} - {{ $time }}</p>
        <p>{{ __('emails.doctor_appointment_booked.thank_you') }}</p>
        <p>{{ getAppName() }}</p>
    </div>

    {{-- Footer --}}
    <div style="text-align: center; margin-top: 40px; padding: 20px; border-top: 1px solid #eee; color: #666; font-size: 12px;">
        <h6>{{ __('emails.footer', ['year' => date('Y'), 'app_name' => getAppName()]) }}</h6>
    </div>
</body>
</html>
