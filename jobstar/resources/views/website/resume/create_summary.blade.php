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
                        <h5>{{__('Now, let’s add your summary') }}</h5>
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
                                    <textarea name="summary" class="summary" rows="5" required>
                                    </textarea>
                                    <div class="d-flex justify-content-between pt-5">
                                        @if(isset($add) && $add == "new")
                                            <a href="{{ route('candidate.section.skills') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                        @else
                                            <a href="{{ route('candidate.section.summary') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                        @endif
                                        <input type="submit" class="btn btn-success" value="{{__('Save & Continue') }}">
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