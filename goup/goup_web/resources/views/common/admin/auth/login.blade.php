@extends('common.admin.layout.auth')
@section('title') Admin @stop

@section('content')
@include('common.alert')
<section class="login">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="basic_form login_form">
				<!-- <h1 id = "login_status">Login</h1> -->
				<div class="dis-center" style="margin-bottom: 10px;">
                    <img id="main-logo" class="d-inline-block align-top mr-1" src="{{ Helper::getSiteLogo() }}" alt="Logo" style="width: 100px;height: auto;">
                         
                                                   <!-- <span class="d-none d-md-inline ml-1" style="line-height: 3"> GO -X </span> -->
                </div>
				<h1 id ="login_status">Admin Login</h1>
				<ul class="nav  form_type align-itmes-center justify-content-center" id ="admin">
                        <li data-target="admin" class="active user-type">Admin </li>
                        <li data-target="dispatcher" class="user-type">Dispatcher</li>
						<li data-target="account" class="user-type">Account</li>
						<li data-target="fleet" class="user-type">Fleet</li>
						<li data-target="dispute" class="user-type">Dispute</li>
				</ul>
				<div class="form_cnt"> 
                    <div class="form_bdy admin active_form">
						<form role="form" class="validateForm">
							<input type =hidden name='role'  value="">
							<input type="hidden" name="salt_key" value="{{Helper::getSaltKey()}}">
							<div class="form-group">
								<label class="control-label"><strong>Email </strong> <span>*</span></label>
								<div class="basic_tpy_sec"><input  maxlength="100" type="text" required="required" id="email" name="email" class="form-control" placeholder="Email" /></div>
							</div>

							<div class="form-group">
								<label class="control-label"><strong>Password </strong><span>*</span></label>
								<div class="basic_tpy_sec"><input maxlength="100" type="password" required="required" id="password" name="password" class="form-control" placeholder="Password"></div>
							</div>

							<div class="login_btn">
								<button class="btn btn-success   login_btn" type="submit" >Sign in</button>
							</div>
                        	
						</form>

					</div>
					<br>
					<span>Forgot your Password?
						<strong>
							<a href="javascript:;" class="signup-link forgotPassword"> <span class="txt-label pl-2">Reset Here</span></a>
						</strong>
					</span>
				</div>
				
			</div>

		</div>
		</div>
	</div>
</section>
@stop

@section('scripts')
@parent

<script>
$('.form_type li').click(function()
{
	$(this).siblings().removeClass('active');
	$(this).addClass('active');
	$('.form_cnt .form_bdy').siblings().removeClass('active_form');
	var x=$(this).data('target');
	$('.'+x).addClass('active_form');
});
$("input[name=role]").val('Admin');
var default_name = '  Login';
$('.user-type').on('click',function(){
	var name = $(this).text();
	$("#login_status").empty().append(name + ' Login');
	$("input[name=role]").val(name);
});

$('.closeheadertop').click(function(){
	$(".headeralert").hide();
})


$(document).ready(function() {
	 var MyNameSpace = {
            config:
            {
               adminurl: "{{ url('/admin/') }}"
            }
         }
   
	var base_url_data = JSON.parse(decodeHTMLEntities('{{$base}}'));

	for(var i in Object.keys(base_url_data)) {
		var key = String(Object.keys(base_url_data)[i]);
		var value = String(Object.values(base_url_data)[i]);
		localStorage.setItem(key, value);
	}

	setBaseUrl('{{$base_url}}');

	var formGroup = $(".validateForm").serialize().split("&");

	var data = new FormData();

		for(var i in formGroup) {
			var params = formGroup[i].split("=");
			data.append( params[0], decodeURIComponent(params[1]) );

		}

		// data.append( 'salt_key', '{{Helper::getSaltKey()}}');
		// console.log(data); 

		$('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            email: { required: true, email: true },
            password: { required: true },
		},

		messages: {
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
           
            $.ajax({
				url: getBaseUrl() + "/admin/login",
				type: "post",
				data: data,
				processData: false,
				contentType: false,
				success: function(response, textStatus, jqXHR) {
					var data = parseData(response);
					setToken("admin", data.responseData.access_token);
					setAdminDetails(data.responseData.user);
					var language = data.responseData.user.language != null ? data.responseData.user.language : 'en';
					document.cookie="admin_language="+language+"; path=/";
					document.cookie="admin_login=1; path=/";
					$.ajax({
						url: MyNameSpace.config.adminurl+"/permission_list/"+data.responseData.user.id+"/token/"+getToken("admin"),
						type: "get",
						processData: false,
						contentType: false,
						success: function(response, textStatus, jqXHR) {
							window.location.replace("{{ url('/admin/dashboard') }}");
						},
					});
					// window.location.replace("{{ url('/admin/dashboard') }}");
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
				}
			});
		}
    });

	$('body').on('click', '.forgotPassword', function(e) {

		var type = $("input[name=role]").val();
		para = '?type='+type;
        window.location.replace("{{ url('/admin/forgotPassword') }}"+para); 
    });

});
</script>
@stop
