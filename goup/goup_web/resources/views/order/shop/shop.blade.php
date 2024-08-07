@extends('order.shop.layout.base')
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
@section('title') {{ __('Shop') }} @stop
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('assets/plugins/clockpicker/dist/bootstrap-clockpicker.min.css') }}"> 
<link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
<style type="text/css">
  .pac-container{
    z-index: 999999999!important;
  }
</style>
@stop
@section('content')
@include('common.admin.includes.image-modal')



<div class="main-content-container container-fluid px-4">

 
    
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">{{ __('Shop') }}</span>
        <h3 class="page-title">{{ __('Shop') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">@lang('store.Update_Shop')</h6>
                </div>
                <div class="col-md-12 p-3">
            <form class="validateForm" files="true">
                    @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="store_type_id">@lang('store.admin.shops.type')</label>
                            <select name="store_type_id" id="store_type_id" class="form-control" autocomplete="off">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('store.admin.shops.name') }}</label>
                            <input type="text" class="form-control" id="store_name" name="store_name" placeholder="{{ __('store.admin.shops.name') }}" value="">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('store.admin.shops.email') }}</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="{{ __('store.admin.shops.email') }}" value="" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="offer_min_amount">{{ __('store.admin.shops.minamount') }}</label>
                            <input type="text" class="form-control decimal" id="offer_min_amount" name="offer_min_amount" placeholder="{{ __('store.admin.shops.minamount') }}" autocomplete="off" >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6" id="estdeltime">
                            <label for="estimated_delivery_time">{{ __('store.admin.shops.estdeltime') }}</label>
                            <input type="number" class="form-control" id="estimated_delivery_time" name="estimated_delivery_time" placeholder="{{ __('store.admin.shops.estdeltime') }}" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="offer_percent">{{ __('store.admin.shops.offper') }}</label>
                            <input type="number" class="form-control decimal" id="offer_percent" name="offer_percent" placeholder="{{ __('store.admin.shops.offper') }}" autocomplete="off">
                        </div>
                    </div> 
                    <div class="form-row">

                        <div class="form-group col-md-6" id="isVeg">
                    
                        <label class="mr-2"><input type="radio"  class="is_veg" value = "Pure Veg" name="is_veg"> {{ __('store.admin.shops.veg') }}</label>
                        <label><input type="radio" class="is_veg" value = "Non Veg" name="is_veg"> {{ __('store.admin.shops.nonveg') }}</label>
                        <label><input type="radio" class="is_veg"value = "Mixed" name="is_veg"> {{ __('store.admin.shops.mixed') }}</label>

                        </div>
                        <div class="form-group col-md-6" id="cuisine">
                            <label for="cuisine_id">@lang('store.admin.shops.cuisname')</label>
                            <select name="cuisine_id[]" id="cuisine_id" class="form-control" multiple="multiple" >
                                
                            </select>
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="store_gst">{{ __('store.admin.shops.gst') }}</label>
                            <input type="number" class="form-control" id="store_gst" name="store_gst" placeholder="{{ __('store.admin.shops.gst') }}" value="0" autocomplete="off">
        
                        </div>
                        <div class="form-group col-md-6">
                            <label for="commission">{{ __('store.admin.shops.commission') }}</label>
                            <input type="number" class="form-control decimal" id="commission" name="commission" placeholder="{{ __('store.admin.shops.commission') }}" value="0" autocomplete="off" disabled="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="country_id">{{ __('admin.country.country_name') }}</label>
                            <select name="country_id" id="country_id" class="form-control" autocomplete="off">
                            <option value="">Select</option>

                            
                        
                            @foreach(Helper::getCountryList() as $key => $country)
                                <option value={{$key}}>{{$country}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city_id">{{ __('admin.country.city_name') }}</label>
                            <select name="city_id" id="city_id" class="form-control" autocomplete="off">
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contact_person">@lang('store.admin.shops.contactper')</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="{{ __('store.admin.shops.contactper') }}" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">{{ __('store.admin.shops.description') }}</label>
                            <textarea class="form-control" placeholder="Enter Description"  maxlength="255"  id="description" name="description" autocomplete="off"></textarea>
                            <small>(Maximum characters: 255)</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contact_number">@lang('store.admin.shops.contactno')</label>
                            <input type="number"  class="form-control phone" id="contact_number"  name="contact_number" placeholder="{{ __('store.admin.shops.contactno') }}" >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="store_location">{{ __('store.admin.shops.location') }}</label>
                            <input type="text" class="form-control" id="store_location"  name="store_location" placeholder="{{ __('store.admin.shops.location') }}" autocomplete="off" >
                            <!-- <input type="hidden" name="latitude" id="latitude" />
                            <input type="hidden" name="longitude" id="longitude" /> -->
                            <!-- <span id="map" style="display:none"></span> -->
                        </div>
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="store_packing_charges" id="packing_charges" >{{ __('store.admin.shops.packing_charges') }}</label>
                            <input type="text" class="form-control decimal" id="store_packing_charges" name="store_packing_charges" placeholder="{{ __('store.admin.shops.packing_charges') }}" autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            <div class="form-group" id="mail_request">
                                <label for="customToggle2"> @lang('store.admin.shops.free_delivery')</label>
                                <br>
                                <div class="custom-control custom-toggle">
                                    <input type="checkbox" id="free_delivery" name="free_delivery" class="custom-control-input" value ='1' autocomplete="off">
                                    <label class="custom-control-label" for="free_delivery"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 free_delivery_limit">
                            <label for="free_delivery_limit" >{{ __('store.admin.shops.free_delivery_limit') }}</label>
                            <input type="text" class="form-control decimal" id="free_delivery_limit" name="free_delivery_limit" placeholder="{{ __('store.admin.shops.free_delivery_limit') }}" autocomplete="off">
                        </div>
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="status" class="col-xs-2 col-form-label">@lang('store.admin.shops.zone')</label>
                        <select name="zone_id" id="zone_id" class="form-control">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="store_zipcode">{{ __('store.admin.shops.pincode') }}</label>
                            <input type="text" class="form-control" id="store_zipcode" name="store_zipcode" placeholder="{{ __('store.admin.shops.pincode') }}" autocomplete="off">
                        </div>
                    </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="status" class="col-xs-2 col-form-label">@lang('store.admin.shops.status')</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Onboarding</option>
                                <option value="2">Banned</option>
                            
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="picture">{{ __('admin.picture') }}</label>
                            <div class="image-placeholder w-100">
                                <img width="100" height="100" />
                                <input type="file" name="picture" class="upload-btn picture_upload">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="store_response_time">@lang('admin.setting.resturant_response_time') (Secs)</label>
                            <input type="text" class="form-control number" id="store_response_time" name="store_response_time" placeholder="@lang('admin.setting.resturant_response_time')" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bestseller">@lang('admin.setting.bestseller')</label>
                            <input type="number" min="1" class="form-control number" id="bestseller" name="bestseller" placeholder="@lang('admin.setting.bestseller')" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bestseller_month">@lang('admin.setting.bestseller_month') (In Month)</label>
                            <input type="number" class="form-control number" id="bestseller_month" name="bestseller_month" min="1" max="12" placeholder="@lang('admin.setting.bestseller_month')" >
                        </div>
                    </div>


                    <div class="form-group">
                                <label for="password-confirm">@lang('store.admin.shops.shop_open_time')</label>

                                <input id="everyday" type="checkbox" checked class="form-control" name="everyday" value="1" >
                            </div>

                            @foreach($Days as $dky=>$day)
                            <div class="row m-0 @if($dky=='ALL') everyday "  @else  singleday " style="display:none" @endif " >&nbsp;&nbsp;
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="hours_opening">{{$day}}</label>
                                        <input type="checkbox" class="chk form-control {{$dky}}" @if($dky=='ALL') checked @endif  name="day[{{$dky}}]"  data-placement="top" data-autoclose="true" value="{{$dky}}" >
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="hours_opening" class="required">@lang('store.admin.shops.open_time')</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control time-picker open_{{$dky}}" name="hours_opening[{{$dky}}]" value="00:00" data-placement="top" data-autoclose="true" required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="hours_closing" class="required">@lang('store.admin.shops.close_time')</label>

                                        <div class="input-group ">
                                            <input type="text" class="form-control time-picker close_{{$dky}}" name="hours_closing[{{$dky}}]" value="00:00" data-placement="top" data-autoclose="true" required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach




                    <br>
                   <button type="submit" class="btn btn-accent">@lang('store.Update_Shops')</button>

                </form>
        </div>     
            </div>










<!-- Address Modal -->
      <div class="modal crud-modal" id="addressModal">
         <div class="modal-dialog modal-lg  min-50vw">
            <div class="modal-content password-change">
               <!-- Add Card Header -->
               <div class="modal-header">
                  <h4 class="modal-title">Add Address</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button> 
               </div>
               <!-- Add Card body -->
               <div class="modal-body">
               <form id="address-form"  class="w-100 validateaddressForm" style= "color:red;">
                  <input type="hidden" name="id" id="address_id" value="0" />
                     <div class="col-lg-12 col-md-12 col-sm-12 card-section p-0 b-0" style= "flex-direction: row;align-items: start;">
                        <div class ="address-errors"></div>
                        <div class="col-sm-12 col-xl-12">
                           <input class="form-control search-loc-form" type="text" id="pac-input" name="map_address" placeholder="Search for area, street name.." required>
                            <p id="msg2"></p>
                           <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
                           <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
                           <div id="my_map"   style="height:300px;width:100%; margin-top: 4px" ></div>
                           <span class="my_map_form_current"><i class="material-icons my_map_form_current" style=" position: absolute; right: 30px; top: 12px;color: #495057;font-size: 18px;cursor: pointer;">my_location</i> </span>
                        </div>
                        <div class="col-sm-12 col-xl-12 p-0 card-form">
                           <div class="col-sm-12 p-0">
                              <h5 class=""><strong>@lang('user.flat_no')</strong></h5>
                              <input name="flat_no" id="flat_no" required class="form-control" type="text" placeholder="@lang('user.flat_no')">
                              <p id="msg"></p>
                           </div>
                           <div class="col-sm-12 p-0">
                              <h5 class=""><strong>@lang('user.street')</strong></h5>
                              <input name="street" id="street" required class="form-control" type="text" placeholder="@lang('user.street')">
                              <p id="msg1"></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                  <button class="btn btn-secondary  btn-block change-pswrd add_address " >@lang('user.save')</button>
                  </div>
                  </form>
               </div>
               <!-- Add Card body -->
            </div>
         </div>
      </div>














   
</div>
@stop

@section('scripts')
@parent
<script type="text/javascript" src="{{ asset('assets/plugins/clockpicker/dist/bootstrap-clockpicker.min.js') }}"></script>
<script src = "{{ asset('assets/plugins/cropper/js/cropper.js')}}" > </script> 
<script src = "{{ asset('assets/layout/js/crop.js')}}" > </script>
<script>
var blobImage = '';
var blobName = '';
$(document).ready(function()
{
    $(".phone").intlTelInput({
      //initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",
    });

     basicFunctions();
     var id = "";

     $('#store_location').on('click', function() {
        $('#addressModal').modal('show');
     });

     $('.add_address').on('click', function(e) {
        e.preventDefault();
        var map_address =  $('input[name=map_address]').val();
        if(map_address ==''){
          var msg ="choose one address";
          $('#msg2').html(msg);
          return false;
        }
       var flat_no =  $('input[name=flat_no]').val();
        if(flat_no ==''){
          var msg ="Flat Number is required";
          $('#msg').html(msg);
          return false;
        }
        var street =  $('input[name=street]').val();
        if(street ==''){
          var msg ="Street is required";
          $('#msg1').html(msg);
          return false;
        }
       
        $('#store_location').val($('input[name=map_address]').val());
        $('#addressModal').modal('hide');
     });

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
      var obj = $(this);
      if (files && files.length > 0) {
        blobName = files[0].name;
         cropImage(obj, files[0], obj.closest('.image-placeholder').find('img'), function(data) {
            blobImage = data;
         });
      }
    });

     $.ajax({
        type:"GET",
        url: getBaseUrl() + "/shop/storetypelist",
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
                $("#store_type_id").empty();
                $("#store_type_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                    $("#store_type_id").append('<option value="'+item.id+'" data-category="'+item.category+'"  >'+item.name+'</option>');
                  }
                });
                hideInlineLoader();
             }
            
    });


    $('#city_id').on('change', function(){

        var city_id =$("#city_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/shop/zonetype/"+city_id+"?type=SHOP",
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){ 
                var data = parseData(response);
                $("#zone_id").empty();
                $("#zone_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                 $("#zone_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                });

                hideInlineLoader();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                hideInlineLoader();
            }
        });
      });

    $('.clockpicker').clockpicker({
        donetext: "Done"
    });

   
   
$('#store_type_id').change(function(){
var cuisine_id=$(this).val();

$.ajax({
        type:"GET",
        url: getBaseUrl() + "/shop/cuisinelist/"+cuisine_id,
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
                $("#cuisine_id").empty();
                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                    $("#cuisine_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                  }
                });
                hideInlineLoader();
             }
    });


   })

  /* $('.clockpicker').clockpicker({
        donetext: "Done"
    });*/

    $('#free_delivery').click(function(e) {
        var isChecked = $("#free_delivery").is(":checked");
        if(isChecked){
            $("#free_delivery").val(1);
            $(".free_delivery_limit").find('input').attr('required', true);
            $(".free_delivery_limit").show();
        }   
        else{
            $("#free_delivery").val(0);
            $(".free_delivery_limit").find('input').attr('required', false);
            $(".free_delivery_limit").hide();
        }
    });

    $('#everyday').change(function() {
        if($(this).is(":checked")) {
            $('.everyday').show();
            $('.singleday').hide();
            $('.singleday .chk').prop('checked',false);
            $('.everyday .chk').prop('checked',true);
        }else{
            $('.everyday').hide();
            $('.singleday').show();
            $('.everyday .chk').prop('checked',false);
            $('.singleday .chk').prop('checked',true);
        }
    });



     if($("input[name=id]").length){
        $('#country_id').attr('readonly',true);
        $('#country_id').css('pointer-events','none');
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/shop/shops"+id;

        $.ajax({
        type:"GET",
        url: url,
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(response){
            var data = parseData(response).responseData;
            for (var i in Object.keys(data)) {
            $('#'+Object.keys(data)[i]).val( Object.values(data)[i]);
             }
             $('input[name=map_address]').val( data.store_location );
            var countryData = window.intlTelInputGlobals.getCountryData();
            var result = $.grep(countryData, function(e){ return e.dialCode == data.country_code; });
            $(".phone").intlTelInput("setCountry", result[0].iso2);
            initMap(data.latitude, data.longitude);
           

             $("select[name=store_type_id] option[value='" + data.store_type_id+ "']" ).prop("selected",true);
            // $("select[name=store_type_id]").trigger('change');

             loadcity(data.city_data,data.city_id);
             loadzone(data.zone_data,data.zone_id);
             loadcuisines(data.cuisine_data,data.cui_selectdata);
             $("input[name='is_veg'][value='"+data.is_veg +"']").prop('checked', true);
             if(data.free_delivery == 1){
                 $("input[name='free_delivery'][value='"+data.free_delivery +"']").prop('checked', true);
                 var isChecked = $("#free_delivery").is(":checked");
                 $("#free_delivery").val(1);
                 $(".free_delivery_limit").find('input').attr('required', true);
                 $(".free_delivery_limit").show();  
        
             } else {
                $("#free_delivery").val(0);
                $(".free_delivery_limit").find('input').attr('required', false);
                $(".free_delivery_limit").hide();
             }
            //  $('.is_veg').val(data.is_veg).attr("checked", true);
             $('#password').val("");
             $("#password").rules('remove', 'required');
             $("#confirmpassword").rules('remove', 'required');
             if(data.picture){ 
                $('.image-placeholder img').attr('src', data.picture);
            }

             if(data.time_data[0].store_day=='ALL'){
                $('#everyday').val(1).attr('checked',true);
                $('.open_ALL').val(data.time_data[0].store_start_time);
                $('.close_ALL').val(data.time_data[0].store_end_time);

             }else{
                $('#everyday').trigger('click');
                $('.chk').prop('checked',false);
                $.each(data.time_data,function(key,day){
                $('.open_'+day.store_day).val(day.store_start_time);
                $('.close_'+day.store_day).val(day.store_end_time);
                $('.'+day.store_day).prop('checked',true);
                });

               
             }
             loadstorecategory();
              hideInlineLoader();
             
             }
    });
       
     }

     function loadcity(city_data,city_id){
        $.each(city_data,function(key,item){
            var selected="";
            if(city_id==item.city.id){
               selected="selected";
            }
            $("#city_id").append('<option value="'+item.city.id+'" '+selected+ ' >'+item.city.city_name+'</option>');
        });
     }

     function loadcuisines(cuisines_data,cuisines_id){
         $.each(cuisines_data,function(key,item){
             var selected="";
           if (jQuery.inArray(item.id, cuisines_id)!='-1')
            {
               selected="selected";
            }
            $("#cuisine_id").append('<option value="'+item.id+'" '+selected+ ' >'+item.name+'</option>');
         });
         //$('#cuisine_id').val(cuisines_id);
    }

    function loadzone(zone_data,zone_id){
        $.each(zone_data,function(key,item){
            var selected="";
            if(zone_id==item.id){
               selected="selected";
            }
            $("#zone_id").append('<option value="'+item.id+'" '+selected+ ' >'+item.name+'</option>');
        });
     }
     $('#store_type_id').change(function(){
        loadstorecategory();
     });

    function loadstorecategory(){
        var store_type = $('#store_type_id').find(':selected').data('category');
        if(store_type == "OTHERS"){

            $("#estimated_delivery_time").val('');
            $('.is_veg input').prop('checked', false);
            $("#estimated_delivery_time").rules('remove', 'required');
            $("#is_veg").rules('remove', 'required');
            $("#estdeltime").css("display", "none");
            $("#cuisine").css("display", "none");
            $("#isVeg").css("display", "none");
            $("#packing_charges").html("Shipping Charges");

        }else{
            
            // $("#estimated_delivery_time").val('');
            $('.is_veg input').prop('checked', true);
            $("#estimated_delivery_time").rules('add', 'required');
            $("#is_veg").rules('add', 'required');
            $("#estdeltime").css("display", "block");
            $("#cuisine").css("display", "block");
            $("#isVeg").css("display", "block");
            $("#packing_charges").html("Packing Charges");
        }
    }



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            store_name: { required: true },
            store_type_id: { required: true },
            is_veg: { required: true },
            email: { required: true },
            cuisine_id: { },
            // cuisine_id: { required: true },
            country_id: { required: true },
            city_id: { required: true },
            estimated_delivery_time: { required: true },
            contact_number: { required: true, minlength:10},
            store_location: { required: true },
            password: { required: true },
            confirmpassword: { equalTo: "#password" },
            store_zipcode: { required: true },
            zone_id: { required: true },
          
		},

		messages: {
			store_name: { required: "Shop Name is required." },
			store_type_id: { required: "Store Type is required." },
            is_veg: { required: "Veg Type is required." },
            email: { required: " Email is required." },
            cuisine_id: { },
            // cuisine_id: { required: "Cuisines is required." },
            country_id: { required: "country is required." },
            city_id: { required: "city is required." },
            estimated_delivery_time: { required:"Delivery Time is required."},
            contact_number: { required: "Contact Number is required." },
            store_location: { required: "Location is required." },
            password: { required: "Password is required." },
            store_zipcode: { required: "Zipcode is required." },
            zone_id: { required: "Zone is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form) {

            var data = new FormData();

            var formGroup = $(".validateForm").serialize().split("&");
            console.log(formGroup);
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append(decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );
            data.append('flat_no', $('input[name=flat_no]').val());
            data.append('street', $('input[name=street]').val() );
            data.append('latitude', $('input[name=latitude]').val());
            data.append('longitude', $('input[name=longitude]').val());

            
            var url = getBaseUrl() + "/shop/shops"+id;
                $.ajax({
                url: url,
                type: "post",
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    Authorization: "Bearer " + getToken('shop')
                },
                beforeSend: function (request) {
                    showInlineLoader();
                },
                success: function(response, textStatus, jqXHR) {
                    var data = parseData(response);
                    alertMessage("Success", data.message, "success");
                    hideInlineLoader();
                        // setTimeout(function(){
                        //     location.reload();
                        //     }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 401 && getToken(guard) != null) {
                        refreshToken(guard);
                    } else if (jqXHR.status == 401) {
                        window.location.replace("/admin/login");
                    }

                    if (jqXHR.responseJSON) {
                        alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                    }
                    hideInlineLoader();
                }
            });
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  

});
</script>
<script>
   if(typeof localStorage.landmark !== 'undefined') {
      $('.landmark').html(window.localStorage.getItem('landmark'));
   }
   if(typeof localStorage.city !== 'undefined') {
      $('.city').html(window.localStorage.getItem('city'));
   }
   if(typeof localStorage.latitude !== 'undefined') {
      $('#latitude').val(window.localStorage.getItem('latitude'));
   }
   if(typeof localStorage.longitude !== 'undefined') {
      $('#longitude').val(window.localStorage.getItem('longitude'));
   }
   
   
    var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');

    function initMap(shop_latitude = '13.066239', shop_langitude = '80.274816') { 

        var userLocation = new google.maps.LatLng(
                shop_latitude,
                shop_langitude
            );
        
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        /*var infowindow = new google.maps.InfoWindow({
            content: "Shop Location",
        });*/

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);
        //infowindow.open(map, marker);

        if (navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(function(location) { 
                var userLocation = new google.maps.LatLng(
                    location.coords.latitude,
                    location.coords.longitude
                );
            });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        google.maps.event.addListener(map, 'click', updateMarker);
        google.maps.event.addListener(marker, 'dragend', updateMarker);

       

        function updateMarker(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                        updateForm(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

            marker.setPosition(event.latLng);
            map.setCenter(event.latLng);
        }

        autocomplete.addListener('place_changed', function(event) {
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (place.hasOwnProperty('place_id')) {
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                updateLocation(place.geometry.location);
            } else {
                service.textSearch({
                    query: place.name
                }, function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        updateLocation(results[0].geometry.location, results[0].formatted_address);
                        input.value = results[0].formatted_address;

                    }
                });
            }
        });

        function updateLocation(location) {
            map.setCenter(location);
            marker.setPosition(location);
            marker.setVisible(true);
            //infowindow.open(map, marker);
            updateForm(location.lat(), location.lng(), input.value);
        }
    }

      function getcustomaddress(latLngvar){
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLngvar}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //console.log(results[0]);
                    if (results[0]) {
                        
                        //input_cur.value = results[0].formatted_address;
                         
                        updateForm(latLngvar.lat, latLngvar.lng, results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
      }

        function updateForm(lat, lng, addr) { 
            //console.log(lat,lng, addr);
            latitude.value = lat;
            longitude.value = lng;
            var address = addr;
            var landmark = address.split(',')[0];
            var city = address.replace(address.split(',')[0]+',',' ');
            $('#pac-input').val(addr);
           /* window.localStorage.setItem('landmark', landmark);
            window.localStorage.setItem('city', city);
            window.localStorage.setItem('latitude', lat);
            window.localStorage.setItem('longitude', lng);*/
            $('.landmark').html(landmark);
            $('.city').html(city);
            //shoplist();
        }
    $('.my_map_form_current').on('click',function(){
        //$('#my_map_form_current').submit();
        var current_latitude = 13.0574400;
       var current_longitude = 80.2482605;

       if( navigator.geolocation ) {
          navigator.geolocation.getCurrentPosition( success, fail );
       } else {
           console.log('Sorry, your browser does not support geolocation services');
           initMap();
       }
       function success(position)
       {
           document.getElementById('longitude').value = position.coords.longitude;
           document.getElementById('latitude').value = position.coords.latitude

           if(position.coords.longitude != "" && position.coords.latitude != ""){
               longitude = position.coords.longitude;
               latitude = position.coords.latitude;
                var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
                getcustomaddress(latlng);

           }
       }
       function fail()
       {
           // Could not obtain location
           console.log('unable to get your location');
       }

    });

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
@stop