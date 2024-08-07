@extends('common.provider.layout.base')
@section('styles')
@parent
@stop
@section('content')
<!-- Schedule Ride Modal -->

<div id="toaster" class="toaster"></div>
<section class="taxi-banner z-1 content-box" id="booking-form">
	<!-- <div class="col-md-12 col-sm-12 col-xl-12 text-center dis-end d-none  mt-2 d-sm-block d-block d-md-none d-xl-none  online">
				<p class="p-0 go-online">{{ __('Go Online') }}</p>
				<span class="p-0 go-offline d-none">{{ __('Go Offline') }}</span>
				<label class="toggleSwitch nolabel" onclick="">
					<input id="service_status" type="checkbox" checked />
					<span>
						<span class="show1">{{ __('OFF') }}</span>
						<span class="show2">{{ __('ON') }}</span>
					</span>
					<a></a>
				</label>
			</div> -->
    <div id="root"></div>
</section>

	<section class="p-0 dis-column  online-msg content-box mamdatory_section ">
		<div class="col-xl-6 col-sm-12 col-md-12 mamdatory_div  dis-column bg-body p-5">
			<h4 class=" mb-2 txt-primary "><strong>Kindly fill the necessary details</strong></h4>
			<ul class="featureList">
				<li class="tick profile"><span>Add Profile Picture</span></li>
				<!-- <li class="tick address"><span>Add Address</span></li> -->
			    <li class="tick service"><span>Add Services</span></li>
				<li class="tick document"><span>Add Documents</span></li>
				<li class="tick bankdetail"><span>Add Bank Details</span></li>
				<li class="tick minwalletbalance"><span>Add Money In Wallet</span></li>
			</ul>
			<div class="or-section mt-2 mb-3">
				<hr>
				<span>OR</span>
				<hr>
			</div>
			<ul class="dis-row row">
				<li class="pl-3 pr-3 bor-right">
					<p class="m-0"><b><i class="fa fa-phone pr-1" aria-hidden="true"></i></b> {{ Helper::getSettings()->site->contact_number[0]->number }} </p>
				</li>
				<li class="pl-3 pr-3 bor-right">
					<p class="m-0"><b><i class="fa fa-envelope pr-1" aria-hidden="true"></i></b> {{ Helper::getSettings()->site->contact_email }} </p>
				</li>
				<li class="pl-3 pr-3 ">
					<p class="m-0"><b><i class="fa fa-globe pr-1" aria-hidden="true"></i></b> {{ Helper::getSettings()->site->help }} </p>
				</li>
			</ul>
		</div>

	</section>

	<section class="p-0 dis-column online-msg content-box offline_img ">
		<img src="{{ asset('assets/layout/images/common/svg/offline.svg') }}" class="w-25 offline-img">
	    <h4 class=" mb-2 txt-primary "><strong>Go Online </strong></h4>
	</section>

@stop
@section('scripts')
@parent
<script>
var city_id = @if(Helper::getDemomode() == 0) getProviderDetails().city_id @else '0' @endif;
var provider_id = @if(Helper::getDemomode() == 0) getProviderDetails().id @else '0' @endif;
window.common_room = `room_{{ base64_decode(Helper::getSaltKey()) }}_${city_id}`;
window.provider_room = `room_provider_{{ base64_decode(Helper::getSaltKey()) }}_${provider_id}`;


$(document).ready(function() {
var providerdata={};
		$.ajax({
			type:"GET",
			url: getBaseUrl() + "/provider/profile",
			headers: {
				Authorization: "Bearer " + getToken("provider")
			},
			success:function(data){
				var result = data.responseData;
				providerdata=result;
				if(providerdata.status =="APPROVED"){
					$('.mamdatory_section').hide();
					$('.offline_img').hide();
					$('#booking-form').removeClass('d-none');
					$('.online').removeClass('d-none');
					
				}else if(providerdata.is_document !=0 && providerdata.is_bankdetail !=0 && providerdata.is_service !=0 && providerdata.is_profile !=0  ) {
					$('.mamdatory_div').hide();
					$('.mamdatory_section').html('<h5> Waiting For Admin Approval</h5>');
					$('#booking-form').addClass('d-none');
					$('.offline_img').hide();

				}else{
					$('#booking-form').addClass('d-none');
					$('.offline_img').hide();

				}

				if(providerdata.is_online==0 && providerdata.status =="APPROVED" ){
				$('#service_status').attr('checked',false);
				$('.mamdatory_section').hide();
				$('#booking-form').addClass('d-none');
				$('.offline_img').show();
				}

				if(providerdata.is_profile==0){
				$('.profile').removeClass('tick');
				$('.profile').addClass('cross');
				$('.profile').append('<a class="txt-primary" href="{{ url("provider/profile/general") }}"> click here</a>');
				}
				// if(providerdata.is_address==0){
				// 	$('.address').removeClass('tick');
				// 	$('.address').addClass('cross');
				// 	$('.address').append(' <a class="txt-primary" href="{{ url("provider/profile/provider_address") }}"> click here</a>');
				// }
				
				if(providerdata.is_document==0){
				$('.document').removeClass('tick');
				$('.document').addClass('cross');
				$('.document').append('<a class="txt-primary" href="{{ url("provider/document/ALL") }}"> click here</a>');
				}

				if(providerdata.is_bankdetail==0){
					$('.bankdetail').removeClass('tick');
					$('.bankdetail').addClass('cross');
					$('.bankdetail').append(' <a class="txt-primary" href="{{ url("provider/profile/payment_method") }}"> click here</a>');
				}

				if(providerdata.is_service==0){
					$('.service').removeClass('tick');
					$('.service').addClass('cross');
					$('.service').append(' <a class="txt-primary" href="{{ url("provider/myservice") }}"> click here</a>');
				}

				if(providerdata.is_walletbalance_min==0){
					$('#service_status').attr('checked',false);
					$('.minwalletbalance').removeClass('tick');
					$('.minwalletbalance').addClass('cross');
					$('.minwalletbalance').append(' <a class="txt-primary" href="{{ url("provider/wallet") }}"> click here</a>');
					$('.mamdatory_section').show();
					$('#booking-form').addClass('d-none');
				}


			}
		});
     $('#service_status').change(function () {
		var is_online=0;
		var that = $(this);
		if (that.is(":checked")) {
			    $('.mamdatory_section').hide();
				$('.offline_img').hide();
				$('#booking-form').removeClass('d-none');
				is_online=1;
		} else {
			    $('.offline_img').show();
				$('#booking-form').addClass('d-none');

		}
		$.ajax({
		url: getBaseUrl() + "/provider/onlinestatus/"+is_online,
		type: "GET",
		headers: {
			Authorization: "Bearer " + getToken("provider")
		},
		success:function(data){
			    var providerdata=localStorage.getItem('provider');
                providerdata=JSON.parse(decodeHTMLEntities(providerdata));
                providerdata.is_online=is_online;
                localStorage.setItem("provider", JSON.stringify(providerdata));
		}, error: (jqXHR, textStatus, errorThrown) => {
			if (that.is(":checked")) { that.prop('checked', false); }
			else { that.prop('checked', true); }
		    $('.offline_img').show();
			$('#booking-form').addClass('d-none');
			$('#service_status').attr('checked',false);
				
		}
    });  


	});
	//For send mail concept
	$('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            email: { required: true },
		},
		messages: {
			email: { required: "Email is required." },
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
            var url = getBaseUrl() + "/provider/referemail";
            saveRow( url, table, data);
		}
    });
});


</script>
<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.production.min.js"></script> -->

<script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.development.js"></script>

<script type="text/babel" src="{{ asset('assets/layout/js/incoming.js') }}"></script>
@stop
