{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('store.admin.storetype.add'))
            @else
                @php($action_text=__('store.admin.storetype.edit'))
                
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
                        <label for="name">{{ __('store.admin.storetype.name')  }} (English)</label>
                        <input type="text" class="form-control" id="name" name="name_en" placeholder="{{ __('store.admin.storetype.name') }}" value="">
                    </div>
                </div>
                 <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('store.admin.storetype.name') }} (Arabic)</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" placeholder="{{ __('store.admin.storetype.name') }}" value="">
                    </div>
                </div>
                 <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('store.admin.storetype.name') }} (franch)</label>
                        <input type="text" class="form-control" id="name_fr" name="name_fr" placeholder="{{ __('store.admin.storetype.name') }}" value="">
                    </div>
                </div>
                 <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('store.admin.storetype.name') }} (spanish)</label>
                        <input type="text" class="form-control" id="name_es" name="name_es" placeholder="{{ __('store.admin.storetype.name') }}" value="">
                    </div>
                </div>


                <label for="category">{{ __('store.admin.storetype.category') }}</label>

                <div class="form-row">
                    
                    <div class="form-group col-md-6">

                        <label>
                            <input type="radio" value="FOOD" name="category" id="category">{{ __('Food') }}
                        </label>

                        <label>
                            <input type="radio" value="OTHERS" name="category" id="category">
                            {{ __('Others') }}
                        </label>
                    </div>
                </div>

                <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('store.admin.storetype.status')</label>
						<select name="status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>

                
                <button type="submit" class="btn btn-accent ">{{$action_text}}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
               

            </form>
        </div>
    </div>
</div>

@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{
     basicFunctions();
     var id = "";
     if($("input[name=id]").length){

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/store/storetypes"+id;
        setData( url );
     }

    $('.validateForm').validate({

        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            name: { required: true },
            category: { required: true },
        },

        messages: {
            // vehicle_type: { required: "Vehicle Type is required." },
            name: { required: "StoreType Name  is required." },
            category: { required: "Store Category is required." },
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
             var url = getBaseUrl() + "/admin/store/storetypes"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>
