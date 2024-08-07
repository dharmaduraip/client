{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Add On') }}</h6>
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
                        <label for="name">{{ __('store.admin.addon.name') }}</label>
                        <input type="text" class="form-control" id="addon_name" name="addon_name" placeholder="{{ __('store.admin.addon.name') }}" value="">
                       
                    </div>
                </div>
                
             <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="addon_status" class="col-xs-2 col-form-label">@lang('store.admin.addon.status')</label>
						<select name="addon_status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>

                <br>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Add On') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form> 
        </div>
    </div>
</div>



<script>
$(document).ready(function()
{

     basicFunctions();
     var id = "";

  

     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/shop/addons"+id;
        setData( url,'shop' );
     }



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            addon_name: { required: true }, 
        },

		messages: {
			addon_name: { required: "Add On Name is required." },
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
            
            var url = getBaseUrl() + "/shop/addons"+id;

            saveRow( url, table, data,'shop');

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  

});
</script>
