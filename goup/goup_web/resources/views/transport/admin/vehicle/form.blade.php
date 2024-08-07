{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.vehicletype.add'))
            @else
                @php($action_text=__('admin.vehicletype.edit'))

            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="ride_type_id" class="col-xs-2 col-form-label">@lang('transport.admin.vehicletype.add')</label>
						<select name="ride_type_id" class="form-control" id="ride_type_id">
                            <option value="">Select</option>

						</select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="vehicle_name">{{ __('admin.vehicle.vehicle_name') }}(English)</label>
                        <input type="text" class="form-control" id="vehicle_name_en" name="vehicle_name_en" placeholder="Vehicle Type Name" value="" autocomplete="off">
                    </div>
				</div>

                <div class="form-row">
                 <div class="form-group col-md-4">
                    <label for="ride_type_id" class="col-xs-2 col-form-label">{{ __('admin.vehicle.vehicle_name') }}(Arabic)</label>
                    <input type="text" class="form-control" id="vehicle_name_ar" name="vehicle_name_ar" placeholder="Vehicle Type Name" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vehicle_name">{{ __('admin.vehicle.vehicle_name') }}(Franch)</label>
                        <input type="text" class="form-control" id="vehicle_name_fr" name="vehicle_name_fr" placeholder="Vehicle Type Name" value="" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="vehicle_name">{{ __('admin.vehicle.vehicle_name') }}(Spanish)</label>
                        <input type="text" class="form-control" id="vehicle_name_es" name="vehicle_name_es" placeholder="Vehicle Type Name" value="" autocomplete="off">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="vehicle_image">{{ __('admin.vehicle.vehicle_image') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="vehicle_image" class="upload-btn picture_upload">
                        </div>
                        <span style="color:red;font-size:15px;display:none" id="img_error" >Select Image less thaan 10MB Size</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="vehicle_marker">{{ __('admin.vehicle.vehicle_marker') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="vehicle_marker" class="upload-btn picture_upload">
                        </div>
                        <span style="color:red;font-size:15px;display:none" id="img_error1" >Select Image less thaan 10MB Size</span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="capacity">{{ __('admin.vehicle.vehicle_capacity') }}</label>
                        <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Vehicle Capacity" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
					<label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.status')<</label>
						<select name="status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
                </div>


                <div class="form-row">
                <div class="form-group col-md-6">
                <button type="submit" class="btn btn-accent">{{$action_text}}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                <div>
              </div>
            </form>
        </div>
    </div>
</div>

@include('common.admin.includes.redirect')
<script>

var image = '';
var imageName = '';
var marker = '';
var markerName = '';

$(document).ready(function()
{

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
      var obj = $(this);
      var size = (files[0].size / 1024000);
      if(size > 10.0 && obj.attr('name') == 'vehicle_image')
      {
        $('#img_error').css('display','block');
      }
      else if(size > 10.0 && obj.attr('name') == 'vehicle_marker')
      {
        $('#img_error1').css('display','block');
      }

      else if (files && files.length > 0) {
            if(obj.attr('name') == 'vehicle_image') {
                imageName = files[0].name;
                $('#img_error').css('display','none');
            } else if(obj.attr('name') == 'vehicle_marker') {
                markerName = files[0].name;
                $('#img_error1').css('display','none');
            }

         cropImage(obj, files[0], obj.closest('.image-placeholder').find('img'), function(data) {
            image = data;
            if(obj.attr('name') == 'vehicle_image') {
                image = data;
            } else if(obj.attr('name') == 'vehicle_marker') {
                marker = data;
            }
         });
      }
   });

     basicFunctions();
     $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/getvehicletype",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        'beforeSend': function (request) { },
        success:function(response){
            var data = parseData(response);
            $("#ride_type_id").empty();
            $("#ride_type_id").append('<option value="">Select</option>');
            $.each(data.responseData.vehicle_type,function(key,item){
                $("#ride_type_id").append('<option value="'+item.id+'">'+item.ride_name+'</option>');
            });
        }
    });

     var id = "";
     if($("input[name=id]").length){

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/vehicle"+id;
        setData( url );
     }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            // vehicle_type: { required: true },
            vehicle_name_en: { required: true },
            vehicle_name_ar: { required: true },
            vehicle_name_ku: { required: true },
            //vehicle_image: { required: true},
            //vehicle_marker: { required: true },
            ride_type_id:{required: true},
            capacity: { required: true },
		},

		messages: {
			// vehicle_type: { required: "Vehicle Type is required." },
			vehicle_name: { required: "Vehicle Name is required." },
			//vehicle_image: { required: "Image is required." },
            //vehicle_marker: { required: "Marker is required." },
            ride_type_id:{required: "Type is required."},
			capacity: { required: "Capacity required." },
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

            var data = new FormData();

            if(image != "") data.append('vehicle_image', image, imageName);
            if(marker != "") data.append('vehicle_marker', marker, markerName);

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            var url = getBaseUrl() + "/admin/vehicle"+id;
            console.log(data);

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>
