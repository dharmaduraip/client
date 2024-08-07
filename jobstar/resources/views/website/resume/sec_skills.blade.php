@extends('website.layouts.app')

@section('title')
    {{ __('Skills - Resume') }}
@endsection

@section('css')
    <style type="text/css">
        .skillsdiv{
            border: 1px solid;
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
                            <h5>{{__('your skills') }}</h5>
                            <a href="{{ route('candidate.preview.skills') }}" class="btn btn-warning"><i class="fas fa-eye fa-lg"></i> {{__('Preview') }}</a>
                            <a href="{{ route('candidate.add.skill') }}" class="btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> {{__('ADD MORE SKILLS') }}</a>
                        </div>
                        <div class="skillsdiv p-3 mt-3">
                            @foreach($candidate_skills as $skills)
                                <li>{{ $skills->name }}</li>
                            @endforeach
                            <div class="pt-4 pb-2">
                                <a href="{{ route('candidate.add.skill') }}" class="btn btn-info"><x-svg.edit-icon/>{{__('edit') }}</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between pt-5">
                            <a href="{{ route('candidate.section.education') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                            <a href="{{ route('candidate.section.summary') }}" class="btn btn-success">{{__('Continue') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection