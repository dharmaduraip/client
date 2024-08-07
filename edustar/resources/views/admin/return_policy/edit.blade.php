@extends('admin.layouts.master')
@section('title','Edit Refund Policy')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Edit Refund Policy') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Refund Policy') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
  <a href="{{ url('refundpolicy')}}" class="btn btn-primary-rgba"><i
      class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
  </div>
</div>
@endslot

@endcomponent
<div class="contentbar">
  <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit') }} {{ __('Refund Policy') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form2" method="post" action="{{url('refundpolicy/'.$return->id)}}" data-parsley-validate
            class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputName">{{ __('Name') }}:</label>
                <input type="text" class="form-control" name="name" id="exampleInputTitle" value="{{$return->name}}">
              </div>
              <div class="col-md-6">
                <label for="exampleInputSlug">{{ __('Days') }}:</label>
                <input type="text" class="form-control" name="days" id="exampleInputPassword1"
                  value="{{$return->days}}">
               
              </div>
              <br>
              <br>
              <br>

              
          

            
              <div class="col-md-12 mt-3">
                <label for="exampleInputDetails">{{ __('Detail') }}:</label>
                <textarea name="detail" rows="5" class="form-control">{{$return->detail}}</textarea>
              </div>
           
            <br>
            <div class="col-md-6 mt-3">
              <label for="exampleInputTit1e">{{ __('Status') }}:</label>
              <input id="cb10" type="checkbox" class="custom_toggle stch{{ $return->id }}" name="status" onchange="checkstatus({{ $return->id }})"
                {{ $return->status==1 ? 'checked' : '' }} />
            
              
            </div>

          

            <div class="col-md-12 mt-3">
             
                <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                  {{ __('Reset') }}</a>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{ __('Update') }}</button>
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
  tinymce.init({
    selector: '#editor1,#editor2,.editor',
    height: 350,
    menubar: 'edit view insert format tools table tc',
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_prefix: "{path}{query}-{id}-",
    autosave_restore_when_empty: false,
    autosave_retention: "2m",
    image_advtab: true,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks fullscreen',
      'insertdatetime media table paste wordcount'
    ],
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
    content_css: '//www.tiny.cloud/css/codepen.min.css'
  });

  function checkstatus(id)
  {
    if($(".stch"+id).prop("checked") != true)
    {
      $.ajax({
          type: "GET",
          dataType: "json",
          url: "{{ route('refundpolicystatus.status') }}",
          data: {
              'status': 0,
              'id': id
          },
          success: function(data)
          { 
              if(data.msg == undefined)
              {
                  var warning = new PNotify( {
                      title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                      desktop: true, icon: 'feather icon-thumbs-down'
                      }
                  });
                  warning.get().click(function() {
                      warning.remove();
                  });
              }
              else
              {
                  alert("You can't change this status. because, This refund policy is already used in some course.");
                  $(".stch"+id).trigger("click");
              }
          }
      });
    }
  }
</script>
@endsection