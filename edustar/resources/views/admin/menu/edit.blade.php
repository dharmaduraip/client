@extends('admin.layouts.master')
@section('title', 'Edit Menu - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Edit Menu') }}
@endslot
@slot('menu1')
{{ __('Edit Menu') }}
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
                    <h5 class="card-box">{{ __('Edit Menu') }}</h5>
                </div>
                <!-- card body started -->
                <div class="card-body">
                    <!-- form start -->
                <form action="{{url('admin/menu',$menu->id)}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{method_field('PATCH')}}
                        <!-- row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- card start -->
                                <div class="card">
                                    <!-- card body start -->
                                    <div class="card-body">
                                        <!-- row start -->
                                          <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
                                                  <div class="row">
                                                    
                                                    <!-- Title -->
                                                    <div class="form-group col-md-6">
                                                        <label>{{__("Menu title:")}} <span class="required">*</span></label>
                                                        <input name="title" value="{{ $menu->title }}" type="text" class="form-control" required
                                                          placeholder="{{ __("enter menu title") }}">
                                                      </div>
                                                      <div class="form-group col-md-6">
                                                        <label>{{ __('Status:') }}</label>
                                                        <br>
                                                        <label class="switch">
                                                          <input type="checkbox" name="status" {{ $menu->status == 1 ? "checked" : "" }}>
                                                          <span class="knob"></span>
                                                        </label>
                                                      </div> 
                                                      <div class="form-group col-md-6">
                                                        <label>{{__('Link by:')}} <span class="required">*</span></label>
                                                        <select required class="form-control select2 link_by_edit" name="link_by" id="link_by_edit">
                                                          <option {{ $menu->link_by == 'page' ? "selected" : "" }} value="page">{{ __('Pages') }}</option>
                                                          <option {{ $menu->link_by == 'url' ? "selected" : "" }} value="url">{{ __("URL") }}</option>
                                                        </select>
                                                      </div>
                                            
                                                      <div class="form-group col-md-6 pagebox_edit" id="pagebox_edit" style="{{ $menu->link_by == 'page' ? '' : 'display:none;' }}">
                                                        <label>{{__('Select pages:')}} <span class="required">*</span></label>
                                                        <select {{ $menu->link_by == 'page' ? 'required' : '' }} class="form-control page_id_edit" name="page_id"
                                                          id="page_id_edit">
                                                          @foreach($pages as $page)
                                                          <option {{ $menu->page_id == $page->id ? "selected"  : "" }} value="{{ $page->id }}">{{ $page->title }}
                                                          </option>
                                                          @endforeach
                                                        </select>
                                                      </div>
                                            
                                                      <div id="urlbox_edit" class="urlbox_edit form-group col-md-6" style="{{ $menu->link_by == 'url' ? '' : 'display:none;' }}">
                                                        <label>{{__("URL:")}} <span class="required">*</span></label>
                                                        <input value="{{ $menu->url }}" class="form-control" type="url" placeholder="{{ __("enter custom url") }}" name="url"
                                                          id="inputurl-edit">
                                                      </div>


                                                      <div class="form-group col-md-6">
                                                        <label>{{__("Position:")}} <span class="text-danger">*</span></label>
                                                        <select required class="form-control select2 link_by_position" name="position_menu" id="link_by_position">
                                                          <option  {{ $menu->position_menu == 'top' ? "selected" : "" }} value="top">{{ __('Top') }}</option>
                                                          <option  {{ $menu->position_menu == 'footer' ? "selected" : "" }} value="footer">{{ __("Footer") }}</option>
                                                        </select>
                                                      </div>
                                                      <div class="form-group col-md-6 footerbox_edit" id="footerbox_edit" style="{{ $menu->position_menu == 'footer' ? '' : 'display:none;' }}">
                                                        <label>{{__("Select footer position:")}} <span class="text-danger">*</span></label>
                                                        <select required="" class="form-control select2 footer_edit" name="footer" id="footer_edit">
                                                          <option {{ $menu->footer == 'widget2' ? "selected" : "" }}  value="widget2">{{ __("Widget2") }}</option>
                                                          <option  {{ $menu->footer == 'widget3' ? "selected" : "" }}  value="widget3">{{ __('Widget3') }}</option>
                                                          <option {{ $menu->footer == 'widget4' ? "selected" : "" }}  value="widget4">{{ __('Widget4') }}</option>
                                                        </select>
                                                      </div>
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div><!-- row end -->

                                    </div><!-- card body end -->
                                </div><!-- card end -->
                            </div><!-- col end -->
                        </div><!-- row end -->
                  </form>
                  <!-- form end -->
                  
                
                </div><!-- card body end -->
            
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