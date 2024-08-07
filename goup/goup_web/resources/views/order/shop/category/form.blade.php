{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Category') }}</h6>
        </div>
        <div class="form_pad">
        <form class="validateForm" files="true">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @else
                <input type="hidden" name="store_id" value="{{$store_id}}">

                @endif
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="store_category_name">{{ __('store.admin.category.name') }}</label>
                        <input type="text" class="form-control" id="store_category_name" name="store_category_name" placeholder="{{ __('store.admin.category.name') }}" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="store_category_description">@lang('store.admin.category.description')</label>
                        <textarea class="form-control" placeholder="{{ __('store.admin.category.description') }}" id="store_category_description" maxlength="255" name="store_category_description"></textarea>
                        <small>(Maximum characters: 255)</small>
                    </div>
                </div>  
                <div class="form-group col-md-6">
					<label for="store_category_status" class="col-xs-2 col-form-label">@lang('store.admin.cuisine.status')</label>
						<select name="store_category_status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
                <div class="form-row">
                
                    <div class="form-group col-md-3">
                        <label for="picture">{{ __('admin.picture') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="picture" class="upload-btn picture_upload">
                        </div>
                    </div>
				</div> 
            
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Category') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>



<script>
var blobImage = '';
var blobName = '';

$(document).ready(function()
{
    basicFunctions();

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
    
     var id = "";
     if($("input[name=id]").length){
       id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/shop/category"+id; 
        setData( url ,'shop');
     }



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            store_category_name: { required: true },
            store_category_description: { required: true }
          
		},

		messages: {
			store_category_name: { required: "Category Name is required." },
			store_category_description: { required: "Description is required." },
           

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

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            var url = getBaseUrl() + "/shop/category"+id;

            saveRow( url, table, data,'shop');

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  

});
</script>
