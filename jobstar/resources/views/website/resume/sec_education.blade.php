@extends('website.layouts.app')

@section('title')
    {{ __('Education - Resume') }}
@endsection

@section('css')
    <style>
        .educationsdiv{
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
                            <h5>{{__('Education Summary')}}</h5>
                            <a href="{{ route('candidate.preview.education') }}" class="btn btn-warning"><i class="fas fa-eye fa-lg"></i> {{__('Preview') }}</a>
                            <a href="{{ route('candidate.add.education') }}" class="btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> {{__('ADD MORE EDUCATIONS') }}</a>
                        </div>
                        <div>
                            @foreach($educations as $education)
                                <div class="educationsdiv p-3 mt-3">
                                    <p><b>{{ $education->qualification }}</b></p>
                                    <p>{{ $education->university }}</p>
                                    <p>{{ $education->location }} | {{ $education->year }}</p>
                                    <div class="pt-4 pb-2">
                                        <a href="{{ url('candidate/edit-education/'.$education->id) }}" class="btn btn-info"><x-svg.edit-icon/>{{__('edit') }}</a>
                                        <a href="{{ url('candidate/delete-education/'.$education->id) }}" class="btn btn-warning" onclick="return confirm('are you sure you want to delete this?');"><x-svg.trash-icon/>{{__('delete') }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between pt-5">
                            <a href="{{ route('candidate.section.experience') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                            <a href="{{ route('candidate.section.skills') }}" class="btn btn-success">{{__('Continue') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection