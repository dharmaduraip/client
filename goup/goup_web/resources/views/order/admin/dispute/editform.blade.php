{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
          <h6 class="m-0">{{ __('admin.dispute.update_order_dispute') }}</h6>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
		
				  <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="dispute_type" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_type')</label>
						<input class="form-control" type="text"  name="name" id="dispute_type" disabled="">
					</div>
				</div>		

				  <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="dispute_user" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_user') / @lang('admin.dispute.dispute_provider')</label>
						<input class="form-control" type="text"  name="name" id="dispute_user" disabled="">
					</div>
				</div>				

				  <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.lostitem.request')</label>
		                <table class="table table-striped table-bordered dataTable requestList">
		                    <thead>
		                        <tr>
		                            <th>{{ __('Request Id') }}</th>
		                            <th> {{ __('Store') }} </th>
		                        </tr>
		                    </thead>
		                    <tbody id="tbody">
		                   	
		                    </tbody>
		                   
		                </table>
					</div>
				</div>

				<div class="form-row">
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_name')</label>
						<textarea class="form-control" name="dispute_other" id ="dispute_name" placeholder="@lang('admin.dispute.dispute_name')" disabled=""></textarea>
					</div>
				</div>

				<div class="form-row">
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_comments')</label>
						<textarea class="form-control" name="comments" id="dispute_comments" placeholder="@lang('admin.dispute.dispute_comments')" required=""></textarea>
					</div>
				</div>
              <div class="form-row">
				<div class="form-group col-md-6 common adminstatus">
					<label for="status" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_status')</label>
					<select class="form-control  admin_status"  name="admin_status" >
					<option value="">--Please Select--</option>
					</select>
					</div>
				</div>
				<div class="form-row">
                    <div class="form-group col-md-6 refund_amount common">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_refund') <span class="currency"></span></label>
						<input class="form-control decimal " type="text"  name="refund_amount" id="refund_amount">
					</div>
				</div>
                <div class="form-row">
                    <div class="form-group col-md-6 common  resign">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.Providers')</label>
		                <table class="table table-striped table-bordered dataTable requestList">
		                    <thead>
		                        <tr>
		                            <th>{{ __('Provider Name') }}</th>
		                            <th></th>
		                        </tr>
		                    </thead>
		                    <tbody id="provider">
		                   	
		                    </tbody>
		                   
		                </table>
					</div>
				</div>

			
               
                <br>
				<div>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-accent float-right button_status">{{ __('admin.dispute.update_order_dispute') }}</button>
				</div>
				

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
	 var shop_id="";
     if($("input[name=id]").length){

        id = $("input[name=id]").val();
        var url = getBaseUrl() +"/admin/store/requestdispute/"+id;

		$.ajax({
            url: url,
            type: "GET",
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success: function(data) {
				$('.common').hide();
				$('.refund_amount').hide();
				if(data.responseData.dispute_type =="user"){
					  if(data.responseData.request.paid == 1)  $('.refund_amount').show();
					  $("#dispute_user").val(data.responseData.user.first_name+" "+data.responseData.user.last_name);
                } else if(data.responseData.dispute_type =="system" && data.responseData.dispute_name=="Store Cancelled" ){
					 $('.adminstatus').show();
					 $('.admin_status').append(`<option value='reorder'> Re-Order </option>`);
					 if(data.responseData.request.paid == 1) $('.admin_status').append(`<option value='reject'> Refund </option>`);
					 $('.admin_status').append(`<option value='cancel'> Cancel </option>`);
					 $("#dispute_user").val(data.responseData.user.first_name+" "+data.responseData.user.last_name);
				} else if(data.responseData.dispute_type =="system" && data.responseData.dispute_name=="Store No Response" ){
					 $('.adminstatus').show();
					 $('.admin_status').append(`<option value='reorder'> Re-Order </option>`);
					 if(data.responseData.request.paid == 1) $('.admin_status').append(`<option value='reject'> Refund </option>`);
					 $('.admin_status').append(`<option value='cancel'> Cancel </option>`);
					 $("#dispute_user").val(data.responseData.user.first_name+" "+data.responseData.user.last_name);
               } else if(data.responseData.dispute_type =="system" && data.responseData.dispute_name=="Provider Not Available" ){
				     $('.adminstatus').show(); 
				     $('.admin_status').append(`<option value='resign'> Re-Assign </option>`);
					 if(data.responseData.request.paid == 1) $('.admin_status').append(`<option value='reject'> Refund </option>`);
					 $('.admin_status').append(`<option value='cancel'> Cancel </option>`);
					 shop_id=data.responseData.store_id;
					 $("#dispute_user").val(data.responseData.user.first_name+" "+data.responseData.user.last_name);
                } else{
					if(data.responseData.request.paid == 1) $('.refund_amount').show();
					$("#dispute_user").val(data.responseData.provider.first_name+" "+data.responseData.provider.last_name);
                } 
				$("#dispute_type").val(data.responseData.dispute_type.charAt(0).toUpperCase()+data.responseData.dispute_type.slice(1));
				 $("#dispute_comments").val(data.responseData.comments);
				 $("#dispute_name").val(data.responseData.dispute_name);
				 $("#refund_amount").val(data.responseData.refund_amount);
				 $("#editstatus").val(data.responseData.status.charAt(0).toUpperCase()+data.responseData.status.slice(1));
				 $(".currency").text(" ("+data.responseData.request.currency+")");
				 $("#tbody").empty().append(`<tr>
		                   			<td>`+data.responseData.request.store_order_invoice_id+`</td>
		                   			<td>`+data.responseData.service.store_name+`</td>
		                   		     </tr>`);

			}

            });


          }

		  $('.admin_status').change(function(){
			  var admin_status=$(this).val();
			  $('.resign,.refund_amount').hide();
			  var html=``;
			  $('#provider').html(html);
			  if(admin_status == 'resign'){
			   $('.resign').show();	  
               getprovider(shop_id);
			  } else if( admin_status == 'reject' ){
			  	if(data.responseData.request.paid == 1) {
			  		$('.refund_amount').show();
			  	} else {
			  		$('.refund_amount').hide();
			  	}
			  }

		  });

		function getprovider(store_id){

				$.ajax({
						url: getBaseUrl() +"/admin/store/findprovider/"+store_id,
						type: "GET",
						headers: {
							Authorization: "Bearer " + getToken("admin")
						},
						'beforeSend': function (request) {
                          showLoader();
                        },
						success: function(data) {
							var html='';
							if(data.data.length > 0) {
								$.each(data.data, function( key,item ) {
									html +=`<tr><td>`+item.first_name + item.last_name+`</td>
											<td><input name="provider_id" data-value="`+item.id+`" value="`+item.id+`" type="radio" /></td>
											</tr>`;
									});
							} else {
								html +=`<tr><td colspan="2">No Providers </td></tr>`;
							}
							$('#provider').html(html);	
							hideLoader();
						}	
				});

		}



    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            admin_status: { required: true },
		},

		messages: {
			admin_status: { required: "status is required." },
		
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
			var url = getBaseUrl() +"/admin/store/requestdispute/"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});

</script>
