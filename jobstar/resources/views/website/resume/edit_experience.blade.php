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
                        <h5>{{__('Let’s work on your experience')}}</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger pt-2"> 
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <form action="{{ route('candidate.experience.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="hidden" name="id" value="{{ $experience->id }}">
                                <div class="modal-body">
                                    <div class="from-group rt-mb-18">
                                        <x-forms.label name="company" class="rt-mb-8" />
                                        <input type="text" name="company" required class="@error('company') is-invalid @enderror" placeholder="{{ __('enter') }} {{ __('company') }}" value="{{ $experience->company }}">
                                    </div>
                                    <div class="from-group rt-mb-18">
                                        <x-forms.label name="company location" class="rt-mb-8" />
                                        <input type="text" name="company_location" required class="@error('company_location') is-invalid @enderror" placeholder="{{ __('enter') }} {{ __('company location') }}" value="{{ $experience->company_location }}">
                                    </div>
                                    <div class="row rt-mb-18">
                                        <div class="col-lg-6">
                                            <x-forms.label name="department" class="rt-mb-8" />
                                            <input type="text" name="department" required placeholder="{{ __('enter') }} {{ __('department') }}" value="{{ $experience->department }}">
                                        </div>
                                        <div class="col-lg-6">
                                            <x-forms.label name="designation" class="rt-mb-8" />
                                            <input type="text" name="designation" required placeholder="{{ __('enter') }} {{ __('designation') }}" value="{{ $experience->designation }}">
                                        </div>
                                    </div>
                                    <div class="row rt-mb-18">
                                        <div class="from-group d-flex gap-2 align-items-center rt-mb-24">
                                            <input type="checkbox" name="currently_working" id="experience-modal-checkbox_create" class="cwork" value="1" @if($experience->currently_working == "1") checked @endif
                                            <x-forms.label name="i_am_currently_working" for="experience-modal-checkbox_create"
                                                :required="false" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-forms.label name="start_date" class="rt-mb-8"/>
                                             <input type="text" name="start" value="{{ $experience->start }}" placeholder="d/m/y" class="date_picker form-control border-cutom @error('start') is-invalid @enderror" required>
                                        </div>
                                        <div class="col-lg-6 experience_end_date">
                                            <x-forms.label name="end_date" class="rt-mb-8" />
                                            <input type="text" name="end" value="{{ $experience->end }}" placeholder="d/m/y" class="date_picker form-control border-cutom @error('end') is-invalid @enderror">
                                        </div>
                                    </div>
                                    
                                    <div class="row rt-mb-18">
                                        <label >Responsibilities<span class="text-danger">*</span></label>
                                        @if(count($experience->responsible) > 0)
                                            @foreach($experience->responsible as $key => $res)
                                                @if($loop->first)
                                                    <div class="col-10">    
                                                       <textarea name="responsibility[]" rows="2" required>{{ $res->responsibility }}</textarea>
                                                   </div>
                                                   <div class="col-2">
                                                        <button class="addres btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> ADD</button>
                                                   </div>
                                                @else
                                                    <div class="col-12 mul_{{ $key }}">
                                                        <div class="row">
                                                            <div class="col-10 mt-2">
                                                               <textarea name="responsibility[]" rows="2" required>{{ $res->responsibility }}</textarea>
                                                            </div>
                                                            <div class="col-2">
                                                                <button class="btn btn-danger" onclick="deleteres({{ $key }})">DELETE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                           <div class="col-10">    
                                               <textarea name="responsibility[]" rows="2" required></textarea>
                                           </div>
                                           <div class="col-2">
                                                <button class="addres btn btn-warning"><i class="fas fa-plus-circle fa-lg"></i> ADD</button>
                                           </div>
                                        @endif
                                       <div class="multipleres">

                                       </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('candidate.section.experience') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> {{__('Back') }}</a>
                                    <input type="submit" value="Continue" class="btn btn-success">
                                </div>
                                @if(count($experience->responsible) > 0)
                                    <input type="hidden" class="dynres" value="{{ count($experience->responsible) - 1 }}">
                                @else
                                    <input type="hidden" class="dynres" value="0">
                                @endif
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
            if($(".cwork").prop("checked") == true){
                $(".experience_end_date").hide();
            }
            else
            {
                $(".experience_end_date").show();
            }
        });
        function deleteres(id)
        {
            $(".mul_"+id).remove();
        }
    </script>
@endsection