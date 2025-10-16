@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @php
            $styleCss = 'style';
        @endphp
        @component('mail::header', ['url' => config('app.url')])
            <h1 {{ $styleCss }}="display: inline-block">{{ $appName }}</h1>
        @endcomponent
    @endslot

    {{-- Body --}}
    <div>
        <p>{!! __('emails.enquiry.hello') !!}, <b>{{ $name }}</b></p>
        <p>Soru mesajınız başarıyla alındı.</p>
        <p>{{ __('emails.enquiry.thank_you') }}</p>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>{{ __('emails.footer', ['year' => date('Y'), 'app_name' => config('app.name')]) }}</h6> 
        @endcomponent
    @endslot
@endcomponent
