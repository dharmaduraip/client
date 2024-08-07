{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
         
            <h6 class="m-0"style="margin:10!important;">{{ __('admin.provides.add_amount') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-row">
                    
                    <div class="form-group col-md-6">
                        <label for="currency" class="col-xs-2 col-form-label">{{ __('admin.provides.enter_amount') }}</label>
                        <input type="text" class="form-control price" id="amount" name="amount" placeholder="{{ __('admin.provides.enter_amount') }}" value="" autocomplete="off">
                    </div>
                </div>

               
                <button type="submit" class="btn btn-accent"> {{ __('admin.provides.add_amount') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>


@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{
    var id = "";
    basicFunctions();

    

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            amount: { required: true,min: 1 },
            
           
		},

		messages: {
			amount: { required: "Amount  is required." },
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
            var url = getBaseUrl() + "/admin/provider/addamount/"+"{{$id}}";
            saveRow( url, table, data);
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

  
});
</script>
