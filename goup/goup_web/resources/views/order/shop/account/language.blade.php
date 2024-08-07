@extends('order.shop.layout.base')
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
@section('title') @lang('admin.account.language') @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">@lang('admin.account.language')</span>
            <h3 class="page-title">@lang('admin.account.language')</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">@lang('admin.account.language')</h6>
                </div>
                <div class="col-md-12">
					<form class="validateForm">
						@csrf()
						@if(!empty($id))
							<input type="hidden" name="_method" value="PATCH">
							<input type="hidden" name="id" value="{{$id}}">
						@endif
						
						 <div class="col-md-12 pro-form dis-ver-center p-0">
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.language')</strong></h5>
                              <select class="form-control" name="language" id="language" @if(Helper::getDemomode() == 1) disabled="true" @endif>
                                 @foreach(Helper::getSettings()->site->language as $language)
                                 <option value="{{$language->key}}">{{$language->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                		<button type="submit" class="btn btn-accent float-right">@lang('admin.account.language')</button>
						<br><br><br>
					</form>
                </div>  
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
@parent
<script>
$(document).ready(function()
{
     basicFunctions();

	 var id = "";
	 
	 //List the profile details
	 $.ajax({
        type:"GET",
        url: getBaseUrl() + "/shop/language",
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        success:function(data){
			var result = data.responseData;
			 if(result.language!=''){ 
                  $('#language').val(result.language).prop('readonly',true);
               }		
        }
    });

     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
             language: { required: true },
		},
		messages: {
			 language: { required: "Language is required." },
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
			  $.ajax({
                  url: getBaseUrl() + "/shop/language",
                  type: "post",
                  data: data,
                  processData: false,
                  contentType: false,
                  headers: {
                        Authorization: "Bearer " + getToken('shop')
                  },
                  beforeSend: function (request) {
                        showInlineLoader();
                  },
                  success: function(response, textStatus, jqXHR) {
                        var data = parseData(response);

                        setShopDetails(data.responseData);
                        document.cookie="shop_language="+data.responseData.language;
                        alertMessage("Success", data.message, "success");
                        hideInlineLoader();
                     
                        location.reload();
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                        
                        if (jqXHR.status == 401 && getToken(guard) != null) {
                           refreshToken(guard);
                        } else if (jqXHR.status == 401) {
                           window.location.replace("/shop/login");
                        }

                        if (jqXHR.responseJSON) {
                           
                           alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                        }
                        hideInlineLoader();
                  }
               });
         
			// var url = getBaseUrl() + "/shop/language";
			// var data= saveRow( url, null, data,"shop",'/shop/dashboard'); 
		
			

		}
    });
	

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>

@stop






















