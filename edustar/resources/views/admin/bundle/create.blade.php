@extends('admin.layouts.master')
@section('title','Create a new bundle')
@section('breadcum')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Bundle Courses') }}
@endslot
@slot('menu1')
{{ __('Add Bundle Course') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('bundle')}}" class="float-right btn btn-dark-rgba mr-2"><i
        class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a> </div>
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
          <h5 class="card-box">{{ __('Add Bundle Course') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{url('bundle/')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="hidden" class="form-control" name="user_id" id="exampleInputTitle"
              value="{{ Auth::User()->id }}" required>
            <div class="row">
              <div class=" col-md-12">

                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('Title') }}: <sup
                      class="text-danger">*</sup></label>
                  <input type="title" class="form-control" name="title" id="exampleInputTitle"
                    placeholder="{{ __('Enter') }} {{ __('Title') }}" value="" required>

                </div>

                <div class="form-group">
                  <label>{{ __('Select Courses') }}: <span class="text-danger">*</span></label>
                  <select class="form-control select2" name="course_id[]" multiple="multiple" size="5" row="5"
                    placeholder="{{ __('SelectCourse') }}">


                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}">{{ $cat->title }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('Short Detail') }}: <sup
                      class="text-danger">*</sup></label>
                  <textarea id="short_detail" name="short_detail" rows="4" class="form-control"
                    placeholder="{{ __('Enter') }} {{ __('Short Detail') }}"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('Detail') }}: <sup
                      class="text-danger">*</sup></label>
                  <textarea id="detail" name="detail" rows="5" class="form-control"
                    placeholder="{{ __('Enter') }} {{ __('Detail') }}"></textarea>
                </div>
                <div class="form-group">
                  <label>{{ __('Preview Image') }}:<sup class="redstar">*</sup></label> - <p class="inline info">{{ __('size') }}: 250x150</p>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" name="preview_image" class="custom-file-input" id="image"
                        aria-describedby="inputGroupFileAddon01" accept=".jpeg,.jpg,.png">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputDetails">{{ __('Paid') }}:</label>
                        <input id="cb111" type="checkbox" class="custom_toggle" name="type"
                          /><br>
                      </div>
                      <div class="d-none" id="doabox">
                        <div>
                          <label for="exampleInputSlug">{{ __('Price') }}: <sup class="text-danger">*</sup></label>
                          <input  type="number" min="1" class="form-control" name="price" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('Price') }}"
                                      value="">
                        </div>
                      <div>
                      <br>
                      <label for="exampleInputSlug">{{ __('Discount Price') }}: <sup class="text-danger">*</sup></label>
                      <input type="number" min="1" class="form-control" name="discount_price" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('Discount Price') }}"
                          value="">
                    </div>
                 
                  </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        @if(Auth::User()->role == "admin")
                        <label for="exampleInputDetails">{{ __('Featured') }}:</label>

                        <input id="status_toggle" type="checkbox" name="featured"  class="custom_toggle" id="cb1"  />
                        @endif
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        @if(Auth::User()->role == "admin")
                        <label for="exampleInputDetails">{{ __('Status') }}:</label>
                        <input id="status_toggle" type="checkbox"  name="status" class="custom_toggle" id="cb3"  />
                         @endif
                      </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-group">
                          <label for="">{{ __('Duration') }}: </label>
                          <input id="duration1" type="checkbox" class="custom_toggle" name="duration_type"
                              checked/>

                          <label class="tgl-btn" data-tg-off="days" data-tg-on="month"
                              for="duration_type"></label>
                              <br>
                          <div class="form-group" id="duration">
                              <small class="text-muted text-info"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }},</small>
                              <small class="text-muted text-info"> {{ __('when Disabled duration can be in days') }}.</small>
                              <label for="exampleInputSlug">{{ __('Bundle Expire Duration') }} </label>

                              <input min="1" class="form-control" name="duration" type="number" 
                                  
                                  placeholder="{{ __('Enter') }} {{ __('Duration') }}">
                      </div>
                    </div>
                              </div>
                 
                  </div>

                </div>
                <div class="form-group">
                  <label for="cbToggleSubscription">{{ __('Subscription') }}:</label>
                  <input id="subscription1" type="checkbox" name="is_subscription_enabled" class="custom_toggle"
                     />
                     <br>
                  
                  <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Subscription
                      bundle works with stripe payment only') }}.</small><br>
                  <small class="text-info"> {{ __('Enable it only when you have setup stripe') }}.</small>

                <br>
                  <div id="subscription" class="form-group display-none ">
                   
            <div class="form-group">

                      <label>{{ __('BillingPeriod') }}</label>
                      <select class="form-control select2" name="billing_interval">
                        <option value="day">{{ __('Daily') }}</option>
                        <option value="week">{{ __('Weekly') }}</option>
                        <option value="month">{{ __('Monthly') }}</option>
                        <option value="year">{{ __('Yearly') }}</option>
                      </select>
                    </div>
                  </div>
              </div>
              
                <div class="form-group">
                  <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</a>
                  <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                    {{ __('Create') }}</button>
                </div>

                <div class="clear-both"></div>
              </div>




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
        $('#j').val(+$(this).prop('checked'))
      })
    })

    $(function () {
      $('#cb3').change(function () {
        $('#test').val(+$(this).prop('checked'))
      })
    })

 
    $('#preview').on('change', function () {

      if ($('#preview').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');
      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

    });

    $("#cb3").on('change', function () {
      if ($(this).is(':checked')) {
        $(this).attr('value', '1');
      } else {
        $(this).attr('value', '0');
      }
    });

    $(function () {

      $('#ms').change(function () {
        if ($('#ms').val() == 'yes') {
          $('#doabox').show();
        } else {
          $('#doabox').hide();
        }
      });

    });

    $(function () {

      $('#ms').change(function () {
        if ($('#ms').val() == 'yes') {
          $('#doaboxx').show();
        } else {
          $('#doaboxx').hide();
        }
      });

    });

    $(function () {

      $('#msd').change(function () {
        if ($('#msd').val() == 'yes') {
          $('#doa').show();
        } else {
          $('#doa').hide();
        }
      });

    });

    $(function () {
      var urlLike = '{{ url('
      admin / dropdown ') }}';
      $('#category_id').change(function () {
        var up = $('#upload_id').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function (data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function (id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });

    $(function () {
      var urlLike = '{{ url('
      admin / gcat ') }}';
      $('#upload_id').change(function () {
        var up = $('#grand').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function (data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function (id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
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

</script>
  <script>
    (function($) {
      "use strict";
      $(function(){
          $('#duration1').change(function(){
            if($('#duration1').is(':checked')){
              $('#duration').show('fast');
            }else{
              $('#duration').hide('fast');
            }
          });
         
            
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
    
@endsection