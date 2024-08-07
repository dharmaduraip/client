@extends('website.layouts.app')

@section('title')
    {{ __('Summary - Resume') }}
@endsection

@section('css')
    <style>
        .summarydiv,.langdiv{
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
                            <h5>{{__('Almost done! Let’s finish with a strong summary') }}</h5>
                        </div>
                        <div class="pt-3">
                            @if($user->summary != "" || $user->summary != NULL)
                                <div class="summarydiv p-4">
                                    <p>{{__('Summary') }}:</p>
                                    <p>{{ $user->summary }}</p>
                                    <div class="pt-4 pb-2">
                                        <a href="{{ route('candidate.edit.summary') }}" class="btn btn-info"><x-svg.edit-icon/>{{__('edit') }}</a>
                                    </div>
                                </div>
                            @else
                                <p>{{__('Please Add Your Summary') }}</p>
                            @endif

                            <div class="d-flex justify-content-between pt-5 pb-3">
                                <h5>{{__('Languages') }}</h5>
                                <a href="{{ route('candidate.add.languages') }}" class="btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> {{__('ADD MORE Languages') }}</a>
                            </div>
                            <div class="langdiv p-4">
                                @foreach($candidate->languages as $user_lang)
                                    <li>{{ $user_lang->name  }}</li>
                                @endforeach
                                <a href="{{ route('candidate.add.languages') }}" class="btn btn-info mt-4"><x-svg.edit-icon/>{{__('edit') }}</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between pt-5">
                            <a href="{{ route('candidate.section.skills') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                            <a href="{{ route('candidate.section.finalize') }}" class="btn btn-success">{{__('Continue') }}</a>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
@endsection