@extends('admin.layouts.master')
@section('title','Edit Bundle')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Bundle Courses') }}
@endslot

@slot('menu1')
{{ __(' Edit Bundle Course') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
    <a href="{{ url('bundle') }}" class="float-right btn btn-primary mr-2"><i
            class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent

<div class="contentbar">
    @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-box">{{ __('Edit Bundle Course') }} </h5>
                </div>
                <div class="card-body ml-2">
                    <form action="{{ route('bundle.update', $cor->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputTit1e">{{ __('Title') }}:<sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="title" id="exampleInputTitle"
                                        value="{{ $cor->title }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Select Courses') }}: <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="course_id[]" multiple="multiple" size="5" row="5"
                                        placeholder="{{ __('SelectCourse') }}">
                
                
                                        @foreach ($courses as $cat)
                                        @if ($cat->status == 1)
                                        <option value="{{ $cat->id }}"
                                            {{ in_array($cat->id, $cor['course_id'] ?: []) ? 'selected' : '' }}>
                                            {{ $cat->title }}
                                        </option>
                                        @endif
                
                                        @endforeach
                
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputDetails">{{ __('Short Detail') }}:<sup
                                            class="text-danger">*</sup></label>
                                    <textarea id="short_detail" name="short_detail" rows="3" class="form-control"
                                        required>{{  $cor->short_detail }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputDetails">{{ __('Detail') }}:<sup
                                            class="text-danger">*</sup></label>
                                    <textarea id="detail" name="detail" rows="3" class="form-control"
                                        required>{!!  $cor->detail !!}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ __('Image') }}:<sup class="redstar">*</sup></label>
                                    <small class="text-muted text-info"><i class="fa fa-question-circle"></i>
                                        {{ __('Recommended-size') }} (1375 x 409px)</small>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image"
                                                aria-describedby="inputGroupFileAddon01" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                        </div>
                                    </div>
                                    @if ($cor['preview_image'] !== null && $cor['preview_image'] !== '')
                                    <img src="{{ url('/images/bundle/' . $cor->preview_image) }}" height="70px;"
                                        width="70px;" />
                                    @else
                                    <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course"
                                        class="img-fluid">
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label for="exampleInputDetails">{{ __('Paid') }}:</label>
                                        <input id="cb111" type="checkbox" class="custom_toggle" name="type"
                                            {{ $cor->type == '1' ? 'checked' : '' }} />
                                            <br>
    
                                        </div>

                                            <div @class(['d-none' => $cor->type =='0']) id="doabox">
                                                <div>
                                                    <label for="exampleInputSlug">{{ __('Price') }}: <sup
                                                            class="text-danger">*</sup></label>
                                                    <input {{ $cor->type == '1' ? 'required' : '' }} type="number" min="1" class="form-control" name="price"
                                                        id="exampleInputPassword1"
                                                        placeholder="{{ __('Enter') }} {{ __('Price') }}"
                                                        value="{{ $cor->price }}">
                                                </div>
        
                                                    <div>
                                                        <br>
                                                        <label for="exampleInputSlug">{{ __('Discount Price') }}: <sup
                                                                class="text-danger">*</sup></label>
                                                        <input type="number" min="1" class="form-control" name="discount_price"
                                                            id="exampleInputPassword1"
                                                            placeholder="{{ __('Enter') }} {{ __('DiscountPrice') }}"
                                                            value="{{ $cor->discount_price }}">
                                                    </div>
                                            </div>
                                   
                                    </div>
                                    
                                   
                                   
   
                                    <div class="col-md-3">
                                <div class="form-group">
                                    @if (Auth::User()->role == 'admin')
                                    <label for="exampleInputTit1e">{{ __('Featured') }}:</label>
                                    <input id="status" type="checkbox" class="custom_toggle" name="featured"
                                        {{ $cor->featured == 1 ? 'checked' : '' }} />
    
    
                                    @endif
                                </div>
                                    </div> 
                                    <div class="col-md-3">
                              
                                <div class="form-group">
                                    <label for="cbToggleSubscription">{{ __('Subscription') }}:</label>
                                    <input id="subscription1" type="checkbox"  name="is_subscription_enabled" class="custom_toggle"
                                        {{ $cor->is_subscription_enabled ? 'checked' : '' }} />

                                

                                    <small class="text-muted text-info"><i class="fa fa-question-circle"></i>{{ __('Subscription
                                        bundle works with stripe payment only') }} .</small><br>
                                    <small class="text-muted text-info">{{ __('Enable it only when you have setup stripe') }} .</small>

                                   
                                    <br>
                                    <div id="subscription"
                                        style="{{ $cor['is_subscription_enabled'] ? '' : 'display:none' }}">

                                        @php
                                        $selectedPeriod =$cor->billing_interval;
                                        @endphp
                                        <label>{{ __('BillingPeriod') }}</label>
                                        <select class="form-control" name="billing_interval">
                                            <option value="day" {{ $selectedPeriod == 'day' ? 'selected' : '' }}>
                                                {{ __('Daily') }}</option>
                                            <option value="week" {{ $selectedPeriod == 'week' ? 'selected' : '' }}>
                                                {{ __('Weekly') }}</option>
                                            <option value="month" {{ $selectedPeriod == 'month' ? 'selected' : '' }}>
                                                {{ __('Monthly') }}</option>
                                            <option value="year" {{ $selectedPeriod == 'year' ? 'selected' : '' }}>
                                                {{ __('Yearly') }}</option>
                                        </select>

                                    </div>
                                </div>

                                    </div>
                                    <div class="col-md-3">
                            

                                       

                            
                            <div class="form-group">
                                <label for="">{{ __('Duration') }}: </label>
                                <input id="duration1" type="checkbox" class="custom_toggle" name="duration_type"
                                    {{ $cor->duration_type == "m" ? 'checked' : '' }} />
                                <small class="text-muted text-info"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }},</small>
                              <small class="text-muted text-info"> {{ __('when Disabled duration can be in days') }}.</small>
                                    <div @class(['d-none' =>$cor->duration_type == "d"]) id="duration">
                                        <label for="exampleInputSlug">{{ __('Bundle Expire Duration') }}</label>
                                        <input min="1" class="form-control" name="duration" type="number" id="duration2"
                                            value="{{ $cor->duration }}"
                                            placeholder="{{ __('Enter') }} Duration">
                                    </div>

                            </div>

                                


                   
                        </div>
                        </div>
                </div>
               <div class="form-group col-md-12 mt-3">
                                    @if (Auth::User()->role == 'admin')
                                    <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                                    <input id="status" type="checkbox" class="custom_toggle" name="status"
                                        {{ $cor->status == 1 ? 'checked' : '' }} />

                                   

                                   
                                    @endif
                                </div>
                <div class="form-group col-md-12">
                    <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                        {{ __('Reset') }}</a>
                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                        {{ __('Update') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')

<script>
    (function ($) {
        "use strict";


        $(function () {
            $('.js-example-basic-single').select2();
        });

        $(function () {
            $('#cb1').change(function () {
                $('#f').val(+$(this).prop('checked'))
            })
        })

        $(function () {
            $('#cb3').change(function () {
                $('#test').val(+$(this).prop('checked'))
            })
        })

        $(function () {

            $('#murl').change(function () {
                if ($('#murl').val() == 'yes') {
                    $('#doab').show();
                } else {
                    $('#doab').hide();
                }
            });

        });

        $(function () {

            $('#murll').change(function () {
                if ($('#murll').val() == 'yes') {
                    $('#doabb').show();
                } else {
                    $('#doab').hide();
                }
            });

        });

        $('#preview').on('change', function () {

            if ($('#preview').is(':checked')) {
                $('#document1').show('fast');
                $('#document2').hide('fast');

            } else {
                $('#document2').show('fast');
                $('#document1').hide('fast');
            }

        });

    })(jQuery);
</script>



<script>
    (function($) {
      "use strict";
      $(function(){
          $('#subscription1').change(function(){
            if($('#subscription1').is(':checked')){
              $('#subscription').show('fast');
            }else{
              $('#subscription').hide('fast');
            }
          });
         
            
      });
    })(jQuery);
    </script>
  
  

<script>
    $('#cb111').on('change',function(){
  if($('#cb111').is(':checked')){
    $('#doabox').addClass('d-block').removeClass('d-none');
    $('#priceMain').prop('required','required');
  }else{
    $('#doabox').addClass('d-none').removeClass('d-block');
    $('#priceMain').removeAttr('required');
  }
  });
  


    $('#duration1').on('change',function(){
  if($('#duration1').is(':checked')){
    $('#duration').addClass('d-block').removeClass('d-none');
    $('#duration2').prop('required','required');
  }else{
    $('#duration').addClass('d-none').removeClass('d-block');
    $('#duration2').removeAttr('required');
  }
  });
</script>

@endsection