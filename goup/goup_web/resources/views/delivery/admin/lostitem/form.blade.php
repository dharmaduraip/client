{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('transport.admin.lostitem.add'))
            @else
                @php($action_text=__('transport.admin.lostitem.edit'))
            @endif    
            <h6 class="m-0" style="margin:10!important;">{{$action_text}}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-row">
                <div class="form-group col-md-12">
					<label for="user" class="col-xs-2 col-form-label">@lang('admin.lostitem.lost_user')</label>
					
							<input class="form-control" type="text" name="name" id="namesearch" placeholder="Search Name" required="" aria-describedby="basic-addon2">
						 	<span class="input-group-addon fa fa-search"  id="basic-addon2"></span>
						<input type="hidden" name="user_id" id="user_id" value="">
					</div>
				</div>				

				<div class="form-row">
                <div class="form-group col-md-12">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.lostitem.request')</label>
		                <table class="table table-striped table-bordered dataTable requestList">
		                    <thead>
		                        <tr>
		                            <th>{{ __('Request Id') }}</th>
		                            <th>{{ __('From') }} </th>
		                            <th>{{ __('To') }} </th>                           
		                            <th>{{ __('Choose') }}</th>
		                        </tr>
		                    </thead>
		                    <tbody class="requestdata">
		                   		<tr><td colspan="4">{{ __('No Results') }}</td></tr>
		                    </tbody>
		                   
		                </table>
					</div>
				</div>

				<div class="form-row">
                <div class="form-group col-md-12">
					<label for="lost_item_name" class="col-xs-2 col-form-label">@lang('admin.lostitem.lost_item')</label>
						<textarea class="form-control" name="lost_item_name" id="lost_item_name" placeholder="@lang('admin.lostitem.lost_item')">{{ old('lost_item') }}</textarea>
					</div>
				</div>
               
                <button type="submit" class="btn btn-accent">{{$action_text}}</button>				
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

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() +"/admin/lostitem"+id;
        setData( url );
     }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            namesearch: { required: true },
            lost_item_name: { required: true },
		},

		messages: {
			namesearch: { required: "Name is required." },
			lost_item_name: { required: "Lost Item Name is required." },
		
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
            var url = getBaseUrl() +"/admin/lostitem"+id;

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
				var html = "";
				
				if(data.data.length > 0) {
					var result = data.data;
					for(var i in result) {
						html+=(`<tr><td>`+result[i].booking_id+`</td><td>`+result[i].s_address+`</td><td>`+result[i].d_address+`</td><td><input name="request_id" value="`+result[i].id+`" type="radio" /></td></tr>`);
					}
				} else {
					html+=(`<tr><td colspan="4">No Results</td></tr>`);
				}
				$('.requestdata').html(html);
			}
			
		});
  
	    $("#from_id").val(ui.item.id);
	    $("#wallet_balance").text(ui.item.bal);
	} 
});
</script>
