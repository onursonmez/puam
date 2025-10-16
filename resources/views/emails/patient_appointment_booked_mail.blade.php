@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot

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
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>{{ __('emails.footer', ['year' => date('Y'), 'app_name' => getAppName()]) }}</h6>
        @endcomponent
    @endslot
@endcomponent
