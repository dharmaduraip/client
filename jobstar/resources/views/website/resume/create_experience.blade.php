@extends('website.layouts.app')

@section('title')
    {{ __('Experience - Resume') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-datepicker.min.css">
<style>
   
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
                            <h5>{{__('Let’s work on your experience')}}</h5>
                            @if(!isset($add))
                                <a href="{{ route('candidate.fresher') }}" class="btn btn-warning">{{__('I AM FRESHER') }}</a>
                            @endif
                        </div>
                        <p class="text-center">{{__('Start with your most recent job first.') }}</p>
                        @if ($errors->any())
                            <div class="alert alert-danger pt-2"> 
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <form action="{{ route('candidate.experience.post') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="modal-body">
                                    <div class="from-group rt-mb-18">
                                        <x-forms.label name="company" class="rt-mb-8" />
                                        <input type="text" name="company" required class="@error('company') is-invalid @enderror" placeholder="{{ __('enter') }} {{ __('company') }}">
                                    </div>
                                    <div class="from-group rt-mb-18">
                                        <x-forms.label name="company location" class="rt-mb-8" />
                                        <input type="text" name="company_location" required class="@error('company_location') is-invalid @enderror" placeholder="{{ __('enter') }} {{ __('company location') }}">
                                    </div>
                                    <div class="row rt-mb-18">
                                        <div class="col-lg-6">
                                            <x-forms.label name="department" class="rt-mb-8" />
                                            <input type="text" name="department" required placeholder="{{ __('enter') }} {{ __('department') }}">
                                        </div>
                                        <div class="col-lg-6">
                                            <x-forms.label name="designation" class="rt-mb-8" />
                                            <input type="text" name="designation" required placeholder="{{ __('enter') }} {{ __('designation') }}">
                                        </div>
                                    </div>
                                    <div class="row rt-mb-18">
                                        <div class="from-group d-flex gap-2 align-items-center rt-mb-24">
                                            <input type="checkbox" name="currently_working" id="experience-modal-checkbox_create" class="cwork" value="1">
                                            <x-forms.label name="i_am_currently_working" for="experience-modal-checkbox_create"
                                                :required="false" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-forms.label name="start_date" class="rt-mb-8"/>
                                             <input type="text" name="start" value="{{ old('start') }}" placeholder="d/m/y" class="date_picker form-control border-cutom @error('start') is-invalid @enderror" required>
                                        </div>
                                        <div class="col-lg-6 experience_end_date">
                                            <x-forms.label name="end_date" class="rt-mb-8" />
                                            <input type="text" name="end" value="{{ old('end') }}" placeholder="d/m/y" class="date_picker form-control border-cutom @error('end') is-invalid @enderror">
                                        </div>
                                    </div>      
                                    <div class="row rt-mb-18">
                                        <label>Responsibilities</label>
                                       <div class="col-10">    
                                           <textarea name="responsibility[]" rows="2" required></textarea>
                                       </div>
                                       <div class="col-2">
                                            <button class="addres btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> ADD</button>
                                       </div>
                                       <div class="multipleres">

                                       </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    @if(isset($add))
                                        <a href="{{ route('candidate.section.experience') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                    @else
                                        <a href="{{ route('candidate.section.header') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                    @endif
                                    <input type="submit" value="Continue" class="btn btn-success">
                                </div>
                                <input type="hidden" class="dynres" value="0">
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
    <script>
        $(".date_picker").attr("autocomplete", "off");

        //init datepicker
        $('.date_picker').off('focus').datepicker({
            format: 'd-m-yyyy',
        }).on('click',
            function() {
                $(this).datepicker('show');
            }
        );
        $(document).ready(function(){
            $(".addres").click(function(){
                var dynres = $(".dynres").val();
                var plus = parseInt(dynres) + 1;
                $(".multipleres").append(
                    `<div class="col-12 mul_`+plus+`">
                        <div class="row">
                            <div class="col-10 mt-2">
                               <textarea name="responsibility[]" rows="2" required></textarea>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-danger" onclick="deleteres(`+plus+`)">DELETE</button>
                            </div>
                        </div>
                    </div>
                `);
                $(".dynres").val(plus);
            });

            $(".cwork").click(function(){
                if($(this).prop("checked") == true){
                    $(".experience_end_date").hide();
                }
                else
                {
                    $(".experience_end_date").show();
                }
            });
        });
        function deleteres(id)
        {
            $(".mul_"+id).remove();
        }
    </script>
@endsection