<link rel="icon" type="image/png" href="{{ asset($setting->favicon_image) }}">
<link rel="stylesheet" href="{{ asset('frontend/vendor.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/app.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/mystyle.css') }}">
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/customfont.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/flag-icon.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/flags.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/rtl-app.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


{{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">


@stack('frontend_links')
@yield('frontend_links')

@php
  $sessionPrimaryColor = session('primaryColor');
  $primaryColor = $sessionPrimaryColor ? $sessionPrimaryColor : $setting->frontend_primary_color;
@endphp

<style>
    :root {
        --primary-500: {{ $primaryColor }} !important;
        --primary-600: {{ adjustBrightness($primaryColor, -0.2) }} !important;
        --primary-200: {{ adjustBrightness($primaryColor, 0.7) }} !important;
        --primary-100: {{ adjustBrightness($primaryColor, 0.8) }} !important;
        --primary-50: {{ adjustBrightness($primaryColor, 0.93) }} !important;
        --gray-20: {{  adjustBrightness($primaryColor, 0.98) }} !important;
    }
</style>
