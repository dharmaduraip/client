{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
<!DOCTYPE html>
<html>

<head>
    <title>
    {{ Helper::getSettings()->site->site_title }}
      </title>
      <meta charset='utf-8'>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <meta content='website' property='og:type'>
      <link rel="shortcut icon" type="image/png" href="{{ Helper::getFavIcon() }}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/landing.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/ionicons.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/linearicons.css')}}"/>
      <link rel="stylesheet" type='text/css' href="{{ asset('assets/plugins/owl-carousel/css/owl.carousel.min.css')}}">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/clockpicker-wearout/css/jquery-clockpicker.min.css')}}"/>
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/services.css')}}"/> -->
</head>

<body class='index'>
<div id="toaster" class="toaster"></div>
@include('common.user.includes.header')
    <section class="dis-column banner-carousel">
        <div id="sync1" class="owl-carousel owl-theme">
          
        </div>
    </section>
    <section class="services-list">
        <div class="result-show">
                <div class="col-xl-2 col-md-4 col-sm-12 location dis-center">
                    <!-- <span class="mr-2">Choose Location</span> -->
                    <a class="btn btn-primary @if(Helper::getDemomode() != 1)  dropdown-toggle  @endif location-dropdown current_city" data-toggle="dropdown"
                        id="dropdownMenuButton">
                    </a>
                    @if(Helper::getDemomode() != 1)  <div class=" dropdown-menu city_list"></div>  @endif 
                </div>
                @if(Helper::getDemomode() == 1) <div class="col-sm-12" style="text-align:center"> <span style="color:red">** Demo Mode : {{ __('admin.demomode_city') }} </span> </div> @endif 
                <div class="col-sm-12 col-md-6 col-xl-4 service-search d-none">
                    <!-- <span class="fa fa-search"
                        style=" position: absolute; left: 25px; top: 38%;color: #7e8085;font-size: 14px;"></span> -->
                    <input class="form-control " type="text" name="order-location" placeholder=" Search for services"
                        required="">
                </div>
        </div>
        <div class="container-fluid">
            <div class="dis-column mb-4">
                <hr>
                <h5 class="service-heading txt-primary">{{ __('Services') }}</h5>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="rides" class="col-md-12 col-lg-12 col-sm-12 p-0 dis-center flex-wrap">
                       
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
      <!-- Notification Modal -->
      <div class="modal" id="notification">
            <div class="modal-dialog">
               <div class="modal-content">
                  <!-- Notification Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">{{ __('Notification') }}</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Notification body -->
                  <div class="modal-body" id="notification_detail">
                  </div>
               </div>
            </div>
      </div>
      <!-- Notification Modal --> 
       <!-- Choose service popup-->
       <div class="modal" id="serviceModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Emergency Contact Header -->
               <div class="modal-header">
                  <h5 class="modal-title">{{ __('Choose Service') }}</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>

               <div class="modal-body">
                     <form>
                        <p>{{ __('Sub Category') }}</p>
                        <select name="sub_category" id="sub_category" class="form-control">
                              <option value="">Select</option>
                        </select>
                        <p>{{ __('Service') }}</p>
                        <select name="service" id="service" class="form-control">
                              <option value="">Select</option>
                        </select>
                     
                     <div id = "quantity_value" class="d-none">
                        <p>{{ __('Quantity') }}</p>
                        <input type ="text" class="form-control" value="1" name="quantity" minlength="1" id="quantity"/>
                     </div>
                     </form>
               </div>
               <!-- Emergency Contact footer -->
               <div class="modal-footer">
                  <a  class="btn btn-primary btn-block service_id">{{ __('Next') }} <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
      </div>
      <!-- Emergency Contact Modal -->

    <div id="toggle-bg" onclick="closeToggle()"></div>
    <div class="ongoing-service">
        <div id="sideToggle" class="side-toggle ">
            <a href="javascript:void(0)" class="closebtn" onclick="closeToggle()">&times;</a>
            <ul class="ongoing-list ongoing_list"></ul>
        </div>
        <div class="service-text dis-ver-center p-0">
            <div class="active" onclick="openToggle()">
                <span id="heading" class="slider-heading">{{ __('OnGoing Services') }}</span>
                <!-- <span class="server-status" type="up"></span> -->

            </div>
        </div>
    </div>
    <!--Footer Content Start-->
    <section class="footer" style="position:inherit">
        <div class="container">
            <div class="row m-0">
                <div class="col-md-12 col-sm-12 dis-center">
                    <div class="copyright_text">
                        <p>&copy; Copyrights 2020 All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Footer Content End-->



<script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/popper.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/clockpicker-wearout/js/jquery-clockpicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script src="{{ asset('assets/layout/js/script.js')}}"></script>
<script src="{{ asset('assets/layout/js/api.js')}}"></script>
<script>
   window.room = '{{base64_decode(Helper::getSaltKey())}}';
   window.socket_url = '{{Helper::getSocketUrl()}}';
</script>
<script>

    if(getToken("user") == null || getToken("user").id == 0 ) {
      
      var base_url_data = JSON.parse(decodeHTMLEntities('{{$base}}'));

      for(var i in Object.keys(base_url_data)) {
          var key = String(Object.keys(base_url_data)[i]);
          var value = String(Object.values(base_url_data)[i]);
          localStorage.setItem(key, value);
       }

      setBaseUrl('{{$base_url}}');
    }

    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function openToggle() {
        document.getElementById("toggle-bg").style.width = "100%";
        document.getElementById("sideToggle").style.right = "-10px";
        document.getElementById("heading").style.right = "310px";
    }

    function closeToggle() {
        document.getElementById("toggle-bg").style.width = "0";
        document.getElementById("sideToggle").style.right = "-640px";
        document.getElementById("heading").style.right = "-80px";
    }

   if(getToken("user") == null) {
      //window.location.replace("{{ url('/login') }}");
   }

   checkAuthentication("user");
   var service_quantity = '';
   $(document).ready(function() {

      $('#quantity_value').hide();

      var userSettings = getUserDetails();

      if(userSettings.id == 0) {
         $('.ongoing-service, .header-submenu .dropdown-item').remove();
         $('.header-submenu').append(`<a class="dropdown-item" href="{{ url('/login') }}"><i class="material-icons">account_circle</i> Login</a>`);
         localStorage.setItem("user", JSON.stringify({ id: 0, first_name: "Guest", picture: "{{asset('assets/layout/images/admin/avatar.jpg')}}" }));
      }


      $(".user_name").text(userSettings.first_name);
      $(".user_image").attr('src', userSettings.picture ? userSettings.picture : "{{asset('assets/layout/images/admin/avatar.jpg')}}" );

      $.ajax({
         url: getBaseUrl() + "/user/cities",
         type: "get",
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
            showLoader();
         },
         success: (response, textStatus, jqXHR) => {
            var data = parseData(response);
            var result = data.responseData;
            hideLoader();
            
            if(JSON.parse(localStorage.user).id == 0) {

               var existing_data = getUserDetails();
               existing_data.city_id = result[0].id;
               setUserDetails(existing_data);
               listMenus(result[0].id);

               $.ajax({
               url: getBaseUrl() + "/user/country/{{ Helper::getDefaultCountry() }}",
               type: "get",
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               beforeSend: function() {
                  showLoader();
               },
               success: (response, textStatus, jqXHR) => {
                  var data = parseData(response);
                  var result = data.responseData;
                  var existing_data = getUserDetails();
                  existing_data.currency_symbol = result.currency_symbol;
                  setUserDetails(existing_data);
                  hideLoader();

                  
               },
               error: (jqXHR, textStatus, errorThrown) => {
                  hideLoader();
               }
            });



            } else {
               listMenus(userSettings.city_id);
            }
            $('.current_city').text( (result.filter((item) => item.id == userSettings.city_id).length > 0) ? result.filter((item) => item.id == userSettings.city_id)[0].city_name : result[0].city_name );
            for(var i in result) {
               $('.city_list').append(`<a class="dropdown-item" style="cursor:pointer" data-id="`+ result[i].id +`">`+ result[i].city_name +`</a>`);
            }
         },
         error: (jqXHR, textStatus, errorThrown) => {}
      });

      $.ajax({
         url: getBaseUrl() + "/user/promocodes",
         type: "get",
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
            showLoader();
         },
         success: (response, textStatus, jqXHR) => {
            var data = parseData(response.responseData);
            var html=``;
            for(var i in data) {
            html+=`<div class="item">
                    <img src="`+data[i].picture+`">
                 </div>`
             
            }
            $('.owl-theme').html(html);
            $('#sync1').owlCarousel({
               loop: true,
               margin: 10,
               nav: true,
               autoplay: false,
               dots: true,
               navText: ['<span class="icon ion-ios-arrow-left"></span>', '<span class="icon ion-ios-arrow-right"></span>'],
               // autoplay: true,
               // autoplayHoverPause: true,
               responsive: {
                  0: {
                     items: 1
                  },
                  768: {
                     items: 2
                  },
                  1170: {
                     items: 3
                  }
               }
            });
            
            $('.owl-nav').removeClass('disabled');   
            
         },
         error: (jqXHR, textStatus, errorThrown) => {}
      });

      $('body').on('click', '.city_list a', function() {
         var id = $(this).data('id');
         var value = $(this).text();
         $.ajax({
            url: getBaseUrl() + "/user/city",
            type: "post",
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            data: {
               city_id: id
            },
            beforeSend: function() {
               showLoader();
            },
            success: (response, textStatus, jqXHR) => {
               var existing_data = getUserDetails();
               existing_data.city_id = id;
               setUserDetails(existing_data);
               $('.current_city').text( value );
               listMenus(id);
            },
            error: (jqXHR, textStatus, errorThrown) => {}
         });
         
      });

      

        

      var socket = io.connect(window.socket_url);

      socket.emit('joinCommonUserRoom', `room_${window.room}_${getUserDetails().id}_USER`);

      socket.on('socketStatus', function (data) {
            console.log(data);
      });

      socket.on('newRequest', function (data) {
         ongoing();
      });

      ongoing();




      //For service details
      $('#sub_category').on('change', function(){
         var sub_category_id =$(this).val();
         var category_id =$(this).find(':selected').data('id');
         var userSettings = getUserDetails();
         $.ajax({
               url: getBaseUrl() + "/user/services/"+category_id+"/"+sub_category_id+"?city_id="+userSettings.city_id,
               type: "GET",
               beforeSend: function(request) {
                  showLoader();
               },
               headers: {
                  Authorization: "Bearer " + getToken("user")
               },
               
               success: function(data) {
                  $("#service").empty()
                  .append('<option value="">Select</option>');
                  $.each(data.responseData, function(key, item) {
                     $("#service").append('<option value="' + item.id + '">' + item.service_name+ '</option>');
                  });
                  hideLoader();
               }
         }); 
      }); 

      //Function on next button click
      $('.service_id').on('click', function(){
         var service =$("#service").val();
         var sub_category_id =$("#sub_category").val();
         var quantity =$("#quantity").val();
         if(sub_category_id != '' && service !="" )
         {  if(service_quantity==1){
              window.location.replace("/service/"+service+'/service?qty='+quantity);
            }else{
              window.location.replace("/service/"+service+'/service');
            }
         }
         else{
            alertMessage('Error',"Please select Sub Category and Service", "danger");
         }

      });

      //For allocated cities to get quantity details
      var qty=0;
      $('#service').on('change', function(){
         var city_service =$("#service").val();
         var userSettings = getUserDetails();
         $.ajax({
               url: getBaseUrl() + "/user/service_city_price/"+city_service+"?city_id="+userSettings.city_id,
               type: "GET",
               headers: {
                     Authorization: "Bearer " + getToken("user")
                  },
                  beforeSend: function (request) {
                  showInlineLoader();
               },   
               success: function(data) {
                  $("#quantity").empty()
                  .append('<option value="">Select</option>');
                  $.each(data.responseData, function(key, item) {
                    if(item.allow_quantity==1){
                      service_quantity = 1;
                      $('#quantity_value').show();
                      $('#quantity_value').removeClass('d-none');
                    }
                      qty=item.max_quantity;
                      $("#quantity").val(item.max_quantity);
                  });
                  hideInlineLoader();
               }
         }); 
      }); 

      
      $('#quantity').on('change keyup paste', function(){
         var qty_val=$(this).val();
         if(qty < qty_val){
            alertMessage("Error", "Quantity should not exceed "+qty+" for this service", "danger");
            $('#quantity').val(qty);
        } 
      }); 






      $('#quantity').on('change keyup paste', function(){
          var value = $('#quantity').val();
          if(/^\d*$/.test(value)){
            if ($('#quantity').val() > 10) {
                $('#quantity').val(10);
            }else if ($('#quantity').val() < 1) {
                $('#quantity').val(1);
            }
          }else{
            $('#quantity').val(1);
          }
      });


      //For notification details
      $('.notification').on('click', function(){
         $.ajax({
            url: getBaseUrl() + "/user/notification",
            type: "GET",
            headers: {
               Authorization: "Bearer " + getToken("user")
            },
            beforeSend: function (request) {
               showInlineLoader();
            },
            success:function(data){
               var html = ``;
               var result = data.responseData.notification.data;
               if(result.length>0){
                     //$('#notification_count').text(result.length);
                     $.each(result,function(key,item){
                       html += `<div class="col-md-12 col-lg-12 col-sm-12 p-0">
                              <ul class="provider-list invoice">
                                 <li class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                          <img src=`+item.image+` height="" width=""  class="user-img img-fluid">
                                       </div>
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0" >
                                          <div class="user-right mt-4">
                                             <h5 class="d-inline"> `+item.title+`</h5> 
                                          </div>
                                       
                                          <div class="user-right">
                                                `+item.descriptions+`
                                          </div>
                                          <div class="user-right">
                                                <small>Valid Till: `+item.expiry_time+`</small>
                                          </div>                                                 
                                    </div>
                                 </li>                             
                              </ul>
                           </div>`; 
                     });
                  }
                  $('#notification_detail').html(html);
                  hideInlineLoader();
            } 
         }); 
      });

      //For refering user Concept
      $('.referdetail').on('click', function(){
         $.ajax({
            url: getBaseUrl() + "/user/profile",
            type: "GET",
            headers: {
               Authorization: "Bearer " + getToken("user")
            },
            beforeSend: function (request) {
               showInlineLoader();
            },
            success:function(data){
               var result = data.responseData.referral;
               $('.referal_code').text(result.referral_code); 
               $('.referal_count').text(result.referral_count); 
               $('.referal_amount').text(result.referral_amount); 
               $('.user_referal_count').text(result.user_referral_count); 
               $('.user_referal_amount').text(result.user_referral_amount);
               $('.currency').text(data.responseData.country.country_currency);
               hideInlineLoader(); 
            } 
         }); 
      });
      
      $('#invite').on('click', function(e){
         e.preventDefault();
         var referral_email = $('input[name=referral_email]').val();

         if(referral_email != "" && validateEmail(referral_email)) {
            var referral_code = $('.referal_code').text(); 
            window.location.replace("mailto:"+referral_email+"?subject=Invitation to join {{ Helper::getSettings()->site->site_title }}&body=Hi,%0A%0A I found this website and thought you might like it. Use my referral code("+ referral_code +") on registering in the application.%0A%0AWebsite: {{url('/')}}//login %0AReferral Code:"+referral_code);
         } else {
            alertMessage("Error", "Please enter a valid email", "danger");
         }
         
      });
     
   });

   
$('body').on('click', '.serviceBlock', function(e) {
  
   var id = $(this).data('id');

      //For list category
   $.ajax({
      url:  getBaseUrl() + "/user/service_sub_category/"+id,
      type: "GET",
      beforeSend: function(request) {
        showLoader();
      },
      headers: {
         Authorization: "Bearer " + getToken("user")
      },
      success: function(data) {
         $("#sub_category").empty().append('<option value="">Select</option>');
         $("#service").empty().append('<option value="">Select</option>');
         $.each(data.responseData, function(key, item) {
            $("#sub_category").append('<option value="' + item.id + '" data-id="'+item.service_category_id+'">' + item.service_subcategory_name+ '</option>');
         });
        
         $('#serviceModal').modal('show');
         $('#serviceModal #quantity_value').addClass('d-none');
         hideLoader();

      }
   }); 
   
});




   function listMenus(id) {
      $('#rides').html('');
      var user_details = getUserDetails();
      
      $.ajax({
         url: getBaseUrl() + "/user/menus?city_id="+id,
         type: "get",
         headers: {
            Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
            showLoader();
         },
         success: (response, textStatus, jqXHR) => {
            var data = parseData(response);
            var result = data.responseData.services;

            if(result.length > 0) {
            for(var i in result) {
                  var url = "";
                  //After click menu redirect page
                  if(result[i].service && result[i].service.admin_service == 'TRANSPORT') {
                     url = "{{ url('/ride') }}";
                  }
                  if(result[i].service && result[i].service.admin_service == 'DELIVERY') {
                     url = "{{ url('/delivery') }}";
                  }
                 
                  if(result[i].service && result[i].service.admin_service == 'ORDER') {
                     url = "{{ url('/store/list') }}";
                  }
                  //Display menu in home page(With color and image)
                  if(result[i].service && result[i].service.admin_service == 'TRANSPORT') {
                     $('#rides').append(`<div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                        <a href="`+ url + `/` + result[i].menu_type_id +`/transport" ><div class="service-item item-shadow" style="background-color:`+ result[i].bg_color +`">
                        <img alt="" class="img-responsive" src="`+ result[i].icon +`">
                        <div class="blog-hover"></div>
                        </div>
                        <div class="service-section">
                        <div class="service-content">
                              <h3 class="service-title">`+ result[i].title +`</h3>
                                 <span class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></span>
                        </div>
                        </div>
                     </div></a>`);
                  }
                  if(result[i].service && result[i].service.admin_service == 'ORDER') {
                     var userSettings = getUserDetails();
                    
                     $('#rides').append(`<div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                        <a href="`+ url + `/` + result[i].menu_type_id +`?city_id=`+userSettings.city_id+`" ><div class="service-item item-shadow" style="background-color:`+ result[i].bg_color +`">
                        <img alt="" class="img-responsive" src="`+ result[i].icon +`">
                        <div class="blog-hover"></div>
                        </div>
                        <div class="service-section">
                        <div class="service-content">
                              <h3 class="service-title">`+ result[i].title +`</h3>
                                 <span class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></span>
                        </div>
                        </div>
                     </div></a>`);
                  }
                  if(result[i].service && result[i].service.admin_service == 'DELIVERY') {
                     $('#rides').append(`<div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                        <div class="service-item item-shadow" style="background-color:`+ result[i].bg_color +`">
                        <img alt="" class="img-responsive" src="`+ result[i].icon +`">
                        <div class="blog-hover"></div>
                        </div>
                        <div class="service-section">
                        <div class="service-content">
                              <h3 class="service-title">`+ result[i].title +`</h3>
                                 <a href="`+ url + `/` + result[i].menu_type_id +`/delivery" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                        </div>
                     </div>`);
                  }
                  if(result[i].service && result[i].service.admin_service == 'SERVICE') {
                     $('#rides').append(`<div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                        <div class="service-item item-shadow" style="background-color:`+ result[i].bg_color +`">
                        <img alt="" class="img-responsive" src="`+ result[i].icon +`">
                        <div class="blog-hover"></div>
                        </div>
                        <div class="service-section serviceBlock" id =category_id data-id =`+ result[i].menu_type_id +`>
                        <div class="service-content">
                              <h3 class="service-title">`+ result[i].title +`</h3>
                                 <div class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></div>
                        </div>
                        </div>
                     </div>`);
                  }else{
                     // $('#rides').append(`<div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                     //    <div class="service-item item-shadow" style="background-color:`+ result[i].bg_color +`">
                     //       <img alt="" class="img-responsive" src="`+ result[i].icon +`">
                     //       <div class="blog-hover"></div>
                     //    </div>
                     //    <div class="service-section">
                     //       <div class="service-content">
                     //          <h3 class="service-title category"></h3>
                     //             <div class="link-arrow service">Book Now<i class="icon ion-ios-arrow-right"></i></div>
                     //       </div>
                     //    </div>
                     // </div>`);
                  }
            }
            }

            hideLoader();
            
         },
         error: (jqXHR, textStatus, errorThrown) => {}
      });
   }

   function ongoing() {
      var userSettings = getUserDetails();
      if(userSettings.id != 0) {
         $.ajax({
            url: getBaseUrl() + "/user/ongoing",
            type: "get",
            headers: {
               Authorization: "Bearer " + getToken("user")
            },
            beforeSend: function() {
               showLoader();
            },
            success: (response, textStatus, jqXHR) => {
               var data = parseData(response);
               var result = data.responseData;
               if(result.length > 0) {

                  var html = ``;

                  for(var i in result) {
                     if(result[i].service.admin_service == "TRANSPORT") {
                        html += `<li>
                           <h6 class="txt-yellow"><strong>`+result[i].service.admin_service+`</strong></h6>
                           <div class="bg-lit-yellow text-left">
                                 <h5 class="txt-white">From : `+result[i].request.s_address+`</h5>
                                 <h5 class="txt-white">To : `+result[i].request.d_address+`</h5>
                                 <h5 class="txt-white">Time : `+result[i].request.created_time+`</h5>
                                 <br />
                                 <a class="btn btn-primary" href="{{ url('/ride') }}/`+result[i].request.ride_type_id+`/transport?id=`+result[i].request.id+`">View</a>
                           </div>
                        </li>`;
                     }

                     if(result[i].service.admin_service == "ORDER") {
                        html += `<li>
                     <h6 class="txt-red"><strong>`+result[i].service.admin_service+`</strong></h6>
                     <div class="bg-lit-red text-left">
                           <h5 class="txt-white">shop Name : `+result[i].request.pickup.store_name+`</h5>
                           <h5 class="txt-white">Booking ID : `+result[i].request.store_order_invoice_id+`</h5>
                           <h5 class="txt-white">Status : `+result[i].request.status+`</h5>
                           <h5 class="txt-white">Time : `+result[i].request.created_time+`</h5>
                           <br />
                           <a class="btn btn-red" href="{{ url('/store/order')}}/`+result[i].request.id+`">View</a>
                     </div>
                  </li>`;
                     }
                     if(result[i].service.admin_service == "DELIVERY") {
                        html += `<li>
                     <h6 class="txt-blue"><strong>`+result[i].service.admin_service+`</strong></h6>
                     <div class="bg-lit-blue text-left">
                           <h5 class="txt-white">From : `+result[i].request.s_address+`</h5>
                           <h5 class="txt-white">Booking ID : `+result[i].request.booking_id+`</h5>
                           <h5 class="txt-white">Status : `+result[i].request.status+`</h5>
                           <br />
                           <a class="btn btn-blue" href="{{ url('/delivery')}}/`+result[i].request.id+`/delivery?id=`+result[i].request.id+`">View</a>
                     </div>
                  </li>`;
                     }

                     if(result[i].service.admin_service == "SERVICE") {
                        html += `<li>
                     <h6 class="txt-blue"><strong>`+result[i].service.admin_service+`</strong></h6>
                     <div class="bg-lit-blue text-left">
                           <h5 class="txt-white">Service Location : `+result[i].request.s_address+`</h5>
                           <h5 class="txt-white">Booking ID : `+result[i].request.booking_id+`</h5>
                           <h5 class="txt-white">Status : `+result[i].request.status+`</h5>
                           <h5 class="txt-white">Time : `+result[i].request.created_time+`</h5>
                           <br />
                           <a class="btn btn-blue" href="{{ url('/service')}}/`+result[i].request.service_id+`/service?id=`+result[i].request.id+`">View</a>
                     </div>
                  </li>`;
                     }
                  
                  }
                  $('.ongoing_list').html(html);
               } else {
                  $('.ongoing_list').html(`<li>
                     <div class="bg-lit-primary">
                           <p class="mt-5 mb-5 txt-white">No Services Available</p>
                     </div>
                  </li>`);
               }
               hideLoader();
            },
            error: (jqXHR, textStatus, errorThrown) => {
               hideLoader();
            }
         });
      }
   }
  

</script>
   @if(Helper::getChatmode() == 1)
      <!-- Start of LiveChat (www.livechatinc.com) code -->
      <script type="text/javascript">
         window.__lc = window.__lc || {};
         window.__lc.license = 8256261;
         (function() {
         var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
         lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
         var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
         })();
      </script>
      <!-- End of LiveChat code -->
      @endif
</body>
</html>
