@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot

    {{-- Body --}}
    <div>
        <h2>{!! __('emails.doctor_appointment_booked.hello', ['name' => '<b>' . $name . '</b>']) !!}</h2>
        <p><b>{{ $patientName }}</b> size <b>{{ $service }}</b> hizmeti için randevu talep etti.</p>
        <p><b>{{ __('emails.doctor_appointment_booked.appointment_time') }}: </b>{{ $date }} - {{ $time }}</p>
        <p>{{ __('emails.doctor_appointment_booked.thank_you') }}</p>
        <p>{{ getAppName() }}</p>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>{{ __('emails.footer', ['year' => date('Y'), 'app_name' => getAppName()]) }}</h6>
        @endcomponent
    @endslot
@endcomponent
