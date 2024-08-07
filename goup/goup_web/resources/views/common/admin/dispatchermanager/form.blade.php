{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            <h6 class="m-0 pull-left">{{ __('Dispatcher') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name" class="col-xs-2 col-form-label">{{ __('admin.full_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="col-xs-2 col-form-label">{{ __('admin.email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password" class="col-xs-2 col-form-label">{{ __('admin.password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation" class="col-xs-2 col-form-label">{{ __('admin.password_confirmation') }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Type-Password" value="" autocomplete="off">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-accent">{{ __('Add') }} {{ __('Dispatcher') }}</button>
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
        var url = getBaseUrl() + "/admin/dispatcher"+id;
        setData( url );
     }

     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true },
            email: { required: true, email: true },
            password: { required: true },
            password_confirmation: { equalTo: "#password" },
		},

		messages: {
			name: { required: "Name is required." },
			email: { required: "Email is required." },
            password: { required: "Password is required." },
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
            var url = getBaseUrl() + "/admin/dispatcher"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>
