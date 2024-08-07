@extends('website.layouts.app')

@section('title')
    {{ __('Education - Resume') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-datepicker.min.css">
@endsection

@section('main')
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row">
                <x-website.candidate.sidebar />
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <h5>{{__('Tell us about your education') }}</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger pt-2"> 
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="pt-4">
                            <form action="{{ route('candidate.update.education') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                    <input type="hidden" name="id" value="{{ $edu->id }}">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6 pt-3">
                                                <label>{{__('University/Board') }}</label>
                                                <input type="text" name="university" placeholder="{{__('Enter your School or College Name') }}" value="{{ $edu->university }}">
                                            </div>
                                            <div class="col-6 pt-3">
                                                <label>{{__('Location') }}</label>
                                                <input type="text" name="location" placeholder="{{__('Enter your School or College Location') }}" value="{{ $edu->location }}" required>
                                            </div>
                                            <div class="col-6 pt-3">
                                                <label>{{__('Qualification') }}</label>
                                                <input type="text" name="qualification" placeholder="{{__('Enter your Qualification') }}" value="{{ $edu->qualification }}" required>
                                            </div>
                                            <div class="col-6 pt-3">
                                                <label>{{__('Passing Year') }}</label>
                                                 <input type="text" name="year" value="{{ $edu->year }}" placeholder="year" class="year_picker form-control border-cutom @error('year') is-invalid @enderror">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between pt-5">
                                        <a href="{{ route('candidate.section.education') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                        <input type="submit" class="btn btn-success" value="{{__('Continue') }}">
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('frontend/assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(".year_picker").attr("autocomplete", "off");

        //init datepicker
        $('.year_picker').off('focus').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        }).on('click',
            function() {
                $(this).datepicker('show');
            }
        );
    </script>
@endsection