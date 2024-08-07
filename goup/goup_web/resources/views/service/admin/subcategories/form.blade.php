{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('service.admin.subcategories.add'))
            @else
                @php($action_text=__('service.admin.subcategories.edit'))
                
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm" files="true">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_subcategory_name">{{ __('service.admin.subcategories.name') }}(English)</label>
                        <input type="text" class="form-control" id="service_subcategory_name_en" name="service_subcategory_name_en" placeholder="{{ __('service.admin.subcategories.name') }}" value="">
                    </div>
                </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_subcategory_name">{{ __('service.admin.subcategories.name') }}(Arabic)</label>
                        <input type="text" class="form-control" id="service_subcategory_name_ar" name="service_subcategory_name_ar" placeholder="{{ __('service.admin.subcategories.name') }}" value="">
                    </div>
                </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_subcategory_name">{{ __('service.admin.subcategories.name') }}(Franch)</label>
                        <input type="text" class="form-control" id="service_subcategory_name_fr" name="service_subcategory_name_fr" placeholder="{{ __('service.admin.subcategories.name') }}" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_subcategory_name">{{ __('service.admin.subcategories.name') }}(Spanish)</label>
                        <input type="text" class="form-control" id="service_subcategory_name_es" name="service_subcategory_name_es" placeholder="{{ __('service.admin.subcategories.name') }}" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_category_id">{{ __('service.admin.subcategories.main') }}</label>
                        <select name="service_category_id" id="service_category_id" class="form-control">
                        </select>
                    </div>
                </div>
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picture">{{ __('service.admin.subcategories.image') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="picture" class="upload-btn picture_upload">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_subcategory_order">{{ __('service.admin.subcategories.order') }}</label>
                        <input type="text" class="form-control" id="service_subcategory_order" name="service_subcategory_order" placeholder="{{ __('service.admin.subcategories.order') }}" value="0">
                    </div>
                </div>
 -->

                <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="service_subcategory_status" class="col-xs-2 col-form-label">@lang('admin.status')</label>
						<select name="service_subcategory_status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>

                <br>
                <button type="submit" class="btn btn-accent">{{$action_text}}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>

var blobImage = '';
var blobName = '';

$(document).ready(function()
{
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

     basicFunctions();

    $.ajax({
        url: getBaseUrl() + "/admin/service/categories-list",
        type: "GET",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success: function(data) {
            $("#service_category_id").empty()
                .append('<option value="">select</option>');
            $.each(data.responseData, function(key, item) {
                $("#service_category_id").append('<option value="' + item.id + '">' + item.service_category_name + '</option>');
            });
        }
    });
     var id = "";
     if($("input[name=id]").length){

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/service/subcategories"+id;
        setData( url );
     }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            // vehicle_type: { required: true },
            service_subcategory_name: { required: true },
            //picture: { required: true},
            service_category_order: { required: true },
            service_category_status: { required: true },
		},

		messages: {
			// vehicle_type: { required: "Vehicle Type is required." },
			service_subcategory_name: { required: "Category Name is required." },
			//picture: { required: "Image is required." },
            service_category_order: { required: "Order required." },
            service_category_status: { required: "Status required." },
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
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            var url = getBaseUrl() + "/admin/service/subcategories"+id;
            saveRow( url, table, data);
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });


});
</script>
