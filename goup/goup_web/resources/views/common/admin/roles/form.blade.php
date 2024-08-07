{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.roles.add'))
            @else
                @php($action_text=__('admin.roles.edit'))
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}}</h6>
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
                        <label for="name">{{ __('admin.roles.role_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('admin.roles.role_name') }}" value="" autocomplete="off" style="text-transform:uppercase">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
					   <label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.roles.role_permissions')</label>
					
                       <div id="show_permissions" style="overflow: auto;height: 500px;padding: 10px;">

                    </div>
					</div>
				</div>
                <br>
                <button type="submit" class="btn btn-accent">{{$action_text}}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('admin.cancel') }}</button>

            </form>
        </div>
    </div>
</div>


@include('common.admin.includes.redirect')
<script>
var id = "";
$(document).ready(function()
{

     basicFunctions();

     if($("input[name=id]").length){
        
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/roles"+id;
        //setData( url );


        $.ajax({
            url: url,
            type: "get",
            headers: {
                Authorization: "Bearer " + getToken('admin')
            },
            success: function(data, textStatus, jqXHR) {
                var conthtml='';
                var temp_group_name='';
                $("#name").val(data.responseData.name);
                var user_arr = $.map(data.responseData.UserPermissions, function(value, index) {
                    return [value];
                });

                var conthtml='';

                var group_data = data.responseData.permissions.reduce(function (obj, item) {
                    obj[item.group_name] = obj[item.group_name] || [];
                    obj[item.group_name].push(item);
                    return obj;
                }, {});              
               

                $.each(group_data, function(i, dataval){

                    var str_name=i.replace(/\s/g, '');

                    conthtml+='<fieldset class="scheduler-border"><legend class="scheduler-border"><h6 class="m-0"><span ><input class="checkper" type="checkbox" id="chk_'+str_name+'"></span>'+i+'</h6></legend>';
                    var chek=0;
                    $.each(dataval, function(k, data){
                        
                        if($.inArray(data.id, user_arr) !== -1){

                            var checked='checked';
                        }
                        else{
                            var chek=chek+1;
                            var checked='';
                        }

                        conthtml+='<span class="clkbox" data-id="nk_'+str_name+'"=""><label style="margin-right: 20px; margin-bottom: 20px;"><input type="checkbox" value="'+data.id+'" name="permission[]" id="permission" class="permission_'+str_name+'" '+checked+'>'+data.display_name+'</label></span>';
                    });
                    if(chek==0){
                        $('#chk_'+str_name).attr('checked');
                    }
                    conthtml+='</fieldset>'; 

                });

                $("#show_permissions").append(conthtml);

                //setToken(guard, response.responseData.access_token);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                window.location.replace("/admin/login");
            }
        });


     }
     else{
        
        $.ajax({
            url: getBaseUrl() + "/admin/permission",
            type: "get",
            headers: {
                Authorization: "Bearer " + getToken('admin')
            },
            success: function(data, textStatus, jqXHR) {

                var conthtml='';

                var group_data = data.responseData.reduce(function (obj, item) {
                    obj[item.group_name] = obj[item.group_name] || [];
                    obj[item.group_name].push(item);
                    return obj;
                }, {});              

                $.each(group_data, function(i, dataval){

                    var str_name=i.replace(/\s/g, '');

                    conthtml+='<fieldset class="scheduler-border"><legend class="scheduler-border"><h6 class="m-0"><span ><input class="checkper" type="checkbox" id="chk_'+str_name+'"></span>'+i+'</h6></legend>';

                    $.each(dataval, function(k, data){
                        conthtml+='<span class="clkbox" data-id="nk_'+str_name+'"=""><label style="margin-right: 20px; margin-bottom: 20px;"><input type="checkbox" value="'+data.id+'" name="permission[]" id="permission" class="permission_'+str_name+'">'+data.display_name+'</label></span>';
                    });

                conthtml+='</fieldset>'; 

                });

                $("#show_permissions").append(conthtml);
                
                //setToken(guard, response.responseData.access_token);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                window.location.replace("/admin/login");
            }
        });
     }

     $('.validateForm').validate({
		errorElement: 'div', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true },
            'permission[]': { required: true },
		},

		messages: {
			name: { required: "{{ __('admin.roles.role_name') }} is required." },
			'permission[]': { required: "{{ __('admin.roles.role_permissions') }} is required." },

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
            var url = getBaseUrl() + "/admin/roles"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});

$(document).on('click','.checkper', function(){
    var tchk=$(this).attr('id').split('_');
    if ($(this).is(':checked')) {
        $(".permission_"+tchk[1]).prop('checked',true);
    }
    else{
        $(".permission_"+tchk[1]).prop('checked',false);
    }

});

$(document).on('click','.clkbox', function(){
    var tchk=$(this).attr('data-id').split('_');
    if($('.permission_'+tchk[1]+':checked').length == $('.permission_'+tchk[1]).length){
        $("#chk_"+tchk[1]).prop('checked',true);
    }else{
        $("#chk_"+tchk[1]).prop('checked',false);
    }

});


if($("input[name=id]").length>0)
    setTimeout(function(){ $(".clkbox").trigger("click"); }, 200);

</script>
