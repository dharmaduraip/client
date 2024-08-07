@extends('admin.layouts.master')
@section('title','Edit Batch')
@section('maincontent')

@component('components.breadcumb',['secondaryactive' => 'active'])

@slot('heading')
{{ __('Batches') }}
@endslot

@slot('menu1')
{{ __(' Edit Batch') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('batch') }}" class="float-right btn btn-primary mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent
<div class="contentbar">
   @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Batch') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{route('batch.update',$cor->id)}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="form-group col-md-6">
                  <label for="exampleInputTit1e">{{ __('Title') }}:<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{ $cor->title }}">
                </div>
                <div class="form-group col-md-6">
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('Status') }}</label>
                  <input type="checkbox" class="custom_toggle" name="status"  {{ $cor->status==1 ? 'checked' : '' }}/>
                 
                @endif
                </div>
                <div class="form-group col-md-6">
                  <label>{{ __('Select Courses') }}:  <span class="redstar">*</span></label>
                  <select id="course_id" class="form-control js-example-basic-single" name="allowed_courses"
                    size="5" row="5" placeholder="{{ __('Select') }} Courses">


                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}"
                      {{ $cat->id == $cor->allowed_courses ? 'selected' : ''}}>
                      {{ $cat->title }}
                    </option>
                 
                    @endif

                    @endforeach

                  </select>
                </div>


                <div class="form-group col-md-6">
                  <label>{{ __('Select') }} {{ __('Users') }}: <span
                      class="redstar">*</span></label>
                  <select id="upload_id" class="form-control js-example-basic-single" name="allowed_users[]" multiple="multiple"
                    size="5" row="5" placeholder="{{ __('Select') }} {{ __('Users') }}">



                    @foreach ($users as $user)
                    @if($user->status == 1)
                    <option value="{{ $user->id }}"
                      {{in_array($user->id, $cor['allowed_users'] ?: []) ? "selected": ""}}>{{ $user->user->fname }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>



            </div>


                <div class="form-group">
                  <label for="exampleInputDetails">{{ __('Detail') }}:<sup
                      class="redstar">*</sup></label>
                  <textarea name="detail" rows="3" class="form-control">{!! $cor->detail !!}</textarea>
                </div>

              
                  <br>
<div class="row">
                <div class="form-group col-md-6">
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
                </div>
                <div class="col-md-6">
                  @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                  <img src="{{ url('/images/batch/'.$cor->preview_image) }}" class="image_size"/>
                  @else
                  <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
                  @endif
                </div>
</div>
                

             

                <div class="form-group">
                  <a href="javascript:window.location.reload(true)" class="btn btn-danger"><i class="fa fa-ban"></i>
                    {{ __('Reset') }}</a>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{ __('Update') }}</button>
                </div>
                <div class="clear-both"></div>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script>
  //  $(document).on('change','#course_id',function(){
    $(document.body).on('change','#course_id',function(){
  
          var up = $('#upload_id').empty();
          var cat_id = jQuery('#course_id').val();
  
          
         
          if (cat_id) {
            //alert(cat_id);
            $.ajax({
              type: "GET",
              url: @json(url('dropdowns')),
              data: {
                catId: cat_id
              },
              success: function (data) {
                // up.append('<option value="0">Please Choose</option>');
                  $.each(data, function(key,value) {
                    console.log(value);
  
                    $('#upload_id')
                      .append($("<option></option>")
                      .attr("value", value.id)
                      .text(value.user.fname)); 
  
                  // up.append($('<option>', {
                  //   value: value.id
                  //   text: 'hello'
                  // }));
                    // $.each( value, function( index2, sub_record ) {
                      
                    // });
                  }); 
  
                // var data = JSON.parse(data);
                // console.log(data);
          //       up.append('<option value="0">Please Choose</option>');
          //       $.each(data, function (key,val) {
          //         console.log(val);
          //         up.append($('<option>', {
          //           value: '1'
          //           text: 'hello'
          //         }));
          //       });
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
              }
            });
          }
        });
  
  </script>
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

@endsection