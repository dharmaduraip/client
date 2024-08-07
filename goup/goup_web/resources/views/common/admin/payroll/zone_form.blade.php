{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0" style="margin:10!important;"> {{$action_text}} {{ __('Zone') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm" files="true">
                @csrf()
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif

               
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="country_id">{{ __('admin.country.country_name') }}</label>
                        <select name="country_id" id="country_id" class="form-control">
                        <option value="">Select</option>
                        @foreach(Helper::getCountryList() as $key => $country)
                            <option value={{$key}}>{{$country}}</option>
                        @endforeach
						</select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city_id">{{ __('admin.country.city_name') }}</label>
                        <select name="city_id" id="city_id" class="form-control">
						</select>
                    </div>
                </div>
              
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="user_type">{{ __('admin.country.user_type') }}</label>
                        <select name="user_type" id="user_type" class="form-control">
                        <option value="SHOP"> Shop   </option>
                        <option value="PROVIDER"> Provider  </option>
                        <option value="FLEET">  Fleet  </option>
						</select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="first_name">{{ __('admin.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Zone') }}</button>
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

    $('#country_id').on('change', function(){ 
        
        var country_id =$("#country_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/countrycities/"+country_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#city_id").empty();
                $("#city_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                });

                hideInlineLoader();
            }
        });
    });
    
    if($("input[name=id]").length){

        id = "/" +$("input[name=id]").val();
        var url = getBaseUrl() + "/admin/zone"+id;
        setData( url );
    }

        
    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true },         
            country_id: { required: true },
            city_id: { required: true },
		},

		messages: {
			name: { required: "Zone name is required." },
            country_id: { required: "Country is required." },
            city_id: { required: "City is required." },
		},

		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
           
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
            $('.selected-flag').css('height','100%');
		},

		submitHandler: function(form) {

            var formGroup = $(".validateForm").serialize().split("&");

            var data = new FormData();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            var url = getBaseUrl() + "/admin/zone"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>