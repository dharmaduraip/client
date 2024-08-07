@if(\Request::segment(1) == 'manage_addresses')
<div id="map_modal" class="  left-menu">
	<div class="closebtn">
		<i class="closefilter closeicon2"></i><span>Save delivery address</span>
	</div>
	<form role="form" action="" method="post" id="address_form">
		<div class="">
			<div class="step1"><div id="myaddrMap"></div><br/></div>
			<div class="step2">
				<div class="no-pad" ng-show="vm.newAddressStep == '2'">
					<div class="col-xs-12 no_pad">
						<div class="address_values">
							<div class="input_group active" >
								<input class="input_box" disabled id="location" name="location"  value="">
								<label class="floating-label" id="log_email" for="mobile">{!! Lang::get("core.address_details") !!}123</label>
							</div>
							<div class="alert_fn"></div>
						</div>
						<div class="save_more_add">
							<div class="input_group">
								<input class="input_box" name="building" required value="" id="building" >
								<label class="floating-label">{!! Lang::get("core.build_flat") !!}</label>
							</div>
							<div class="input_group" >
								<input class="input_box" name="landmark" id="landmark" >
								<label class="floating-label">{!! Lang::get("core.add_landmark") !!}</label> 
							</div>
							<div class="group save_adrs" >
								<input class="hide" type="radio" name="address_type" id="address_type_1" required value="1" hidden>
								<label class="annotation" for="address_type_1"> 
									<i class="fa fa-home me-1"></i>{!! Lang::get("core.home") !!}
									<span class="checkmark"></span>
								</label> 
								<input class="hide" type="radio" name="address_type" id="address_type_2" required value="2" hidden>
								<label class="annotation" for="address_type_2"> 
									<i class="fa fa-briefcase me-1"></i>{!! Lang::get("core.work") !!}
									<span class="checkmark"></span>
								</label> 
								<input class="hide" type="radio" name="address_type" id="address_type_3" required value="3" hidden>
								<label class="annotation" for="address_type_3">
									<i class="fa fa-book me-1"></i>{!! Lang::get("core.others") !!}
									<span class="checkmark"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" id="id" value="">
			<input type="hidden" name="a_lat" id="a_lat" value="">
			<input type="hidden" name="a_lang" id="a_lang" value="">
			<input type="hidden" name="a_addr" id="a_addr" value="">
		</div>
		<button type="submit" class="save_address go_to_step">{!! Lang::get("core.save_address") !!}</button>
	</form>
</div>
<script src="{{ asset('sximo5/js/plugins/jquery.validate.min.js')}}"></script> 
<script type="text/javascript">
	$("#address_form").validate({
		// Rules for form validation
		rules:
		{
			building:
			{
				required: true,

			},
			landmark:
			{
				required: true,

			},
			address_type:
			{
				required: true,

			}
		},

		// Messages for form validation
		messages:
		{
			building:
			{
				required: '{!! Lang::get("core.enter_building") !!}',
			},
			landmark:
			{
				required: '{!! Lang::get("core.enter_landmark") !!}'
			},
			address_type:
			{
				required: '{!! Lang::get("core.enter_address") !!}'
			}
		},
		submitHandler: function(form) {
			var purl = "{{ URL::to('/')}}/updateaddress";
			var id = $('#address_form').find("#id").val();
			$.ajax({
				url: purl,
				type: 'post',
				data:  $('#address_form').serialize(),
				success: function(data) {
					if(data != ''){

						/*$("#map_modal").modal("hide");*/
						$("#map_modal").removeClass("left-active");
						$('.overlay').hide();
						if(id!= '')
						{
							$(".fn_"+id).html(data);
						}else
						{
							$('.user_address').append(data);
						}
					}
				}
			});
		},
		// Do not change code below
		errorPlacement: function(error, element)
		{
			error.insertAfter(element.parent());
		}
	});
</script>
@endif
@if(\Request::segment(1) == 'orders')
<div id="rating_popup" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm modal-sm-ex">
		<div class="modal-content col-xs-12 nopadding">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Order Rating</h4>
			</div>
			<div class="modal-body col-xs-12">
				<center class="rating_section">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="empty_message" style="display: none;"><font color="red">{!! trans('core.abs_select_rating') !!}</font></div>
						<div class="rest_img" style=""></div>
						<div><a class="res_link" href="javascript:void(0);"><span class="popup_res_name">Restront name</span></a></div>
						<div class="star-rating rating_content" id="restrating"></div>
						<div><textarea id="restcomment" rows="3" placeholder="Please type your comments"></textarea></div>
					</div>  
				</center>
				<center class="rating_section1">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="empty_message" style="display: none;"><font color="red">{!! trans('core.abs_select_rating') !!}</font></div>
						<div class="boy_img" style=""></div>
						<div><span class="">Delivery Boy</span></div>
						<div class="star1-rating1 rating_content1" id="boyrating"></div>
						<div><textarea id="boycomment" rows="3" placeholder="Please type your comments"></textarea></div>
					</div>   
				</center>
				<center class="rating_section rating_btn">
					<div class="col-xs-12">
						<input type="hidden" id="rat_boy_id" value="">
						<input type="hidden" id="rat_res_id"  value="">
						<input type="hidden" id="rat_order_id" value="">
						<button type="button" class="close" data-dismiss="modal">Not Now</button>
						<input type="button" id="rating_submit" class="btn btn-primary label-success pull-right"  placeholder="{{trans('core.msg_type_here')}}" value="Submit" onclick="sendrating();">
					</div>
				</center> 
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on('click',".give_rating",function(){
		var res_name = $(this).closest("tr").find(".order_res_name").text();
		var res_image = $(this).closest("tr").find(".res_image").val();
		var boy_image = $(this).closest("tr").find(".boy_image").val();
		var res_id = $(this).data('resid');
		var content = boycontent = '';var i; var checked; var j;
		var oid = $(this).data('orderid');
		var oldRating = $("#old_rating_"+oid).val();
		var boyoldcomment = $(this).data('boycomment');
		var oldcomment = $(this).data('comments');
		for(i=5;i>=1;i--) {
			if(oldRating == i)
				checked = "checked";
			else
				checked = " ";
			content += '<input name="rating" type="radio" value="'+i+'" id="condition_'+i+'" class="star-rating-input"'+checked+'><label for="condition_'+i+'" class="star-rating-star js-star-rating"><i class="fa fa-star"></i>&nbsp;</label>';
		}
		$(".popup_res_name").text(res_name);
		$('#restcomment').val(oldcomment);
		$('#boycomment').val(boyoldcomment);
		$(".rest_img").css('background-image',"url('"+res_image+"')");
		$(".res_link").attr("href",base_url+"frontend/details/"+res_id);
		$("#rat_res_id").val(res_id);
		$("#rat_order_id").val(oid);

		$("#restrating").html(content);
		var boyid = $(this).data('boyid');

		var oldRatingboy = $("#oldratingboy_"+oid).val();
		for(j=5;j>=1;j--) {
			if(oldRatingboy == j)
				checked = "checked";
			else
				checked = " ";
			boycontent += '<input name="ratingboy" type="radio" value="'+j+'" id="condition1_'+j+'" class="star1-rating1-input1"'+checked+'><label for="condition1_'+j+'" class="star1-rating1-star1 js-star-rating1"><i class="fa fa-star"></i>&nbsp;</label>';
		}
		$('#rat_boy_id').val(boyid);
		$('#boyrating').html(boycontent);
		$('.boy_img').css('background-image',"url('"+boy_image+"')");
		if(parseInt(oldRatingboy) > 0 && boyoldcomment != '' && parseInt(oldRating) > 0 && oldcomment != ''){
			$(".rating_btn").hide();
		} else {
			$(".rating_btn").show();
		}
		$("#rating_popup").modal('show');
	})
	function sendrating(){
		var rating_val = 0;
		var boyrating_val = 0;
		var res_id = $("#rat_res_id").val();
		var oid = $("#rat_order_id").val();
		var comment = $('#restcomment').val();
		var boyid = $('#rat_boy_id').val();
		var boycomment = $('#boycomment').val();
		if ($("input[name='rating']:checked").length > 0) {
			rating_val = $('input:radio[name=rating]:checked').val();
		}
		if ($("input[name='ratingboy']:checked").length > 0) {
			boyrating_val = $('input:radio[name=ratingboy]:checked').val();
		}
		if(res_id != '') {
			$(".mol_overlay").show();
			$.ajax({
				url : base_url+"saverating",
				type : "POST",
				data : { rid : res_id, rating : rating_val, oid : oid, boyid : boyid, comment : comment, boycomment : boycomment, boyrating : boyrating_val },
				dataType : "json",
				success :function (data) {
					$(".mol_overlay").hide();
					if(data.message == 'success'){
						$("#old_rating_"+oid).val(rating_val);
						$("#rating_popup").modal('hide');
						location.reload();
					} else {
						alert('Nothing updated');
					}
				},
				error : function(err){
					$(".mol_overlay").hide();
					alert('Something went updated');
				}
			})
		} else {
			if(rating_val == 0){
				$("#empty_message").show();
				setTimeout(function(){ $("#empty_message").hide() },5000);
			}
		}
	}
	$(document).on('click','#cancelorderid',function(){
		var restid = $(this).data('resid');
		var orderid = $(this).data('orderid');
		$.ajax({
			url: base_url+'frontend/customercancel',
			type: 'post',
			data:{ orderid : orderid, restid: restid },
			success:function(res){
				res = JSON.parse(res);
				if(res == '1'){
					alert('order cancelled successfully!');
					location.reload();
				}else{
					alert('refund process failed!');
					//location.reload();
				}
			}
		});
	});
</script>
@endif
@if(\Request::segment(1) == 'details')
<div class="modal fade" id="foodModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content order-content">
		</div>
	</div>
</div>
<div class="modal fade clear-cart " tabindex="-1" role="dialog" id="switch_cart" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
				<h4 class="modal-title text-danger" id="myModalLabel">{!! Lang::get('core.clear_cart') !!}?</h4>
			</div>
			<div class="modal-body text-center">
				<p>{!! Lang::get('core.start_refresh') !!}</p>
				<input type="hidden" name="cart_item" id="cart_item" value="">
				<input type="hidden" name="cart_qty" id="cart_qty" value="">
				<input type="hidden" name="cart_res" id="cart_res" value="">
				<input type="hidden" name="ad_id" id="ad_id" value="">
				<input type="hidden" name="ad_type" id="ad_type" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn  btn red" data-bs-dismiss="modal">{!! Lang::get('core.take_back') !!}</button>
				<button type="button" class="btn  btn-primary add_new_cart_item" >{!! Lang::get('core.start_refresh_yes') !!}</button>
			</div>
		</div>
	</div>
</div>
@endif