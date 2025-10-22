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
    @slot('footer')
        @component('mail::footer')
            <h6>{{ __('emails.footer', ['year' => date('Y'), 'app_name' => getAppName()]) }}</h6>
        @endcomponent
    @endslot
@endcomponent
