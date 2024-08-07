@extends('website.layouts.app')

@section('title')
    {{ __('Header - Resume') }}
@endsection

@section('css')
<style>
    .photo{
        position: static!important;
        opacity: 1!important;
    }
    img{
        height: 150px;
        width: 150px;
    }
</style>
@endsection

@section('main')
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row">
                <x-website.candidate.sidebar />
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <div class="d-flex justify-content-between">
                            <h5>{{__('Let’s start with your header')}}</h5>
                            <a href="{{ route('candidate.preview.header') }}" class="btn btn-warning"><i class="fas fa-eye fa-lg"></i> {{__('Preview') }}</a>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger pt-2"> 
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="pt-4">
                            <form action="" method="POST" enctype="multipart/form-data" autocomplete="off"> 
                                @csrf
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 pt-3">
                                            <label>{{__('Full Name') }}</label>
                                            <input type="text" name="name" value="{{$user->name }}" placeholder="{{__('Enter your Full Name') }}" required>
                                        </div>
                                        <div class="col-6 pt-3">
                                            <label>{{__('Email') }}</label>
                                            <input type="text" name="email" value="{{$user->email }}" placeholder="{{__('Enter your Email Id') }}" required>
                                        </div>
                                        <div class="col-6 pt-3">
                                            <label>{{__('Phone No') }}</label>
                                            <input type="text" name="mobile_num" value="{{$user->mobile_num }}" placeholder="{{__('Enter your Phone Number') }}" required>
                                        </div>
                                        <div class="col-6 pt-3">
                                            <label>{{__('City') }}</label>
                                            <input type="text" name="city" value="{{$user->city }}" placeholder="{{__('Enter your City') }}" required>
                                        </div>
                                        <div class="col-6 pt-3">
                                            <label>{{__('Country') }}</label>
                                            <input type="text" name="country" value="{{$user->country }}" placeholder="{{__('Enter your Country') }}" required>
                                        </div>
                                        @if($user->template_id == "5")
                                        <div class="col-6 pt-3">
                                            <label>{{__('Photo') }}</label>
                                            <input type="file" name="photo" class="photo" accept=".jpg,.jpeg,.png">
                                        </div>
                                        @endif
                                        <div class="col-6 pt-3">
                                            <label>{{__('Pin Code') }}</label>
                                            <input type="text" name="pin_code" value="{{$user->pin_code }}" placeholder="{{__('Enter your Pin Code') }}" required>
                                        </div>
                                        @if($user->template_id == "5")
                                        @if($candidate->photo != NULL || $candidate->photo != "")
                                            <div class="col-6 pt-3">
                                                <img src="{{ url($candidate->photo) }}" >
                                            </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>  
                                <div class="d-flex justify-content-between pt-5">
                                    <a href="{{ route('candidate.build.resume') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> Back</a>
                                    <input type="submit" value="Continue" class="btn btn-success">
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

@endsection