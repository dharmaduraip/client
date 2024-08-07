@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<style type="text/css">
  .pac-container{
    z-index: 999999999!important;
  }
</style>
  <style type="text/css">
    .sticker {
    position: absolute;
    right: 0px;
    top: 0;
    background: rgb(250, 74, 91);
    color: rgb(255, 255, 255);
    font-size: 13px;
    font-weight: 500;
    padding: 5px 9px 4px;
    max-width: 50%;
    text-transform: uppercase;
    border-color: rgb(209, 42, 59) transparent;
}
.sticker.new {
  position: absolute;
    right: 0px;
    top: 0;
    background: #FF9800;
    color: rgb(255, 255, 255);
    font-size: 13px;
    font-weight: 500;
    padding: 5px 9px 4px;
    max-width: 50%;
    text-transform: uppercase;
    border-color: #FF9800 transparent;
}
/*.sticker:before {
    position: absolute;
    bottom: -8px;
    content: "";
    width: 0;
    height: 0;
    border-style: solid;
    border-color: inherit;
    right: 0;
    border-width: 9px 0 0 9px;
}*/
.sticker-text {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
      </style>
@stop
@section('content')
<style>
   .cat_btn {
    display: block;
    cursor: pointer;
}
.search-btn {
    height: 37px !important;
    border-radius: 0px !important;
  }
  .search-btn i {
    font-size: 14px !important;
    color: #fff !important;
    margin-left: 0 !important;
        margin-top: -6px;
  }

</style>
<div class="site-wrapper animsition content-box z-1 p-0">
      <section class="inner-page-hero bg-image">
         <div class="profile">
            <div class="container">
               <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-xl-5 profile-desc shop-desc">
                  </div>
               </div>
            </div>
         </div>
        
      </section>
      <div class="page-wrapper">
         <div id="toaster" class="toaster"></div>
         <section class="restaurants-page">
            <div class="result-show bg-white">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-6 col-md-3 col-xl-3  dis-center p-0">
                        <div class="location-section m-0"  data-toggle="modal" data-target="#addressModal">
                           <span class="location-title">
                           <span class="landmark"></span>
                           </span><span class="city"> </span>
                           <span class="fa fa-angle-down arrow-icon"></span>
                        </div>
                        
                     </div>
                     <div class="col-sm-6 col-md-3 col-xl-3 pt-2">
                        <!-- <span class="fa fa-search" style=" position: absolute; left: 8.5%; top: 32%;color: #495057;font-size: 12px;"></span> -->
                         <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search for Items.." required >
                            <div class="input-group-append">
                              <button class="btn btn-primary search-btn searchbutton" type="button">
                                <i class="fa fa-search"></i>
                              </button>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                          <input class="form-control"  type="text" id="search" name="search" placeholder="Search for Items.." required >
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div> -->
                     </div>
                     <div class="col-sm-6 col-md-3 col-xl-3  dis-center">
                        <!-- <span class="fa fa-filter" style=" position: absolute; left: 8.5%; top: 32%;color: #495057;font-size: 12px;"></span> -->
                        <select class="form-control" name="qfilter" id="qfilter" style="margin:10px 0;padding: 5px 0px !important;" >
                          <option value="" selected="" >Select</option>
                           <option value="pure-veg"  >Pure Veg</option>
                           <option value="non-veg">Non Veg</option>
                           <option value="discount">Discount Item</option>
                        </select>
                     </div>
                     <div class="col-sm-6 col-md-3 col-xl-3 p-0 dis-flex-end cart" >
                        <!-- <h6>Cart</h6> -->
                        
                     </div>
                  </div>
               </div>
               <div class="row bg-white p-3 m-0">
                  <div class="col-md-12 col-sm-12 col-xl-2">
                     <div class="sidebar left">
                        <div class="widget style2 quick_filters">
                           <h4 class="widget-title2 sudo-bg-red" itemprop="headline">{{ __('Recommended') }}</h4>
                           <div class="widget-data">
                              <ul class="cat d-block ">
                               <li class="text-center"><a href="javascript:void(0)" class="reset_radio_btn">{{ __('Reset') }}</a></li>
                                 <!-- category list-->
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-xl-10">
                     <div class="">
                        <input type="hidden" id="add_on_qty" value="1" />                      
                        <div class="row prod_list">
                           <!-- product list-->
                         
                        </div>
                        <!--end:row -->
                     </div>
                     <!-- end:Restaurant entry -->
                  </div>
                  <!-- end:Bar -->
                  
               </div>
         </section>
         </div>
      </div>



       <!-- Address Modal -->
         <div class="modal" id="addressModal">
            <div class="modal-dialog">
               <div class="modal-content">
                  <!-- Address Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">{{ __('Choose Location') }}</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Address body -->
                  <div class="modal-body">
                     <div class="col-sm-12 col-lg-12">
                       <!--  <span class="fa fa-location-arrow" style=" position: absolute; left: 5%; top: 25%;color: #495057;font-size: 18px;"></span> -->
                        <input class="form-control search-loc-form" type="text" id="pac-input" name="search_loc" placeholder="Search for area, street name.." required>
                         
                         <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
                         <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
                         <div id="my_map"   style="height:500px;width:500px;display: none" ></div>
                        <span class="my_map_form_current"><i class="material-icons" style=" position: absolute; right: 5%; top: 25%;color: #495057;font-size: 18px;cursor: pointer;">my_location</i> </span>
                     </div>
                     <div class="address-block " id="address_saved">
                        
                     </div>
                  </div>
                  <!-- Address footer -->
                  <!-- <div class="modal-footer">
                     <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Schedule later</a>
                     </div> -->
               </div>
            </div>
         </div>
         <!-- Address Modal -->
         <!-- Cart Modal -->
         <div class="modal" id="cartModal">
           
         </div>
         <!-- Cart Modal -->

         <!-- Addon Modal -->

          <div class="modal" id="repeatModal">
             <div class="modal-dialog">
                <div class="modal-content">
                   <!-- Addon Header -->
                   <div class="modal-header dis-end b-b">
                      <h4 class="modal-title">Repeat last used customization?</h4>                      
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <!-- Addon body -->
                   <div class="modal-body">
                      <div class="col-sm-12 p-0">
                        <!--  -->
                      </div>
                   </div>
                   <!-- Addon footer -->
                   <div class="modal-footer b-0">
                      <a data-id=""  class="btn btn-primary item-no-repeat" data-type="no-customization" ><span class=""></span>I'LL CHOOSE </a>
                      <a data-id="" class="btn btn-primary item-repeat" ><span class=""></span>REPEAT LAST </a>
                   </div>
                </div>
             </div>
          </div>
          <!-- Addon Modal -->

           <!-- Addon Modal -->
          <div class="modal" id="myModal">
             <div class="modal-dialog">
                <div class="modal-content">
                   <!-- Addon Header -->
                   <div class="modal-header dis-end b-b">
                      <h4 class="modal-title  prod_title">Veg Extravaganza</h4>
                      <span class="prod_price">$19.99</span>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <!-- Addon body -->
                   <div class="modal-body">
                      <div class="col-sm-12 p-0">
                         <div class="widget bg-white col-sm-12 p-0">
                            <h4>Add-On  <small>(optional)</small></h4>
                            <div class="dis-end  prod_addon_list">
                               
                            </div>
                         </div>
                         
                      </div>
                   </div>
                   <!-- Addon footer -->
                   <div class="modal-footer b-0  spidfoot">
                      <a id="add_cart" data-qty="" data-id="" class="btn btn-primary btn-block addons" ><span class=""></span>Add  <i class="fa fa-plus" aria-hidden="true"></i></a>
                   </div>
                </div>
             </div>
          </div>
          <!-- Addon Modal -->

          <div class="modal" id="warnModal">
             <div class="modal-dialog">
                <div class="modal-content">
                   <!-- Addon Header -->
                   <div class="modal-header dis-end b-b">
                      <h4 class="modal-title  prod_title">{{ __('Items already in cart') }}</h4>
                      
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <!-- Addon body -->
                   <div class="modal-body">
                      <div class="col-sm-12 p-0">
                        {{ __('Your cart contains items from other restaurant. Would you like to reset your cart for adding items from this restaurant?') }}
                         
                      </div>
                   </div>
                   <!-- Addon footer -->
                   <div class="modal-footer b-0">
                   <a data-id=""  class="btn btn-primary btn-block item-nofresh" ><span class=""></span>{{ __('NO') }} </a>
                      <a data-id="" class="btn btn-primary btn-block item-fresh-cart" ><span class=""></span>{{ __('Yes, start Refresh') }} </a>
                   </div>
                </div>
             </div>
          </div>
          <!-- Addon Modal -->

@stop
@section('scripts')
@parent

<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "100%";
    }
  
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
      var currency = '';
      var init = 0;
      var addons = [];
         $('.cartmodal').on('click',function(){
            $.get("{{url('/store/cart/list')}}",function(res){
              loadcart();
              $('#cartModal').html(res);
              $('#cartModal').modal('show');
            });
         });

        $(document).on('click', '.showcart', function() {
          $('.cartmodal').trigger('click');
        })
         
         
          $('#add_cart').click(function() {
            $('.added-cart').removeClass('d-none');
            $('.empty-cart').addClass('d-none');
          });
         
          $('.add-item').click(function() {
            $('.quantity').removeClass('d-none');
            $('.add-item').addClass('d-none');
          });
     
     
        $.ajax({
         url: getBaseUrl() + "/user/store/useraddress",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var address_list = data.responseData;
                var address_saved ='<h5 >SAVED ADDRESSES</h5>';
               $.each(address_list, function(i,val){
                address_saved +='<div class="address-set green  setaddr" data-lat="'+val.latitude+'" data-lng="'+val.longitude+'" data-loc="'+val.map_address+'">';
                    if(val.address_type=='Home'){
                           address_saved +='<i class="material-icons address-category">home</i>';
                        }
                        if(val.address_type=='Work'){
                           address_saved +='<i class="material-icons address-category">work</i>';
                        }
                        if(val.address_type=='Other'){
                           address_saved +='<i class="material-icons address-category">location_on</i>';
                        }
                           address_saved +='<div class="">\
                              <h5 class="">'+val.address_type+'</h5>\
                              <p >'+val.map_address+'</p>\
                           </div>\
                        </div>';
               });
               $('#address_saved').html(address_saved);
            }

         }
        });
        
   
      shopdetails('');
      function shopdetails(){

        var search = '?';
        //var filter = '';
        //var qfilter = '';;
        //var filter =[];
        if($('#qfilter :selected').val()){
          search += '&qfilter='+$('#qfilter').val();
        }
        if($('#search').val()){
          search += '&search='+$('#search').val();
        }
        
        $.each($("input[name='filter']:checked"), function(){            
                search += '&filter='+$(this).val();
        });
         if(typeof localStorage.latitude !== 'undefined') {
            search +='&latitude='+window.localStorage.getItem('latitude');
         }
         if(typeof localStorage.longitude !== 'undefined') {
            search +='&longitude='+window.localStorage.getItem('longitude');
         }


        $.ajax({
        url: getBaseUrl() + "/user/store/details/{{$id}}"+search,
        type:"GET",
        processData: false,
        contentType: false,
        secure: false,
        headers: {
              Authorization: "Bearer " + getToken("user")
        },
        beforeSend: function() {
            showLoader();
         },
        success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
                var store_data = data.responseData;
              
                var cat_list = '';
                //currency = store_data.currency_symbol;
                $('.cart_tot').html(store_data.usercart);
                if(store_data.usercart==0){ 
                  $('#cartModal').modal('hide');
                  $('.ddd').hide();
                }else{
                  $('.ddd').show();
                }
                if(store_data.storetype.category=='FOOD'){
                  //$('.Search_filters').removeClass('d-none');
                  //$('.quick_filters').removeClass('d-none');
                  //$('#search').attr('placeholder','Search for Items');
                }else{
                  //$('#qfilter').addClass('d-none');
                  $('#search').attr('placeholder','Search for Items..');
                  $("#qfilter option[value='pure-veg'], #qfilter option[value='non-veg']").remove();
                }
                currency = store_data.currency_symbol;
                var userSettings = getUserDetails();
                var profile_desc = '<div class="pull-left right-text white-txt">\
                        <div class="image-wrap">\
                           <figure><img src="'+store_data.picture+'" alt="Profile Image"></figure>\
                        </div>\
                        <h4 class="txt-white">'+store_data.store_name+'</h4>\
                        <p>';
                        var count =0;
                        var mycat = '';
                    $.each(store_data.categories,function(key,item){ count++;
                           if(count <= 10){
                      mycat+=item.store_category_name+',';
                           }
                           cat_list+='<li><span class="radio-box catsearch"><input type="radio" name="filter" id="filt1-'+item.id+'" value="'+item.id+'"  ><label for="filt1-'+item.id+'">'+item.store_category_name+'</label></span></li>';
                    });
                        mycat = mycat.replace(/,\s*$/, "");
                        profile_desc +=mycat+'</p>\
                        <ul class="nav nav-inline">\
                           <li class="nav-item"> <a class="nav-link active" ><i class="fa fa-check"></i> Min '+currency+store_data.offer_min_amount+'</a> </li>';
                        if(store_data.storetype.category=='FOOD'){
                           profile_desc +='<li class="nav-item"> <a class="nav-link" ><i class="fa fa-motorcycle"></i> '+store_data.estimated_delivery_time+' min</a> </li>';
                        }
                           profile_desc +='<li class="nav-item ratings">\
                              <a class="nav-link" > <span>';
                             for(var i=0;i<store_data.rating;i++){
                              profile_desc+='<i class="fa fa-star"></i>';
                             }
                             for(var i=0;i<(5-store_data.rating);i++){
                              profile_desc+='<i class="fa fa-star-o"></i>';
                             }
                              
                              profile_desc+='</span> </a>\
                           </li>\
                            <li class="nav-item">\
                              <a href="{{url("/store/list/")}}/'+store_data.store_type_id + '?city_id='+userSettings.city_id  +'" class="btn  btn-small btn-green2"> << Back</a>\
                           </li>\
                           <li class="nav-item">\
                              <a class="btn btn-rgt btn-small btn-green2">'+store_data.shopstatus+'</a>\
                           </li>\
                        </ul>\
                     </div>';
                $('.shop-desc').html(profile_desc);
                if(init==0){ init++;
                  $('.cat').append(cat_list);
                }
                var prod_list = '';
                $.each(store_data.products,function(key,item){ 
                          prod_list+='<div class="col-sm-12 col-md-6 col-xl-4 text-xs-center text-sm-left restaurant-list">\
                              <div class=" bg-gray restaurant-entry food-item-wrap">\
                                 <div class="entry-logo figure-wrap">'
                                 if(item.shop_status)
                                 {
                                    prod_list+='<div class="sticker '+(item.shop_status == "BESTSELLER" ? "new" : " ") +'"><div class="sticker-text">'+item.shop_status+'</div></div>';
                                 }
                                  
                                 
                                 prod_list+=' <div class="food-category '+(item.is_veg == "Pure Veg" ? "green" : "red") +'"><div class="round '+(item.is_veg == "Pure Veg" ? "green_color" : "red_color") +'"></div></div>\
                                    <a class="img-fluid " >\
                                       <img src="'+item.picture+'" alt="Food logo">\
                                      \
                                 </div>\
                                 <div class="entry-dscr">\
                                 <h6><a >'+item.item_name+'</a></h6>\
                                 <p style="height: 70px; color: #999; font-size: 14px; white-space: wrap; overflow: hidden;">'+item.item_description+'</p>\
                                 <p style="font-size: 16px; text-align: right;">'+( item.unit ? item.quantity+ ' ' +item.unit.name : ' &nbsp;&nbsp;&nbsp; ') +'</p>\
                                 <ul class="list-inline dis-space-btw">\
                                 <li class="list-inline-item">'
                                 if(item.offer){
                                    prod_list+='<h5 style="color: #8e8e8e" class=" pull-left line-through">'+currency+(item.item_price).toFixed(2)+'</h5><br />';
                                 } else {
                                    prod_list+='<h5 style="color: #8e8e8e" class=" pull-left"> &nbsp;&nbsp;&nbsp; </h5><br />';
                                 }
                                 prod_list+='<h5 class="price pull-left">'+currency+(item.product_offer).toFixed(2)+'</h5></li>';
                          
                          
                                if(store_data.shopstatus=='OPEN'){
                                  if((item.itemcart).length>0){
                                    var quantity = 0;
                                    var append = '';
                                    var no_addon = '';
                                    $.each(item.itemcart,function(k,cartval){ 
                                      if((item.itemsaddon).length == 0){
                                        no_addon = 'no-addon';
                                      }
                                      if(k > 0) {
                                        if((item.itemsaddon).length > 0){
                                          var action = 'showcart';
                                        } else {
                                          var action = 'bminus';
                                        }
                                      } else {
                                        var action = 'bminus';
                                      }
                                      quantity += cartval.quantity;
                                       append = '<li class="list-inline-item quantity pull-right ">\
                                       <span class="add '+action+'" data-cartid="'+cartval.id+'"  data-id="'+item.id+'"  value="-" id="moins" >-</span>\
                                       <input class="form-control text-center qty_prod_'+item.id+'" readonly type="input" size="25" value="'+quantity+'" id="count">\
                                       <span class="minus bplus '+no_addon+'" data-cartid="'+cartval.id+'"  data-id="'+item.id+'"   value="+"  id="plus" >+</span>\
                                       </li>';
                                    });
                                    prod_list += append;
                                    
                                  }else{ 
                                    var storerepeat = ((store_data.totalstorecart==store_data.usercart)?'1':'0');
                                    if(item.status ==1){
                                      if((item.itemsaddon).length>0){
                                          prod_list+='<li class="list-inline-item pull-right add-item"> <a  href="javascript:void(0)" id="p_'+item.id+'" data-id="'+item.id+'" data-spid="'+storerepeat+'"  class="btn btn-primary  item-with-addon">Add</a> </li>';
                                      }else{
                                          prod_list+='<li class="list-inline-item pull-right add-item"> <a  href="javascript:void(0)" id="p_'+item.id+'"  data-id="'+item.id+'"  data-spid="'+storerepeat+'" class="btn btn-primary item-no-addon">Add</a> </li>';
                                      }
                                    }
                                    else{
                                       prod_list+=item.item_status;
                                    }
                                  }
                                }
                                 prod_list+='</ul>\
                                 </div>\
                              </div>\
                           </div>';
                });
                  $('.prod_list').html(prod_list);
                  //var url = "{{ url('/store/details') }}";
            }else{
                  window.location.href= "{{url('/store/list/'.$id)}}" + "?city_id="+userSettings.city_id;
            }
            hideLoader();
        }
         });
      }
    function forceNumeric(){
      var $input = $(this);
      $input.val($input.val().replace(/[^\d]+/g,''));
    }

    $(document).on('click', '.item-repeat', function() {
      var prod_id = $(this).attr('data-id');
      // var cart_id = $(this).attr('data-cartid');
      // var qty = $(this).attr('data-value'); 
      var cart_id = 0;
      var qty = 0;
      var type = 'repeat';
      addons = [];
      addcart(prod_id, cart_id, qty, type);
      $('#repeatModal').modal('hide');
      return false;
    })

    $(document).on('click', '.item-no-repeat', function() {
      $('#repeatModal').modal('hide');
      var item_id = $(this).attr('data-id');
      var spid = $(this).attr('data-spid');
      var type = $(this).attr('data-type');
       $('.addons').attr('data-id', item_id);
       $('.addons').attr('data-type', 'no-repeat');
      showAddons(item_id, spid, type, null);
      addons = [];
      // $('#myModal').modal('show');
      return false;
    })

    $(document).on('propertychange input', '.qty_prod', forceNumeric);
      function addcart(prod_id, cart_id, qty, type){
            var data = new FormData();
            data.append( 'item_id', prod_id );
            data.append( 'cart_id', cart_id );
            data.append( 'qty', qty );
            data.append( 'addons', addons );
            (type == 'repeat') ? data.append('repeat', 1) : data.append('repeat', 0);
            (type == 'customize') ? data.append('customize', 1) : data.append('customize', 0);
            $.ajax({
               url: getBaseUrl() + "/user/store/addcart",
               type:"POST",
               processData: false,
               contentType: false,
               secure: false,
               data:data,
               headers: {
                  Authorization: "Bearer " + getToken("user")
               },
               beforeSend: function() {
                  showLoader();
               },
               success: (data, textStatus, jqXHR) => {
                  hideLoader();
                  $('#myModal').modal('hide');
                  shopdetails(); 
                  loadcart(); 
               },
               error: (jqXHR, textStatus, errorThrown) => {
                  $('#myModal').modal('hide');
                  hideLoader();
               }
            })
      }
      $('body').on('click','.addons',function(e){

          $.each($("input[name='addon[]']:checked"), function(){            
            addons.push($(this).val());    
          });

          var prod_id = $(this).attr('data-id');
          var type = $(this).attr('data-type');
          if(type == 'customize') {
            var cart_id = $(this).attr('data-cartid');
          } else {
            var cart_id = 0;
          }
          var addedQty = $("#add_on_qty").val();
          var qty = addedQty !='' && addedQty > 1 ? addedQty : 1;
          addcart(prod_id, cart_id, qty, type);
          $('#warnModal').modal('hide');
      });

      $('body').on('click','.bplus',function(e){
         var prod_id = $(this).attr('data-id');
        var cart_id = $(this).attr('data-cartid');
        var sp_id = $(this).attr('data-spid');
        var elm = $(this).prev(".qty_prod_"+prod_id);
        var qty = elm.val(); 
        // $(".qty_prod_"+prod_id).val(parseInt(qty)+1);
        qty = parseInt(qty) + 1; 
        $('.item-repeat').attr('data-id', prod_id)
        $('.item-repeat').attr('data-cartid', cart_id)
        $('.item-repeat').attr('data-value', qty)
        $('.item-no-repeat').attr('data-id', prod_id)
        $('.item-no-repeat').attr('data-cartid', cart_id)
        $('.item-no-repeat').attr('data-value', qty)
        $('.item-no-repeat').attr('data-spid', sp_id)
        if($(this).hasClass('no-addon') == true) {
          addcart(prod_id, cart_id, qty, 'repeat');
        } else {
          $('#repeatModal').modal('show');
        }
      });
      $('body').on('click','.bminus',function(e){
         var prod_id = $(this).data('id');
         var cart_id = $(this).data('cartid');
         var elm = $(this).next(".qty_prod_"+prod_id);
         var qty = elm.val();
         if(qty==1){
            removecart(cart_id);
         }
         if(qty>1){
               // $(".qty_prod_"+prod_id).val(parseInt(qty)-1);
               var qty = parseInt(qty) - 1;
               addcart(prod_id, cart_id, qty, 'repeat');
         }
      });

function removecart(cart_id){
    var data = new FormData();
    data.append( 'cart_id', cart_id );
    $.ajax({
     url: getBaseUrl() + "/user/store/removecart",
     type:"POST",
     processData: false,
     contentType: false,
     secure: false,
     data:data,
     headers: {
         Authorization: "Bearer " + getToken("user")
     },
     success: (data, textStatus, jqXHR) => {     
         shopdetails();

       }
    })
}
   function showAddons(item_id,spid, type, cart_id){
    if(type == 'customize') {
      var url = "/user/store/cart-addons/"+cart_id;
    } else {
      var url = "/user/store/show-addons/"+item_id;
    }
      $.ajax({
        url: getBaseUrl() + url,
        type:"GET",
        processData: false,
        contentType: false,
        secure: false,
        headers: {
              Authorization: "Bearer " + getToken("user")
        },
        success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
                  $('.prod_addon_list').html('');
                  var item_data = data.responseData;
                  $('.prod_title').html(item_data.item_name);
                  $('.prod_price').html(currency+item_data.item_price);
                  var itemcartaddon = item_data.itemcartaddon;
                  $.each(item_data.itemsaddon,function(key,item){
                     if(item.id == itemcartaddon[item.id] && type == 'customize'){
                     var chk = "checked";
                     }else{
                     var chk = '';
                     }
                     var addon_obj = '<span class="check-box mt-2"><input type="checkbox" name="addon[]" id="addon-'+item.id+'" value="'+item.id+'"  '+chk+' ><label for="addon-'+item.id+'" class="mr-2">'+item.addon_name+'</label>'+currency+item.price+'</span>';
                     $('.prod_addon_list').append(addon_obj);
                  });
                 
                 if(spid==111){
                  // $('.spidfoot').hide();
                 }else{
                  // $('.spidfoot').show();
                 }
               $('#myModal').modal('show');
            }else{
                  //window.location.href= "{{url('/store/list/'.$id)}}" + "?city_id="+userSettings.city_id;
            }
        }
      });
   }
    $('body').on('click', '.searchbutton', function() { 
        //e.preventDefault();
         shopdetails();
     });

    $('body').on('change', '.catsearch', function() { 
        //e.preventDefault();
         shopdetails();
     });
    $('body').on('change', '#qfilter', function(e) { 
        //e.preventDefault();
         shopdetails();
     });
    $('body').on('keypress','#search' ,function(event) {
        if(event.which === 13){
            shopdetails();
        }
  });
  $('body').on('click','.setaddr',function (e){
    var lat = $(this).data('lat');
    var lng = $(this).data('lng');
    var addr = $(this).data('loc');
    updateForm(lat, lng, addr);
    shopdetails();
  });
  $('body').on('click','.reset_radio_btn',function(e){ 
      $('input[name="filter"]').prop('checked', false);
      shopdetails();
    });
  $('body').on('click','.item-with-addon',function(e){

   var userSettings = getUserDetails();

    if(userSettings.id == 0) {
      alertMessage("Error","Please Login", "danger");     
      setTimeout(function(){              
         window.location.replace("{{ url('/login') }}");
      }, 5000); 
      return false; 
    }

      addons = [];
      var type = $(this).attr('data-type');
      $('.addons').attr('data-type', type);
      var item_id = $(this).attr('data-id');
      var cart_id = $(this).attr('data-cartid');
      var spid = $(this).attr('data-spid');
      $('.addons').attr('data-id',item_id);
      $('.addons').attr('data-cartid',cart_id);
      if(spid>0){
        showAddons(item_id, spid, type, cart_id);
      }else{
        $('#warnModal').modal('show');
        $('.addons').attr('data-type', type);
        $('.item-fresh-cart').attr('data-id',item_id);
        $('.item-nofresh').attr('data-id',item_id);
      }
  });

  $('body').on('click','.item-no-addon',function(e){

     var userSettings = getUserDetails();

     if(userSettings.id == 0) {
        alertMessage("Error","Please Login", "danger");     
            setTimeout(function(){              
               window.location.replace("{{ url('/login') }}");
            }, 5000); 
            return false; 
     }


      addons = [];
      var item_id = $(this).attr('data-id');
      var cart_id = ($(this).attr('data-cartid') == undefined) ? 0 : $(this).attr('data-cartid');
      var qty = 1;
      var spid = $(this).attr('data-spid');
      if(spid>0){
         addcart(item_id,cart_id,qty,'bplus');
      }else{
        $('.item-fresh-cart').attr('data-id',item_id);
        $('.item-nofresh').attr('data-id',item_id);
        $('#warnModal').modal('show');
      }
  });
  $('body').on('click','.item-fresh-cart',function(e){
   var url = "/user/store/totalremovecart";
   $.ajax({
        url: getBaseUrl() + url,
        type:"GET",
        processData: false,
        contentType: false,
        secure: false,
        headers: {
              Authorization: "Bearer " + getToken("user")
        },
        success: (data, textStatus, jqXHR) => {
         $('#warnModal').modal('hide');
         location.reload();
        }
      });
      
      
  });

  $('body').on('click','.item-nofresh',function(e){ 
      $('#warnModal').modal('hide');
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

    function initMap() { 

        var userLocation = new google.maps.LatLng(
                13.066239,
                80.274816
            );
        
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow({
            content: "Shop Location",
        });

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);
        infowindow.open(map, marker);

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
            infowindow.open(map, marker);
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
            window.localStorage.setItem('landmark', landmark);
            window.localStorage.setItem('city', city);
            window.localStorage.setItem('latitude', lat);
            window.localStorage.setItem('longitude', lng);
            $('.landmark').html(landmark);
            $('.city').html(city);
            shoplist();
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

<script type="text/javascript">
  function forceNumeric(){
    var $input = $(this);
    $input.val($input.val().replace(/[^\d]+/g,''));
    }
    $('body').on('propertychange input', '.qty_prod', forceNumeric);
loadcart();
function  loadcart(){
  $.ajax({
         url: getBaseUrl() + "/user/store/cartlist",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var cart_list = data.responseData;
               $('.cart_tot').html((cart_list.carts).length);
               var cartlist ='';
               $('.chk_url').attr('href',"{{url('/store/checkout/')}}/"+cart_list.store_id);
              if(cart_list.store_type=='FOOD'){
                $('.food').removeClass('d-none');
                $('.others').addClass('d-none');
              }else{
                $('.food').addClass('d-none');
                $('.others').removeClass('d-none');
              }
               
               $.each(cart_list.carts, function(i,val){
                cartlist +='<ul class="list-inline w-100 order-row dis-space-btw">\
                    <li class="list-inline-item" style="float:left; width: 100%;" >\
                       <div style="float:left; width: 100%; "><h5 style="    word-break: break-word;" class="price ">'+val.product.item_name+'</h5><h6 style=" ">'+ (val.product.unit ? val.item_quantity + ' ' +val.product.unit.name : '') +'</h6></div>\
                       <p style="float:left; width: 100%; " class="txt-color1 m-0">'+currency+val.product.item_price+'</p>';
                    if((val.cartaddon).length>0){
                     cartlist +='<a class="text-color c-pointer item-with-addon" data-type="customize" data-cartid="'+val.id+'" data-id="'+val.store_item_id+'"  data-spid="111" >Customize <i class="fa fa-cogs" aria-hidden="true"></i></a>';
                  }
                    cartlist +='</li>\
                    <li class="list-inline-item quantity ">\
                       <span class="add  eminus"  data-id="'+val.store_item_id+'"  data-cat_id="'+val.id+'"  value="-" id="moins" >-</span>\
                       <input class="form-control text-center qty_prod_'+val.store_item_id+'" min="1" readonly type="input" size="25" value="'+val.quantity+'" id="count_'+val.store_item_id+'">\
                       <span class="minus  eplus" data-id="'+val.store_item_id+'" data-cat_id="'+val.id+'"  value="+"  id="plus" >+</span>\
                    </li>\
                    <li class="list-inline-item mr-3">\
                       <h5 class="price "></h5>\
                    </li>\
                    <li class="list-inline-item "><a class="cart-el-remove" data-cart_id="'+val.id+'" href="javascript:void(0)"><i class="fa fa-times-circle font-16 primary-color c-pointer"></i></a> </li>\
                 </ul>';
               });
               var show_gross = currency+cart_list.total_item_price.toFixed(2);
               var show_offer = currency+cart_list.shop_discount.toFixed(2);
               var show_gst = currency+cart_list.shop_gst_amount.toFixed(2);
               var show_delivery = currency+cart_list.delivery_charges;
               var show_total = currency+cart_list.payable.toFixed(2);
               $('#rcart_list').html(cartlist);
               $('.tot_gross').html(show_gross);
               $('.shop_offer').html(show_offer);
               $('.shop_gst').html(show_gst);
               $('.shop_pkg').html(currency+cart_list.shop_package_charge);
               $('.promocode').html(currency+cart_list.promocode_amount);
               $('.Total').html(show_total);
               $('.delivery_charge').html(show_delivery);
               if(cart_list.shop_discount > 0){
                $('.shop_offer_tr').removeClass('d-none');
                $('.shop_offer').html(currency+cart_list.shop_discount);
               }
               if(cart_list.delivery_charges>0){
                $('.freeship').addClass('d-none')
               }

            }

         }
        });
}

function addcart_cart(prod_id,cart_id,qty, type){
      var data = new FormData();
      data.append( 'item_id', prod_id );
      data.append( 'cart_id', cart_id );
      data.append( 'qty', qty );
      data.append( 'addons', addons );
      (type == 'repeat') ? data.append('repeat', 1) : data.append('repeat', 0);
      (type == 'customize') ? data.append('customize', 1) : data.append('customize', 0);
      $.ajax({
         url: getBaseUrl() + "/user/store/addcart",
         type:"POST",
         processData: false,
         contentType: false,
         secure: false,
         data:data,
         headers: {
            Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
            showLoader();
         },
         success: (data, textStatus, jqXHR) => {
            hideLoader();
            $('#myModal').modal('hide');
            shopdetails();  
            loadcart();
         },
         error: (jqXHR, textStatus, errorThrown) => {
            $('#myModal').modal('hide');
            hideLoader();
         }
      })
}
$('body').on('click','.eplus',function(e){
  var prod_id = $(this).data('id');
  var cart_id = $(this).data('cat_id');
  var elm = $(this).prev(".qty_prod_"+prod_id);
  var qty = elm.val(); 
  $(".qty_prod_"+prod_id).val(parseInt(qty)+1);
  var qty = elm.val();
  addons = [];
  // $("#add_on_qty").val(qty);
  addcart_cart(prod_id, cart_id, qty, 'repeat');
  // loadcart();
  //return false;
});
$('body').on('click','.eminus',function(e){
  var prod_id = $(this).data('id');
  var cart_id = $(this).data('cat_id');
  var elm = $(this).next(".qty_prod_"+prod_id);
  var qty = elm.val();
  addons = [];
  if(qty>1){
    // $(".qty_prod_"+prod_id).val(parseInt(qty)-1);
    qty = parseInt(qty)-1;
    // $("#add_on_qty").val(qty);
    addcart_cart(prod_id, cart_id, qty, 'repeat');
    
  }
  return false;
});

$('body').on('click','.cart-el-remove',function(e){
  var cart_id = $(this).data('cart_id'); 
  removecart(cart_id);
  
});

function removecart(cart_id){
    var data = new FormData();
    data.append( 'cart_id', cart_id );
    $.ajax({
     url: getBaseUrl() + "/user/store/removecart",
     type:"POST",
     processData: false,
     contentType: false,
     secure: false,
     data:data,
     headers: {
         Authorization: "Bearer " + getToken("user")
     },
     success: (data, textStatus, jqXHR) => {
     loadcart();
     shopdetails();

       }
    })
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
@stop