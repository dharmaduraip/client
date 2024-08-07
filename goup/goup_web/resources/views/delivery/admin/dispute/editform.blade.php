{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            <h6 class="m-0">{{ __('admin.dispute.update_delivery_dispute') }}</h6>
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
					<div class="form-group col-md-6">
					<label for="dispute_user" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_user') / @lang('admin.dispute.dispute_provider')</label>
						<input class="form-control" type="text"  name="name" id="dispute_user" disabled="">
					</div>
				</div>		
				 		
				  <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.request')</label>
		                <table class="table table-striped table-bordered dataTable requestList">
		                    <thead>
		                        <tr>
		                            <th>{{ __('Request Id') }}</th>
		                            <th>{{ __('From') }} </th>
		                            <th>{{ __('To') }} </th>
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
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_refund')<span class="currency"></span></label>
						<input class="form-control" type="number"  name="refund_amount" id="refund_amount">
					</div>
					<div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_status')</label>
					<input class="form-control" type="text" id="editstatus" readonly value="" name="status">
					</div>
				</div>
				
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-accent float-right">@lang('admin.dispute.update_delivery_dispute')</button>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function()
{
     basicFunctions();
     var id = "";
     if($("input[name=id]").length){

        id = $("input[name=id]").val();
        var url = getBaseUrl() +"/admin/delivery/requestdispute/"+id;

		$.ajax({
            url: url,
            type: "GET",
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success: function(data) {
				if(data.responseData.dispute_type =="user"){
					 
                     $("#dispute_user").val(data.responseData.user.first_name+" "+data.responseData.user.last_name);
                }else{
                     $("#dispute_user").val(data.responseData.provider.first_name+" "+data.responseData.provider.last_name);
                }
				 $("#dispute_type").val(data.responseData.dispute_type.charAt(0).toUpperCase()+data.responseData.dispute_type.slice(1));
				 $("#dispute_comments").val(data.responseData.comments);
				 $("#dispute_name").val(data.responseData.dispute_name);
				 $("#refund_amount").val(data.responseData.refund_amount);
				 $("#editstatus").val(data.responseData.status.charAt(0).toUpperCase()+data.responseData.status.slice(1));
				 $(".currency").text(" ("+data.responseData.request.currency+")");
				 $("#tbody").empty().append(`<tr>
		                   			<td>`+data.responseData.request.booking_id+`</td>
		                   			<td>`+data.responseData.request.s_address+`</td> 
		                   			<td>`+data.responseData.request.d_address+`</td> 
		                   		     </tr>`);

			}

            });


          }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            status: { required: true },
		},

		messages: {
			status: { required: "status is required." },
		
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
            var url = getBaseUrl() +"/admin/delivery/requestdispute/"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});

</script>
