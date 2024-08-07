{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0" style="margin:10!important;">{{$action_text}} {{ __('Notification') }}</h6>
        </div>
        <div class="p-2">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                     <input type="hidden" name="_method" value="PATCH">
                     <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-group col-md-6 pull-right" style ="margin-bottom:50px;">
                    <label for="picture">@lang('admin.notification.notify_image')</label>
                   
                    <div class="image-placeholder w-100">
                        <img width="100" height="100" />
                        <input type="file" name="image" class="upload-btn picture_upload">
                    </div>

                </div>
                @if(count(Helper::getServiceList())> 1)
                    <div class="form-row">
                        <div class="form-group col-md-10">
                        <label for="notify_type" class="col-xs-2 col-form-label">@lang('admin.provides.service_name')    </label>
                            <select name="service" class="form-control">
                                <option value="">Select</option>
                                    @foreach(Helper::getServiceList() as $service)
                                        <option value={{$service}}>{{$service}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <input type="hidden" name ="service" value="{{Helper::getServiceList()[key(Helper::getServiceList())]}}" />
                @endif
                <div class="form-row">
                    <div class="form-group col-md-10">
					   <label for="notify_type" class="col-xs-2 col-form-label">@lang('admin.notification.notify_type')    </label>
						<select name="notify_type" class="form-control">
							<option value="">Select</option>
                            <option value="all">All</option>
							<option value="user">User</option>
							<option value="provider">Provider</option>
						</select>
					</div>
				</div>
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picture">@lang('admin.notification.notify_image')</label>
                        <div class="imgUploadbx">
                            <div class="picture-container">
                                <div class="picture productPic">
                                    <img src="#" class="input_img picture-src" title="" class="img-responsive" />
                                    <input type="file" name="image" onchange="readURL(this);">
                                    <h6 class="addPoto">
                                        <img src="{{ asset('assets/layout/images/camera.svg')}}"> <br>Add Your image
                                    </h6>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- <input type="file" name="image" onchange="readURL(this);">
                <div id="page">
                    <div id="demo-basic">
                        <h6 class="addPoto">                
                        </h6> 
                    </div>
                </div> -->

                <!-- <input type="hidden" id="show_image" name="image"> -->
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="title" class="col-xs-2 col-form-label">@lang('admin.notification.notify_title')</label>
                        <input type="text"  class="form-control" autocomplete="off"   value="{{ old('title') }}" name="title" required id="title" placeholder="@lang('admin.notification.notify_title')">
					</div>
				</div>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="desc" class="col-xs-2 col-form-label">@lang('admin.notification.notify_desc')</label>
                        <input type="text"  class="form-control" autocomplete="off"   value="{{ old('description') }}" name="descriptions" required id="description" placeholder="@lang('admin.notification.notify_desc')">
					</div>
				</div>

                <div class="form-row">
                <div class="form-group col-md-10">
					<label for="datetimepicker" class="col-xs-2 col-form-label">@lang('admin.notification.notify_expiry')</label>
						<input class="form-control" autocomplete="off"  type="text" value="{{ old('expiry_date') }}" name="expiry_date" required id="datetimepicker" placeholder="@lang('admin.notification.notify_expiry')">
					</div>
				</div>

                <div class="form-row">
                <div class="form-group col-md-10">
					<label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.notification.notify_status')</label>
						<select name="status" class="form-control">
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
				</div>

                <br>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Notification') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{

    var blobImage = '';
    var blobName = '';

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
     var id = "";
     var data = new FormData();
     if($("input[name=id]").length){ 
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/notification"+id;
        setData( url );
     }
     $('.cancel-image').hide();
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            notify_type: { required: true },
            description: { required: true },
            expiry_date: { required: true },
            service: { required: true },
            //image: { required: true },
		},
		messages: {
			notify_type: { required: "Notify Type is required." },
			description: { required: "Notify Description is required." },
			notify_expiry: { required: "Expiry Date is required." },
            service: { required: "Service is required." },
            //image: { required: "Image is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},
		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},
		submitHandler: function(form,ev) { 
            var formGroup = $(".validateForm").serialize().split("&");
            var image=$('#upload').val();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('image', blobImage, blobName);
            
            var url = getBaseUrl() + "/admin/notification"+id;
            saveRow( url, table, data);
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  

   $('input[name=expiry_date]').datepicker({
        rtl: false,
        orientation: "left",
        todayHighlight: true,
        autoclose: true,
        startDate:new Date()
    });

});
</script>
