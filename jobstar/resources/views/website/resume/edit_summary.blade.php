@extends('website.layouts.app')

@section('title')
    {{ __('Summary - Resume') }}
@endsection

@section('css')

@endsection

@section('main')
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row">
                <x-website.candidate.sidebar />
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <h5>{{__('Now, let’s Edit your summary') }}</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger pt-2"> 
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="summarydiv pt-3">
                            <form action="{{ route('candidate.summary.post') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                    <label>{{__('Summary') }}</label>
                                    <textarea name="summary" class="summary" rows="5" required>{{ $user->summary }}
                                    </textarea>
                                    <div class="d-flex justify-content-between pt-5">
                                        <a href="{{ route('candidate.section.summary') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                        <input type="submit" class="btn btn-success" value="{{__('Update & Continue') }}">
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