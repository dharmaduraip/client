{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('service.admin.services.add'))
            @else
                @php($action_text=__('service.admin.services.edit'))                
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
                        <label for="service_name">{{ __('service.admin.services.name') }}</label>
                        <input type="text" class="form-control" id="service_name" name="service_name" placeholder="{{ __('service.admin.services.name') }}" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_category_id">{{ __('service.admin.subcategories.main') }}</label>
                        <select name="service_category_id" id="service_category_id" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_subcategory_id">{{ __('service.admin.subcategories.name') }}</label>
                        <select name="service_subcategory_id" id="service_subcategory_id" class="form-control">
                        </select>
                    </div>
                </div>
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picture">{{ __('service.admin.services.image') }}</label>                        
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="picture" class="upload-btn picture_upload">
                        </div>
                    </div>
                </div> -->
                <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="service_status" class="col-xs-2 col-form-label">@lang('service.admin.services.status')</label>
						<select name="service_status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="customToggle2">{{ __('Are you Professional?') }}</label>
                    <div class="custom-control custom-toggle">
                        <input type="checkbox" id="isProfessional" name="is_professional" class="custom-control-input" value ='0'>
                        <label class="custom-control-label" for="isProfessional"></label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="customToggle2">{{ __('Allow Description') }}</label>
                    <div class="custom-control custom-toggle">
                        <input type="checkbox" id="allowDesc" name="allow_desc" class="custom-control-input" value ='0'>
                        <label class="custom-control-label" for="allowDesc"></label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="customToggle2">{{ __('Allow Before Image') }}</label>
                    <div class="custom-control custom-toggle">
                        <input type="checkbox" id="allowBImage" name="allow_before_image" class="custom-control-input" value ='0'>
                        <label class="custom-control-label" for="allowBImage"></label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="customToggle2">{{ __('Allow After Image') }}</label>
                    <div class="custom-control custom-toggle">
                        <input type="checkbox" id="allowAImage" name="allow_after_image" class="custom-control-input" value ='0'>
                        <label class="custom-control-label" for="allowAImage"></label>
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
     basicFunctions();
     var id = "";
     if($("input[name=id]").length){

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/service/listing"+id;
        setData( url );
        // loadSubCategory();
     }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            service_name: { required: true },
            service_category_id: { required: true },
            service_subcategory_id: { required: true },
            //picture: { required: true},
            service_status: { required: true },
		},
		messages: {
			service_name: { required: "Category is required." },
            service_category_id: { required: "Category is required." },
			service_subcategory_id: { required: "Sub Category is required." },
			//picture: { required: "Image is required." },
            service_status: { required: "Status is required." },
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

            var url = getBaseUrl() + "/admin/service/listing"+id;
            saveRow( url, table, data);
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

    $('#service_category_id').on('change', function(){
        var category_id =$("#service_category_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/service/subcategories-list/"+category_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#service_subcategory_id").empty();
                $("#service_subcategory_id").append('<option>Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#service_subcategory_id").append('<option value="'+item.id+'">'+item.service_subcategory_name+'</option>');
                });

                hideInlineLoader();
            }
        });
    });

});
function loadSubCategory(){
    // var category_id =$("#service_category_id").val();
    var category_id = $('#service_category_id').find(":selected").text();
    alert(category_id);
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/service/subcategories-list/"+category_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#service_subcategory_id").empty();
                $("#service_subcategory_id").append('<option>Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#service_subcategory_id").append('<option value="'+item.id+'">'+item.service_subcategory_name+'</option>');
                });

                hideInlineLoader();
            }
        });
}
$('#allowDesc,#allowBImage,#allowAImage,#isProfessional').on('change', function() { 
    cb = $(this);
    cb.val(cb.prop('checked'));
    var qty = cb.prop('checked');
    if(qty){
        cb.val(1);
    }else{
        cb.val(0);
    }
});
</script>
