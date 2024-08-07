{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.dispute.add_order_dispute'))
            @else
                @php($action_text=__('service.admin.dispute.edit'))
            @endif    
            <h6 class="m-0">{{$action_text}}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
			   <div class="form-row">
                   <div class="form-group col-md-6">
					<label for="user" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_type')</label>
						<select class="form-control" name="dispute_type" id="dispute_type">
							<option value="user">User</option>
							<option value="provider">Provider</option>
						</select>
					</div>
				</div>		

			   <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="user" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_user') / @lang('admin.dispute.dispute_provider') </label>
							<input class="form-control" type="text" value="{{ old('name') }}" name="name" id="namesearch" placeholder="Search Name" required="" aria-describedby="basic-addon2" autocomplete="off">
						 	<span class="input-group-addon fa fa-search"  id="basic-addon2"></span>
						<input type="hidden" name="user_id1" id="user_id1" value="">
					</div>
				</div>				

			    <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.lostitem.request')</label>
		                <table class="table table-striped table-bordered dataTable requestList">
		                    <thead>
		                        <tr>
		                            <th>{{ __('Request Id') }}</th>
		                            <th> {{ __('Shop') }} </th>
		                            <th>{{ __('Choose') }}</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                   		<tr><td colspan="4">{{ __('No Results') }}</td></tr>
		                    </tbody>
		                </table>
					</div>
				</div>

			    <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.dispute.dispute_name')</label>
						<select class="form-control" name="dispute_name" id="dispute_name" required="">
							<option value="">Select</option>
						</select>
						<textarea style="display: none;margin-top:5px;" class="form-control" name="dispute_other" required id="dispute_other" placeholder="@lang('admin.dispute.dispute_name')">{{ old('dispute_other') }}</textarea>
					</div>
				</div>
               
				<br>
                <button type="submit" class="btn btn-accent">{{$action_text}}</button>				
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
        var url = getBaseUrl() +"/admin/store/requestdispute"+id;
        setData( url );
     }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            namesearch: { required: true },
            
		},

		messages: {
			namesearch: { required: "Name is required." },
			
		
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
			   data.append('store_id', $('input[name="request_id"]:checked').data("value"));
            var url = getBaseUrl() +"/admin/store/requestdispute"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});

var sflag='';
get_disputes('user');
$("#dispute_type").on('change', function(){
	$("#namesearch").val('');
	$('.requestList tbody').html('<tr><td colspan="4">No Results</td></tr>');
	get_disputes($(this).val());
	$("#dispute_other").hide();
	$("#dispute_other").attr('required', false);
});

$("#dispute_name").on('change', function(){
	if($(this).val()=='others'){
		$("#dispute_other").show();
		$("#dispute_other").attr('required', true);
	}
	else{
		$("#dispute_other").hide();
		$("#dispute_other").attr('required', false);
	}
});	

$('#namesearch').autocomplete({
    source: function(request, response) {
    	var url= getBaseUrl() +"/admin/user-search";
    	sflag=0;
    	if($("#dispute_type").val()=='provider'){
    		sflag=1;
    		url= getBaseUrl() +"/admin/provider-search";
    	}
	    $.ajax
	    ({
	        type: "GET",
			url: url,
			headers: {
                "Authorization": "Bearer " + getToken("admin")
            },
	        data: {stext:request.term},
	        dataType: "json",
	        success: function(responsedata, status, xhr)
	        {
	            if (!responsedata.data.length) {
	                var data=[];
	                data.push({
	                        id: 0,
	                        label:"@lang('No Records')"
	                });
	                response(data);
	            }
	            else{
	             response( $.map(responsedata.data, function( item ) {                          
	                    var name_alias=item.first_name+" - "+item.id;
	                  	$('#user_id').val(item.id);
	                    return {                                
	                        value: name_alias,
	                        id: item.id                             
	                    }
	                }));
	            }                   
	        }
	    });
	},
	minLength: 2,
	change:function(event,ui)
	{
	    if (ui.item==null){           
	        $("#namesearch").val('');
	        $("#namesearch").focus();	        
	    }
	    else{
	        if(ui.item.id==0){
	            $("#namesearch").val('');
	            $("#namesearch").focus();	            
	        }
	    }            
	},
	select: function (event, ui) {  

		$.ajax({
			url:  getBaseUrl() +"/admin/store/dispute-order-search",
			type: 'post',
			headers: {
                "Authorization": "Bearer " + getToken("admin")
            },
			data: {
				_token : '{{ csrf_token() }}',
				id: ui.item.id,
				sflag:sflag
			},
			success:function(data, textStatus, jqXHR) {
				var requestList = $('.requestList tbody');
				requestList.html(`<tr><td colspan="4">@lang('No Records')</td></tr>`);
				if(data.data.length > 0) {
					var result = data.data;
					var html='';
					for(var i in result) {
						html+=(`<tr><td>`+result[i].store_order_invoice_id+`</td><td>`+result[i].store.store_name+`</td><td><input name="request_id" data-value="`+result[i].store_id+`" value="`+result[i].id+`" type="radio" /><input name="user_id" value="`+result[i].user_id+`" type="hidden" /><input name="provider_id"  value="`+result[i].provider_id+`" type="hidden" /></td></tr>`);
					}
					requestList.html(html);
				} else {
					requestList.html(`<tr><td colspan="4">No Results</td></tr>`);
				}
			}
		});
  
	    $("#user_id1").val(ui.item.id);
	} 
});

function get_disputes(dispute_type){
	$.ajax({
		url:  getBaseUrl() +"/admin/store/disputelist",
		type: 'get',
		headers: {
                "Authorization": "Bearer " + getToken("admin")
            },
		data: {			
			dispute_type: dispute_type
		},
		success:function(data, textStatus, jqXHR) {
			$('#dispute_name').empty();
			$.each(data, function(key, value) {
			    $('#dispute_name').append($("<option/>", {
			        value: value.dispute_name,
			        text: value.dispute_name
			    }));
			});
			$('#dispute_name').append($("<option/>", {
		        value: 'others',
		        text: 'others'
			}));
			if(data.length > 0) {
				$("#dispute_other").hide();
				$("#dispute_other").attr('required', false);
			}
			else{
				$("#dispute_other").show();
				$("#dispute_other").attr('required', true);			
			}	
		}
	});
}

</script>  
