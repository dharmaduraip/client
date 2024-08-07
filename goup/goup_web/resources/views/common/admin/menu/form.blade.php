{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;"> {{ $action_text }} {{ __('Menu') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                <div class="form-row">
                    @if(count(Helper::getServiceList())> 1)
                        <div class="form-group col-md-6">
                        <label for="notify_type" class="col-xs-2 col-form-label">@lang('admin.menu.flow_type')</label>
                            <select name="admin_service" id = "service_id" class="form-control">
                                <option value="">Select</option>
                                    @foreach(Helper::getServiceList() as $key => $service)
                                        <option value={{$service}}>{{$service}}</option>
                                    @endforeach
                            </select>
                        </div>
                    @else
                        <input  type="hidden"  value="{{Helper::getServiceList()[key(Helper::getServiceList())]}}" name="admin_service" required id="admin_service" placeholder="Title">
                    @endif    
                    <div class="form-group col-md-6">
                        <label for="menu_type_id" class="col-xs-2 col-form-label">{{ __('admin.menu.menu_type') }}</label>
                        <select name="menu_type_id" id="menu_type_id" class="form-control">
                            <option value="">select</option>
                        </select>
                    </div>
                </div>
                <input   type="hidden" value="{{ old('title') }}" name="title" required id="title" placeholder="Title">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-group col-md-6 pull-right">
                    <label for="picture">@lang('admin.menu.icon')</label>
                    <div class="image-placeholder w-100">
                        <img width="100" height="100" />
                        <input type="file" name="picture" class="upload-btn picture_upload">
                    </div>
                    <div class="btn btn-danger float-right cancel-image">{{ __('Cancel') }}</div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="bg_color" class="col-xs-2 col-form-label">@lang('admin.menu.bg_color')</label>
                        <div class="col-xs-10">
                            <input style="width: 80px;" autocomplete="off"  type="color" value="{{ old('bg_color') }}" name="bg_color" required id="bg_color" placeholder="BG Color">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sort_order" class="col-xs-2 col-form-label">{{ __('Sort Order') }}</label>
                        <div class="col-xs-10">
                            <input style="width: 150px;" class="form-control" autocomplete="off" type="number" value="{{ old('sort_order') }}" name="sort_order" required id="sort_order" placeholder="Sort Order">
                        </div>
                    </div>
				</div>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="is_featured"><input type="checkbox" name="is_featured" value="" id="is_featured">&nbsp;{{ __('admin.menu.is_featured') }}</label>
                    </div>
                </div>
                <div class="form-row featured_image" style="display: none;">
                    <div class="form-group col-md-12">
                        <label for="featured_image">{{ __('admin.menu.featured_image') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="featured_image" class="upload-btn picture_upload">
                        </div>
                    </div>
                </div>
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="title" class="col-xs-2 col-form-label">@lang('admin.menu.title')</label>
                        <div class="col-xs-10">
                            <input class="form-control" autocomplete="off"  type="text" value="{{ old('title') }}" name="title" required id="title" placeholder="Title">
                        </div>
                    </div>
				</div> -->
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Menu') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
            </form>
        </div>
    </div>
</div>

@include('common.admin.includes.redirect')
<script>

var iconImage = '';
var iconName = '';

var featuredImage = '';
var featuredName = '';

$(document).ready(function()
{
    $('.modal-dialog').addClass('modal-lg');

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
      var obj = $(this);
      if (files && files.length > 0) {
          if(obj.attr('name') == 'picture') {
            iconName = files[0].name;
          } else if(obj.attr('name') == 'featured_image') {
            featuredName = files[0].name;
          }
        
         cropImage(obj, files[0], obj.closest('.image-placeholder').find('img'), function(data) {
            if(obj.attr('name') == 'picture') {
                iconImage = data;
            } else if(obj.attr('name') == 'featured_image') {
                featuredImage = data;
            }
         });
      }
   });

    $('#is_featured').change(function(){
        if(this.checked){
            $("#is_featured").val(1);
            $( ".featured_image" ).show();  // checked
        }
        else{   
            $("#is_featured").val("");     
            $( ".featured_image" ).hide();  // unchecked
        }
    });
//   $.ajax({
//         url:  getBaseUrl() + "/admin/ride_type",
//         type: "GET",
//         headers: {
//             Authorization: "Bearer " + getToken("admin")
//             },
//         success: function(data) {
//             $("#menu_type_id").empty()
//             .append('<option value="">Select</option>');
//             $.each(data.responseData, function(key, item) {
//                 $("#menu_type_id").append('<option value="' + item.id + '">' + item.ride_name + '</option>');
//             });

//         }
//     });

    <?php if(count(Helper::getServiceList()) ==1 ) { ?>
        admin_service("{{Helper::getServiceList()[key(Helper::getServiceList())]}}");
    <?php } ?>

    //For select value
    $('#service_id').change(function(){
       $service_id = $(this).val();
       admin_service($service_id);
       
      
    });

     function admin_service(service_id){
        $service_id=service_id;
        if($service_id =='TRANSPORT'){
            $.ajax({
                url:  getBaseUrl() + "/admin/ride_type",
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                    },
                    
                success: function(data) {
                    $("#menu_type_id").empty().append('<option value="">Select</option>');
                    $.each(data.responseData, function(key, item) {
                        $("#menu_type_id").append('<option value="' + item.id + '">' + item.ride_name + '</option>');
                    });
                    
                }
            }); 

        }else if($service_id =='ORDER'){
            $.ajax({
                url:  getBaseUrl() + "/admin/order_type",
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                    },
                success: function(data) {
                    $("#menu_type_id").empty()
                    .append('<option value="">Select</option>');
                    $.each(data.responseData, function(key, item) {
                        $("#menu_type_id").append('<option value="' + item.id + '">' + item.name+ '</option>');
                    });

                }
            });    
        }else if(service_id =='DELIVERY'){
            $.ajax({
                url:  getBaseUrl() + "/admin/delivery_type",
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                    },
                
                success: function(data) {
                    $("#menu_type_id").empty()
                    .append('<option value="">Select</option>');
                    $.each(data.responseData, function(key, item) {
                        $("#menu_type_id").append('<option value="' + item.id + '">' + item.delivery_name+ '</option>');
                    });
                    
                }
            });   
        }else if($service_id =='SERVICE'){
            $.ajax({
                url:  getBaseUrl() + "/admin/service_type",
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                    },
                
                success: function(data) {
                    $("#menu_type_id").empty()
                    .append('<option value="">Select</option>');
                    $.each(data.responseData, function(key, item) {
                        $("#menu_type_id").append('<option value="' + item.id + '">' + item.service_category_name+ '</option>');
                    });
                    
                }
            });   
        }else{
            $("#menu_type_id").empty()
        }
     }






    $('#menu_type_id').on('change',function(){
        if($(this).val()!=''){
            var title = $("#menu_type_id :selected").text();
            $('#title').val(title);
        }else{
            $('#title').val('');
        }
    });

     basicFunctions();

     var id = "";

     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/menu"+id;
        $('.cancel-image').show();
        $.ajax({
        url: url,
        type: "get",
        headers: {
            Authorization: "Bearer " + getToken('admin')
        },
        beforeSend: function (request) {
            showInlineLoader();
        },
        success: function(response, textStatus, jqXHR) {
            var data=response.responseData;
             $('#service_id').val(data.admin_service);
             $('#bg_color').val(data.bg_color);
             $('#sort_order').val(data.sort_order);

             if(data.is_featured==1){
                $('#is_featured').trigger('click');
                $('input[name=featured_image]').closest('.image-placeholder').find('img').attr('src', data.featured_image);
             }
             $('input[name=picture]').closest('.image-placeholder').find('img').attr('src', data.icon);
             $service_id=data.admin_service;
             var menu_type_id= data.menu_type_id;
             if($service_id =='TRANSPORT'){
                
            $.ajax({
                url:  getBaseUrl() + "/admin/ride_type",
                type: "GET",
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                    },
                    
                success: function(data) {
                    $("#menu_type_id").empty()
                    .append('<option value="">Select</option>');
                    
                    $.each(data.responseData, function(key, item) {
                        var selected="";
                        if(item.id==menu_type_id)
                        selected="selected";

                        $("#menu_type_id").append('<option value="' + item.id + '" '+selected+'>' + item.ride_name + '</option>');
                    });
                    
                }
            }); 

            }else if($service_id =='ORDER'){
                $.ajax({
                    url:  getBaseUrl() + "/admin/order_type",
                    type: "GET",
                    headers: {
                        Authorization: "Bearer " + getToken("admin")
                        },
                    success: function(data) {
                        $("#menu_type_id").empty()
                        .append('<option value="">Select</option>');
                        $.each(data.responseData, function(key, item) {
                            var selected="";
                            if(item.id==menu_type_id)
                            selected="selected";
                            $("#menu_type_id").append('<option value="' + item.id + '" '+selected+'>' + item.name+ '</option>');
                        });

                    }
                });    
            }else if($service_id =='SERVICE'){
              
                $.ajax({
                    url:  getBaseUrl() + "/admin/service_type",
                    type: "GET",
                    headers: {
                        Authorization: "Bearer " + getToken("admin")
                        },
                    
                    success: function(data) {
                        $("#menu_type_id").empty()
                        .append('<option value="">Select</option>');
                        $.each(data.responseData, function(key, item) {
                            var selected="";
                            if(item.id==menu_type_id)
                            selected="selected";
                            $("#menu_type_id").append('<option value="' + item.id + '" '+selected+'>' + item.service_category_name+ '</option>');
                        });
                        
                    }
                });
            }   
        

            hideInlineLoader();
        }
        });    

     }
     $('.cancel-image').hide();
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            bg_color: { required: true },
            //title: { required: true },
            admin_service: { required: true},
            menu_type_id: { required: true},
		},

		messages: {
			bg_color: { required: "BG Color is required." },
            //title: { required: "Title is required." },
            admin_service:  { required: "Service is required." },
            menu_type_id:  { required: "Vehicle Type is required." },
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
            
            var formGroup = $(".validateForm").serialize().split("&");
            var image=$('#upload').val();
            var data = new FormData();

            if(iconImage != "") data.append('icon', iconImage, iconName);
            if(featuredImage != "") data.append('featured_image', featuredImage, featuredName);
            
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append( 'title', $('select[name=menu_type_id] option:selected').text() );
            
            var url = getBaseUrl() + "/admin/menu"+id;
            saveRow( url, table, data);
		}
    });
    //Delete the image and upload new image.
    var image='';
    $('.edit-image').on('click', function(){
        $('.show-image').hide();
        $('.edit-image').hide();
        image=$('.input_img').attr('src');
        $('.input_img').attr('src','');

    });
    //cancel the image
    $('.cancel-image').on('click', function(){
        $('.show-image').show();
        $('.edit-image').show();
        $('.input_img').attr('src',image);
    });


    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });


});
</script>
