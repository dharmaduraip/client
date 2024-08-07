@extends('admin.layouts.master')
@section('title', 'Add Menu')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Add Menu') }}
@endslot
@slot('menu1')
{{ __('Menu') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
  <a href="{{url('admin/menu')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
  
    <!-- row started -->
    <div class="col-lg-12">
    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Menu') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                 <!-- form start -->
                 <form id="demo-form2" method="post" action="{{action('MenuController@store')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                          <!-- Local -->
                          <div class="form-group col-md-6">
                            <label>{{__("Menu title:")}} <span class="text-danger">*</span></label>
                            <input name="title" type="text" class="form-control" required placeholder="{{ __('enter menu title') }}">
                          </div>
                          <div class="form-group col-md-6">
                            <label>{{ __('Status:') }}</label>
                            <br>
                            <label class="switch">
                              <input type="checkbox" name="status" checked>
                              <span class="knob"></span>
                            </label>
                          </div>
                          <div class="form-group col-md-6">
                            <label>{{__("Link by:")}} <span class="text-danger">*</span></label>
                            <select required class="form-control select2" name="link_by" id="link_by">
                              <option value="page">{{ __("Pages") }}</option>
                              <option value="url">{{ __('URL') }}</option>
                            </select>
                          </div>
  
                          <div class="form-group col-md-6" id="pagebox">
                            <label>{{__("Select pages:")}} <span class="text-danger">*</span></label>
                            <select required="" class="form-control select2" name="page_id" id="page_id">
                              @foreach($pages as $page)
                              <option value="{{$page->id }}">{{ $page->title }}</option>
                              @endforeach
                            </select>
                          </div>
  
                          <div id="urlbox" class="form-group col-md-6" style="display: none;">
                            <label>{{__("URL:")}} <span class="text-danger">*</span></label>
                            <input class="form-control" type="url" placeholder="{{ __('enter custom url') }}" name="url"
                              id="inputurl">
                          </div>

                          <div class="form-group col-md-6">
                            <label>{{__("Position:")}} <span class="text-danger">*</span></label>
                            <select required class="form-control select2" name="position_menu" id="position">
                              <option value="top">{{ __('Top') }}</option>
                              <option value="footer">{{ __("Foooter") }}</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6" id="footerbox" style="display: none;">
                            <label>{{__("Select footer position:")}} <span class="text-danger">*</span></label>
                            <select required="" class="form-control select2" name="footer" id="footer_id">
                              <option value="widget2">{{ __("Widget2") }}</option>
                              <option value="widget3">{{ __('Widget3') }}</option>
                              <option value="widget4">{{ __('Widget4') }}</option>
                            </select>
                          </div>
                          <div class="form-group col-md-12">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                            {{ __("Create")}}</button>
                        </div>
                        </div>
                    </form>
                  <!-- form end -->
                </div>
                <!-- card body end -->
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<script src="{{ url('js/footermenu.js') }}"></script>

@endsection
<!-- This section will contain javacsript end -->