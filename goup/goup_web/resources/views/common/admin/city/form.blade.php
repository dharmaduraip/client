{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
        @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0" style="margin:10!important;">{{$action_text}} {{ __('City') }}</h6>
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
                        <label for="country_id" class="col-xs-2 col-form-label">{{ __('admin.city.country') }}</label>
                        <select name="country_id" id="country_id" class="form-control">
						</select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="state_id" class="col-xs-2 col-form-label">{{ __('admin.city.state') }}</label>
                        <select name="state_id" id="state_id" class="form-control">
							<option value="">Select</option>
						</select>
                    </div>
                </div>
               
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city_id" class="col-xs-2 col-form-label">{{ __('admin.city.city') }}</label>
                        <select name="city_id" id ="city_id" class="form-control">
							<option value="">Select</option>
						</select>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_status')</label>
                        <select name="status" id = "status" class="form-control">
                            
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-6">
                        <label for="admin_service" class="col-xs-2 col-form-label">{{ __('admin.city.admin_service') }}</label>
                        <select multiple="multiple" name="admin_service[]" id ="admin_service" class="form-control">
                        @foreach(Helper::getServiceList() as $key =>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        </select>
                    </div> -->
                </div>

                <div class="form-row  others d-none">
                <div class="form-group col-md-6">
                    <label for="notify_status" class="col-xs-2 col-form-label">{{ __('admin.city.city') }} @lang('admin.name')</label>
                        <input type="text" class="form-control" id="other_city" name="other_city" />
                    </div>
                </div>
                
                <!-- <div class="form-row">
                <div class="form-group col-md-6">
					<label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_status')</label>
						<select name="status" id = "status" class="form-control">
                            <option value="">Select</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div> -->
               
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('City') }}</button>
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


    
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            country_id: { required: true },
            state_id: { required: true },
            city_id: { required: true },
            admin_service: { required: true },
            status: { required: true },
		},

		messages: {
			country_id: { required: "Country is required." },
            state_id: { required: "State is required." },
            city_id: { required: "City is required." },
            admin_service: { required: "Admin Service is required." },
            status: { required: "Status is required." },

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
                data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }
            var url = getBaseUrl() + "/admin/companycityservice"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/company_country_list",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
                $("#country_id").empty();
                $("#country_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                  if(item.country.length !=0){
                    $("#country_id").append('<option value="'+item.country.id+'">'+item.country.country_name+'</option>');
                  }
                });
             }
    });


      $('#country_id').on('change', function(){
          var country_id =$("#country_id").val();
            $.ajax({
                type:"GET",
                url: getBaseUrl() + "/admin/states/"+country_id,
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                },
                'beforeSend': function (request) {
                    showInlineLoader();
                },
                success:function(data){
                        $("#state_id").html('');
                        $("#state_id").append('<option value="">Select</option>');
                        $.each(data.responseData,function(key,item){
                            $("#state_id").append('<option value="'+item.id+'">'+item.state_name+'</option>');
                        });
                        hideInlineLoader();
                     }

            });
        });
        $('#state_id').on('change', function(){
            var state_id =$("#state_id").val();

            $.ajax({
                type:"GET",
                url: getBaseUrl() + "/admin/cities/"+state_id+"?id="+$("input[name=id]").val(),
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                },
                'beforeSend': function (request) {
                    showInlineLoader();
                },
                success:function(data){
                        $("#city_id").empty();
                        $("#city_id").append('<option value="">Select</option>');
                        $.each(data.responseData,function(key,item){
                            $("#city_id").append('<option value="'+item.id+'">'+item.city_name+'</option>');
                        });
                        $("#city_id").append('<option value="other">Others</option>');
                        hideInlineLoader();
                     }
            });
        });
         $('#city_id').on('change', function(){ 
                if($(this).val()=='other'){
                    $('.others').removeClass('d-none');
                    $('.others').show();
                }else{
                    $('#other_city').val('');
                    $('.others').hide();
                    $('.others').addClass('d-none');
                }

         });
 
        if($("input[name=id]").length){            
            id = "/"+$("input[name=id]").val();
            var url = getBaseUrl() + "/admin/companycityservice"+id;
            var resdata=setData( url );
            setTimeout(function(){ 
                $('#country_id').attr("readonly", false); 
                $('#country_id').css('pointer-events','');
            }, 700);
        }

});
</script>
