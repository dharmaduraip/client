{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">

            <h6 class="m-0">{{ __('admin.lostitem.update') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
				<div class="form-row">
                 <div class="form-group col-md-6">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.lostitem.lost_item')</label>
					
						<textarea class="form-control" name="lost_item_name"  id="lost_item_name" placeholder="@lang('admin.lostitem.lost_item')"></textarea>
						
					</div>
				</div>				

				<div class="form-row">
                  <div class="form-group col-md-12">
					<label for="comments" class="col-xs-2 col-form-label">@lang('admin.lostitem.lost_comments')</label>
		            <textarea class="form-control" name="comments" id="comments" placeholder="@lang('admin.lostitem.lost_comments')"></textarea>

					</div>
				</div>

				<div class="form-row">
                  <div class="form-group col-md-12">
					<label for="status" class="col-xs-2 col-form-label">@lang('admin.lostitem.lost_status')</label>
	                    <select class="form-control" name="status" id="status">
						<option value="">Select</option>
						<option value="open">Open</option>
							<option value="closed">Closed</option>
						</select>
                    </div>
				</div>

			
				<button type="submit" class="btn btn-accent ">@lang('admin.edit')</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                

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
        var url = getBaseUrl() +"/admin/lostitem/"+id;
        setData( url );
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
            var url = getBaseUrl() +"/admin/lostitem/"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
var sflag=''; 

$('#namesearch').autocomplete({
    source: function(request, response) {
		$.ajax
	    ({
	        type: "GET",
	        url: getBaseUrl() +"/admin/usersearch",
	        data: {stext:request.term},
	        dataType: "json",
            headers: {
                "Authorization": "Bearer " + getToken("admin")
            },
	        success: function(responsedata, status, xhr)
	        {
				//console.log(responsedata);
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
	                        id: item.id,                                        
	                        bal: item.wallet_balance                                        
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
	        $("#wallet_balance").text("-");
	    }
	    else{
	        if(ui.item.id==0){
	            $("#namesearch").val('');
	            $("#namesearch").focus();
	            $("#wallet_balance").text("-");
	        }
	    }            
	},
	select: function (event, ui) {  

		$.ajax({
	        url: getBaseUrl() +"/admin/ridesearch",
			type: 'post',
            headers: {
                "Authorization": "Bearer " + getToken("admin")
            },
			data: {
				_token : '{{ csrf_token() }}',
				id: ui.item.id
			},
			success:function(data, textStatus, jqXHR) {
				var requestList = $('.requestList tbody');
				requestList.html(`<tr><td colspan="4">@lang('No Records')</td></tr>`);
				if(data.data.length > 0) {
					var result = data.data;
					for(var i in result) {
						requestList.html(`<tr><td>`+result[i].booking_id+`</td><td>`+result[i].s_address+`</td><td>`+result[i].d_address+`</td><td><input name="request_id" value="`+result[i].id+`" type="radio" /></td></tr>`);
					}
				} else {
					requestList.html(`<tr><td colspan="4">No Results</td></tr>`);
				}
			}
		});
  
	    $("#from_id").val(ui.item.id);
	    $("#wallet_balance").text(ui.item.bal);
	} 
});
</script>
