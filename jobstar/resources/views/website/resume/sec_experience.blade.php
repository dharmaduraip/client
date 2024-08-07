@extends('website.layouts.app')

@section('title')
    {{ __('Experience - Resume') }}
@endsection

@section('css')
<style>
    .experdiv{
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
                            <h5>{{__('Review your experience')}}</h5>
                            <a href="{{ route('candidate.preview.experience') }}" class="btn btn-warning"><i class="fas fa-eye fa-lg"></i> {{__('Preview') }}</a>
                            <a href="{{ route('candidate.add.experience') }}" class="btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> {{__('ADD MORE EXPERIENCE') }}</a>
                        </div>

                        <div>
                            @foreach($experiences as $experience)
                                <div class="experdiv p-3 mt-3">
                                    <p><b>{{ $experience->designation }}&nbsp;|&nbsp;{{ $experience->company }}</b></p>
                                    <p>{{ $experience->company_location }}</p>
                                    <p>{{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif</p>
                                    <ul>
                                        @if(count($experience->responsible) > 0)
                                            @foreach($experience->responsible as $res)
                                                <li>
                                                    {{ $res->responsibility }}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <div class="pt-4 pb-2">
                                        <a href="{{ url('candidate/edit-experience/'.$experience->id) }}" class="btn btn-info"><x-svg.edit-icon/>{{__('edit') }}</a>
                                        <a href="{{ url('candidate/delete-experience/'.$experience->id) }}" class="btn btn-warning" onclick="return confirm('are you sure you want to delete this?');" ><x-svg.trash-icon/>{{__('delete') }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between pt-5">
                            <a href="{{ route('candidate.section.header') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                            <a href="{{ route('candidate.section.education') }}" class="btn btn-success"> {{__('Continue') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection