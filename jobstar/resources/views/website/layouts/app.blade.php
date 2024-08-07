<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta property="og:image" content="@yield('og:image')">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    @yield("ld-data")
    {{-- Style --}}
    @include('website.partials.analytics')
    @include('website.partials.links')
    @yield('css')

    @php
    $css_data = !empty($setting->header_css);
    $tag_start = strstr(strtolower($setting->header_css), '<style>');
    $tag_end=strstr(strtolower($setting->header_css), '</style>');

    $js_data = !empty($setting->header_script);
    $script_tag_start = strstr(strtolower($setting->header_script), '<script>');
    $script_tag_end=strstr(strtolower($setting->header_script), '</script>');
    @endphp

    @if($css_data && $tag_start && $tag_end)
        {!! $setting->header_css !!}
    @endif

    @if($js_data && $script_tag_start && $script_tag_end)
        {!! $setting->header_script !!}
    @endif
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6585230f07843602b804a7fd/1hi811ubv';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
</head>

<body dir="{{ langDirection() }}">
    <input type="hidden" value="{{ current_country_code() }}" id="current_country_code">
    <x-admin.app-mode-alert />
    {{-- Header --}}
    @include('website.partials.header')

    {{-- Main --}}
    @yield('main')

    {{-- footer --}}
    @if (!Route::is('candidate.*') && !Route::is('company.*'))
        @include('website.partials.footer')
    @endif

    <!-- scripts -->
    @include('website.partials.scripts')
    @yield('script')
    @php
    $js_data = !empty($setting->body_script);
    $script_tag_start = strstr(strtolower($setting->body_script), '<script>');
    $script_tag_end=strstr(strtolower($setting->body_script), '</script>');
    @endphp

    @if($js_data && $script_tag_start && $script_tag_end)
        {!! $setting->body_script !!}
    @endif
    <x-frontend.cookies-allowance :cookies="$cookies" />
</body>

</html>
