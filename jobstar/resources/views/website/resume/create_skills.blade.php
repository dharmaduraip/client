@extends('website.layouts.app')

@section('title')
    {{ __('Skills - Resume') }}
@endsection

@section('css')
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('main')
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row">
                <x-website.candidate.sidebar />
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <h5>{{__('Now, let’s add your skills') }}</h5>
                        <div class="skilldiv pt-5">
                            @if(Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif
                            <form action="{{ route('candidate.skills.post') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <label>{{__('Skills you have') }}</label>
                                <select class="select2js" name="skills[]" multiple="multiple">
                                    @foreach ($skills as $skill)
                                        <option     {{ $candidate->skills ? (in_array($skill->id, $candidate->skills->pluck('id')->toArray()) ? 'selected' : '') : '' }} value="{{ $skill->id }}">{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                                <div class="d-flex justify-content-between pt-5">
                                    @if(isset($add) && $add == "new")
                                        <a href="{{ route('candidate.section.education') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                    @else
                                        <a href="{{ route('candidate.section.skills') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                    @endif
                                    <input type="submit" value="{{__('Save & Continue') }}" class="btn btn-success">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".select2js").select2({
                tags: true
            });


        });
    </script>
@endsection