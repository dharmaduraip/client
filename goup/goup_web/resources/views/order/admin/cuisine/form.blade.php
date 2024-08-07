{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Cuisine') }}</h6>
        </div>
        <div class="form_pad">
        <form class="validateForm" files="true">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="store_type_id">@lang('store.admin.cuisine.type')</label>
                        <select name="store_type_id" id="store_type_id" class="form-control">
							<option value="">Select</option>
						</select>
                    </div>
                </div> 
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('store.admin.cuisine.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('store.admin.cuisine.name') }}" value="">
                    </div>
                </div>
                 
             <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('store.admin.cuisine.status')</label>
						<select name="status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>

                <button type="submit" class="btn btn-accent ">{{$action_text}} {{ __('Cuisine') }}</button>
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

     $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/store/storetypelist?type=FOOD",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
                $("#store_type_id").empty();
                $("#store_type_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                    $("#store_type_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                  }
                });
             }
    });

     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/store/cuisines"+id;
        setData( url );
     }



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true },
            store_type_id: { required: true }
          
		},

		messages: {
			name: { required: "Cuisine is required." },
			store_type_id: { required: "Store Type is required." },
           

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
            
            var url = getBaseUrl() + "/admin/store/cuisines"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  

});
</script>
