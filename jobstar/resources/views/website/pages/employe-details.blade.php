@extends('website.layouts.app')

@section('description')
    @php
    $data = metaData('company-details');
    @endphp
    {{ $data->description }}
@endsection
@section('og:image')
    {{ asset($data->image) }}
@endsection
@section('title')
    {{ __('company') }} {{ $user->name }}
@endsection

@section('main')
    @php
        $lat = $user->company->lat;
        $long = $user->company->long;
    @endphp

    <div class="breadcrumbs breadcrumbs-height">
        <div class="container">
            <div class="breadcrumb-menu">
                <h6 class="f-size-18 m-0">{{ __('employer_details') }}</h6>
                <ul>
                    <li><a href="{{ route('website.home') }}">{{ __('home') }}</a></li>
                    <li>/</li>
                    <li>{{ $user->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="single-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="pgae-bg bgprefix-cover page-bg-radius"
                        style="background-image: url('{{ $user->company->banner_url }}');"></div>
                    <div
                        class="card jobcardStyle1 hover:bg-transparent hover-shadow:none body-24 hover:border-transparent border border-gray-50">
                        <div class="card-body">
                            <div class="rt-single-icon-box flex-column flex-lg-row">
                                <div class="icon-thumb rt-mb-lg-20 company-logo">
                                    <img src="{{ $user->company->logo_url }}" alt="" draggable="false">
                                </div>
                                <div class="iconbox-content">
                                    <div class="post-info2">
                                        <div class="post-main-title2">
                                            <a href="{{ route('website.employe.details', $user->username) }}">
                                                {{ $user->name }}
                                            </a>
                                            @if ($companyDetails->industry)
                                                <p class="f-size-16 text-gray-600 m-0">
                                                    {{ $companyDetails->industry->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="iconbox-extra align-self-start align-self-lg-center rt-pt-lg-20 flex-md-row flex-column">
                                    <div class="max-311">
                                        <a href="#open_position" type="button" class="btn btn-primary btn-lg d-block">
                                            <span class="button-content-wrapper ">
                                                <span class="button-icon align-icon-right">
                                                    <i class="ph-arrow-right"></i>
                                                </span>
                                                <span class="button-text">
                                                    {{ __('open_position') }}
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Single job content Area-->
    <div class="single-job-content rt-pt-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 rt-mb-lg-30">
                    <div class="body-font-1 ft-wt-5 rt-mb-20">{{ __('company_description') }}</div>
                    <div class="body-font-3 text-black-500">
                        {!! $user->company->bio !!}
                    </div>
                    <div class="share-job rt-pt-50">
                        <ul class="rt-list gap-8">
                            <li class="d-inline-block body-font-3">
                                {{ __('share_this_profile') }}:
                            </li>
                            <li class="d-inline-block ms-3">
                                <a href="{{ socialMediaShareLinks(url()->current(), 'facebook') }}">
                                    <button class="btn btn-outline-plain tw-px-2 tw-py-1.5 tw-text-sm hover-fb">
                                        <span class="f-size-18 text-primary-500">
                                            <x-svg.facebook-icon width="1em" height="1em" />
                                        </span>
                                        <span class="text-primary-500">{{ __('facebook') }}</span>
                                    </button>
                                </a>
                            </li>
                            <li class="d-inline-block">
                                <a href="{{ socialMediaShareLinks(url()->current(), 'twitter') }}">
                                    <button class="btn btn-outline-plain tw-px-2 tw-py-1.5 tw-text-sm hover-tw">
                                        <span class="f-size-18 text-twitter">
                                            <x-svg.twitter-icon width="1em" height="1em" />
                                        </span>
                                        <span class="text-twitter">{{ __('twitter') }}</span>
                                    </button>
                                </a>
                            </li>
                            <li class="d-inline-block">
                                <a href="{{ socialMediaShareLinks(url()->current(), 'pinterest') }}">
                                    <button class="btn btn-outline-plain tw-px-2 tw-py-1.5 tw-text-sm hover-pin">
                                        <span class="f-size-18 text-pinterest me-1">
                                            <x-svg.pinterest-icon />
                                        </span>
                                        <span class="text-pinterest">{{ __('pinterest') }}</span>
                                    </button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="cadidate-details-sidebar">
                        @if ($user->company->establishment_date || $companyDetails->organization || $companyDetails->team_size)
                            <div class="sidebar-widget">
                                <div class="row">
                                    @if ($user->company->establishment_date)
                                        <div class="col-sm-6">
                                            <div class="icon-box">
                                                <div class="icon-img">
                                                    <x-svg.birth-date-icon />
                                                </div>
                                                <h3 class="sub-title">{{ __('founded_in') }}</h3>
                                                <h2 class="title">
                                                    {{ date('j F, Y', strtotime($user->company->establishment_date)) }}
                                                </h2>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($companyDetails->organization)
                                        <div class="col-sm-6">
                                            <div class="icon-box">
                                                <div class="icon-img">
                                                    <x-svg.fold-icon />
                                                </div>
                                                <h3 class="sub-title">{{ __('organization_type') }}</h3>
                                                <h2 class="title">
                                                    {{ $companyDetails->organization ? ucfirst($companyDetails->organization->name) : '' }}
                                                </h2>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($companyDetails->team_size)
                                        <div class="col-sm-6">
                                            <div class="icon-box">
                                                <div class="icon-img">
                                                    <x-svg.board-icon />
                                                </div>
                                                <h3 class="sub-title">{{ __('company_size') }}</h3>
                                                <h2 class="title">
                                                    {{ $companyDetails->team_size ? $companyDetails->team_size->name : '' }}
                                                </h2>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <!-- contact information  START -->
                        <x-website.company.contact-information :user="$user" />

                        <!-- Location -->
                        <div class="border border-2 border-primary-50 rt-rounded-12 rt-mb-24 lg:max-536">
                            <div class="body-font-1 ft-wt-5 custom-p">{{ __('map') }} {{ __('location') }}
                            </div>
                            <div>
                                @php
                                    $map = setting('default_map');
                                @endphp
                                @if ($map == 'map-box')
                                    <div class="map mymap" id='map-box'></div>
                                @elseif ($map == 'google-map')
                                    <div class="map mymap" id="google-map"></div>
                                @else
                                    <div id="leaflet-map"></div>
                                @endif
                            </div>
                        </div>

                        <!-- contact information END -->
                        @if ($user->socialInfo && $user->socialInfo->count() > 0)
                            <div class="p-32 border border-1.5 border-primary-50 rt-rounded-12  max-536">
                                <div class="row g-0">
                                    <div class="col-12 d-flex align-items-center">
                                        <div class="f-size-18 text-gray-900 follow-us">
                                            {{ __('Follow us on') }}:
                                        </div>
                                    </div>
                                    <div class="col-12 rt-pt-lg-10">
                                        <ul class="rt-list gap-8">
                                            @foreach ($user->socialInfo as $contact)
                                                <li class="d-inline-block">
                                                    <a target="__blank" href="{{ $contact->url }}"
                                                        class="social-icon icon-44 bg-gray-10 bg-primary-50 text-primary-500 hover:border-primary-500">
                                                        @switch($contact)
                                                            @case($contact->social_media === 'facebook')
                                                                <x-svg.facebook-icon />
                                                            @break

                                                            @case($contact->social_media === 'twitter')
                                                                <x-svg.twitter-icon />
                                                            @break

                                                            @case($contact->social_media === 'instagram')
                                                                <x-svg.instagram-icon />
                                                            @break

                                                            @case($contact->social_media === 'youtube')
                                                                <x-svg.youtube-icon />
                                                            @break

                                                            @case($contact->social_media === 'linkedin')
                                                                <x-svg.linkedin-icon />
                                                            @break

                                                            @case($contact->social_media === 'pinterest')
                                                                <x-svg.pinterest-icon />
                                                            @break

                                                            @case($contact->social_media === 'reddit')
                                                                <x-svg.reddit-icon />
                                                            @break

                                                            @case($contact->social_media === 'github')
                                                                <x-svg.github-icon />
                                                            @break

                                                            @case($contact->social_media === 'other')
                                                                <x-svg.link-icon />
                                                            @break

                                                            @default
                                                        @endswitch
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rt-spacer-100 rt-spacer-md-50"></div>
    <!--Related candidate Area-->
    <hr class="hr-0">
    <section class="related-jobs-area rt-pt-100 rt-pt-md-50" id="open_position">
        <div class="container">
            <div class="row">
                <div class="flex-grow-1 mb-4">
                    <h4>{{ __('open_positions') }} ({{ count($open_jobs) }})</h4>
                </div>
                @forelse ($open_jobs as $job)
                    <div class="col-xl-4 col-md-6 fade-in-bottom rt-mb-24 cat-1 cat-3 ">
                        <div class="card jobcardStyle1 {{ $job->highlight ? 'gradient-bg' : '' }}">
                            <div class="card-body">
                                <div class="rt-single-icon-box">
                                    <div class="icon-thumb company-logo">
                                        <img src="{{ $job->company->logo_url }}" alt="" draggable="false">
                                    </div>
                                    <div class="iconbox-content">
                                        <div class="job-mini-title"><a
                                                href="{{ route('website.job.details', $job->slug) }}">{{ $job->company->user->name }}</a>
                                            @if ($job->featured)
                                                <span
                                                    class="badge rounded-pill bg-danger-50 text-danger-500">{{ __('featured') }}</span>
                                            @endif
                                        </div>
                                        <span class="loacton text-gray-400 d-inline-flex ">
                                            <i class="ph-map-pin"></i>
                                            {{ $job->country }}
                                        </span>
                                    </div>
                                </div>
                                <div class="post-info">
                                    <div class="post-main-title"> <a
                                            href="{{ route('website.job.details', $job->slug) }}">{{ $job->title }}</a>
                                    </div>
                                    <div class="body-font-4 text-gray-600">
                                        <span class="info-tools">{{ $job->job_type ? $job->job_type->name : '' }}</span>
                                        <span class="info-tools has-dot">
                                            @if ($job->salary_mode == 'range')
                                            {{ currencyAmountShort($job->min_salary) }} - {{ currencyAmountShort($job->max_salary) }} {{ currentCurrencyCode() }}
                                            @else
                                            {{ $job->custom_salary }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card text-center">
                        <x-not-found message="{{ __('no_data_found') }}" />
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <div class="rt-spacer-75 rt-spacer-md-30"></div>
@endsection

@section('frontend_links')
    <!-- >=>Leaflet Map<=< -->
    <x-map.leaflet.map_links />

    <!-- >=>Mapbox<=< -->
    @include('map::links')
    <!-- >=>Mapbox<=< -->
    <style>
        .mymap {
            border-radius: 0 0 12px 12px;
        }

        .custom-p {
            padding-top: 24px;
            padding-bottom: 16px;
            padding-left: 24px
        }

        .show-more {
            font-size: 14px;
            padding: 6px;
            cursor: pointer;
            opacity: 0.7;
        }
    </style>
@endsection

@section('script')
    <script>
        $('#show-more').on('click', function() {
            var value = $(this).attr('aria-expanded');
            if (value == 'true') {
                $('#show-more').html('Hide information');
            } else {
                $('#show-more').html('Show Contact Information');
            }
        })
    </script>

    {{-- Leaflet  --}}
    <x-map.leaflet.map_scripts />
    <script>
        var oldlat = {!! $lat ? $lat : setting('default_lat') !!};
        var oldlng = {!! $long ? $long : setting('default_long') !!};

        // Map preview
        var element = document.getElementById('leaflet-map');

        // Height has to be set. You can do this in CSS too.
        element.style = 'height:300px;';

        // Create Leaflet map on map element.
        var leaflet_map = L.map(element);

        // Add OSM tile layer to the Leaflet map.
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leaflet_map);

        // Target's GPS coordinates.
        var target = L.latLng(oldlat, oldlng);

        // Set map's center to target with zoom 14.
        const zoom = 7;
        leaflet_map.setView(target, zoom);

        // Place a marker on the same location.
        L.marker(target).addTo(leaflet_map);
    </script>

    <!-- >=>Mapbox<=< -->
    @include('map::scripts')
    <!-- >=>Mapbox<=< -->

    <!-- ================ mapbox map ============== -->
    <script>
        mapboxgl.accessToken = "{{ $setting->map_box_key }}";
        const coordinates = document.getElementById('coordinates');

        const map = new mapboxgl.Map({
            container: 'map-box',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [oldlng, oldlat],
            zoom: 6
        });
        var marker = new mapboxgl.Marker({
                draggable: false
            }).setLngLat([oldlng, oldlat])
            .addTo(map);

        function onDragEnd() {
            const lngLat = marker.getLngLat();
            let lat = lngLat.lat;
            let lng = lngLat.lng;
            $('#lat').val(lat);
            $('#lng').val(lng);
            document.getElementById('form').submit();
        }

        function add_marker(event) {
            var coordinates = event.lngLat;
            marker.setLngLat(coordinates).addTo(map);

        }
        // zoom in and out
        <x-mapbox-zoom-control />
    </script>
    <script>
        $('.mapboxgl-ctrl-logo').addClass('d-none');
        $('.mapboxgl-ctrl-bottom-right').addClass('d-none');
    </script>
    <!-- ================ mapbox map ============== -->

    <!-- ================ google map ============== -->
    <script>
        function initMap() {
            var token = "{{ $setting->google_map_key }}";

            const map = new google.maps.Map(document.getElementById("google-map"), {
                zoom: 7,
                center: {
                    lat: oldlat,
                    lng: oldlng
                },
            });

            const image =
                "https://gisgeography.com/wp-content/uploads/2018/01/map-marker-3-116x200.png";
            const beachMarker = new google.maps.Marker({

                draggable: false,
                position: {
                    lat: oldlat,
                    lng: oldlng
                },
                map,
                // icon: image
            });
        }
        window.initMap = initMap;
    </script>
    <script>
        @php
            $link1 = 'https://maps.googleapis.com/maps/api/js?key=';
            $link2 = $setting->google_map_key;
            $Link3 = '&callback=initMap&libraries=places,geometry';
            $scr = $link1 . $link2 . $Link3;
        @endphp;
    </script>
    <script src="{{ $scr }}" async defer></script>
    <!-- ================ google map ============== -->
@endsection
