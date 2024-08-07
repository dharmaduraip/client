{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Reasons') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                @if(count(Helper::getServiceList())> 1)
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="notify_type" class="col-xs-2 col-form-label">@lang('admin.service')    </label>
                            <select name="service" class="form-control">
                                <option value="">Select</option>
                                    @foreach(Helper::getServiceList() as $service)
                                        <option value={{$service}}>{{$service}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="type">{{ __('admin.reason.type') }}</label>
                        <select name="type" class="form-control">
							<option value="">Select</option>
							<option value="USER">USER</option>
							<option value="PROVIDER">PROVIDER</option>
						</select>
                    </div>
                    </div>
                @endif
               
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('admin.reason.reason') }}</label>
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
					<label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.reason.status')</label>
						<select name="status" class="form-control">
                            
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
                </div>
               
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Reason') }}</button>
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
        var url = getBaseUrl() + "/admin/reason"+id;
        setData( url );
     }

     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            type: { required: true },
            reason: { required: true },
            status: { required: true },
            service: { required: true },
		},

		messages: {
			type: { required: "Type is required." },
			reason: { required: "Reason is required." },
            status: { required: "Status is required." },
            service: { required: "Service is required." },

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
            var url = getBaseUrl() + "/admin/reason"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>
