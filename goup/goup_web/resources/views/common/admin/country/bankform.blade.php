{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            
            <h6 class="m-0"style="margin:10!important;">{{ __('Country Bank Form') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <!-- <input type="hidden" name="_method" value="PATCH"> -->
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="index" value="">
                @endif
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="label">{{ __('admin.country.type') }}</label>
                            <select name="type" class="form-control type" >
                            <option value="">select</option>
                                <option value="VARCHAR">Name</option>
                                <option value="INT">Number</option>
                            </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="label">{{ __('admin.country.label') }}</label>
                        <input type="text" class="form-control label" id="label" name="label" placeholder="{{ __('admin.country.label') }}" value="" autocomplete="off">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="min">{{ __('admin.country.min') }}</label>
                        <input type="number" class="form-control min" id="min" name="min" placeholder="{{ __('admin.country.min') }}" value="" autocomplete="off" min="0">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="max">{{ __('admin.country.max') }}</label>
                        <input type="number" class="form-control max" id="max" name="max" placeholder="{{ __('admin.country.max') }}" value="" autocomplete="off">
                    </div>

                    <div class="form-group col-md-2">
                        
                        <button type="reset" class="btn btn-success addbankform" style="margin-top: 30px;">Add</button>

                        <button type="reset" class="btn btn-info update" style="margin-top: 30px;display: none;" >Update</button>
                    </div>

                </div>

                <table id="bankform-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>@lang('admin.country.type')</th>
                            <th>@lang('admin.country.label')</th>
                            <th>@lang('admin.country.min')</th>
                            <th>@lang('admin.country.max')</th>
                            <th>{{ __('admin.action') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>

                </table>

                <br>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-accent float-right">{{ __('Store') }}</button>

            </form>
        </div>
    </div>
</div>


@include('common.admin.includes.redirect')
<script>

$(document).ready(function()
{

    var id = $("input[name=id]").val();

    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/companycountries/"+ id +"/bankform",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            // console.log(data.responseData[0].id);
            var length = data.responseData.length;

            for (var index = 0; index < length; index++) {

                var markup = "<tr><td class='type type"+index+"'>" + data.responseData[index].type + "</td><td class='label label"+index+"'>" + data.responseData[index].label + "</td><td class='min min"+index+"'>" + data.responseData[index].min + "</td><td class='max max"+index+"'>" + data.responseData[index].max + "</td><td><button type='button' class='btn btn-success edit_row'>Edit</button> &nbsp;<button typedata.responseData[index].='button' class='btn btn-danger delete_row'>Delete</button></td><input type='hidden' name='types[]' class='htype"+index+"' value='"+ data.responseData[index].type +"'><input type='hidden' class='hlabel"+index+"' name='labels[]' value='"+ data.responseData[index].label +"'><input type='hidden' name='mins[]' class='hmin"+index+"' value='"+ data.responseData[index].min +"'><input type='hidden' name='maxs[]' class='hmax"+index+"' value='"+ data.responseData[index].max +"'></tr>";

                $('#bankform-table').append(markup);
                
            }

        }
    });
    
    $('.addbankform').on('click', function(){
        
        var type = $("select[name=type]").val();
        var label = $("input[name=label]").val();
        var min = $("input[name=min]").val();
        var max = $("input[name=max]").val();
        var index = $('#bankform-table tbody tr').length;
   
        if(type != "" && label != "" && min != "" && max != ""){
            
            var markup = "<tr><td class='type type"+index+"'>" + type + "</td><td class='label label"+index+"'>" + label + "</td><td class='min min"+index+"'>" + min + "</td><td class='max max"+index+"'>" + max + "</td><td><button type='button' class='btn btn-success edit_row'>Edit</button> &nbsp;<button type='button' class='btn btn-danger delete_row'>Delete</button></td><input type='hidden' name='types[]' class='htype"+index+"' value='"+ type +"'><input type='hidden' class='hlabel"+index+"' name='labels[]' value='"+ label +"'><input type='hidden' name='mins[]' class='hmin"+index+"' value='"+ min +"'><input type='hidden' name='maxs[]' class='hmax"+index+"' value='"+ max +"'></tr>";
            $('#bankform-table').append(markup);
       
        }else{
            alert("please select all values");
        }
    });

    $('body').on('click', '.edit_row', function(){
      var index = $(this).closest('tr').index();
        $('.addbankform').hide();
        $('.update').show();
       

        var type= $(this).closest('tr').find('.type').text();
        var label= $(this).closest('tr').find('.label').text();
        var min= $(this).closest('tr').find('.min').text();
        var max= $(this).closest('tr').find('.max').text();

        $("select[name=type]").val(type);
        $("input[name=label]").val(label);
        $("input[name=min]").val(min);
        $("input[name=max]").val(max);
        $("input[name=index]").val(index);
        
    });

    $('.update').on('click', function(){

        var index = $("input[name=index]").val();
        var type = $("select[name=type]").val();
        var label = $("input[name=label]").val();
        var min = $("input[name=min]").val();
        var max = $("input[name=max]").val();
        
        if(type != "" && label != "" && min != "" && max != ""){
            $('.type'+index).text(type);
            $('.label'+index).text(label);
            $('.min'+index).text(min);
            $('.max'+index).text(max);

            $('.htype'+index).val(type);
            $('.hlabel'+index).val(label);
            $('.hmin'+index).val(min);
            $('.hmax'+index).val(max);

            $('.update').hide();
            $('.addbankform').show();
            
       
        }else{
            alert("please select all values");
        }
    });


    $('body').on('click', '.delete_row', function(){
            
        $(this).parents("tr").remove();
        
    });

    $('.validateForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        
        highlight: function(element)
        {
            $(element).closest('.form-group').addClass('has-error');
        },
        success: function(label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },

        submitHandler: function(form) {

            var formdata = new FormData();
            var other_data = $('form').serializeArray();
            $.each(other_data,function(key,input){
                formdata.append(input.name,input.value);
            });

            var url = getBaseUrl() + "/admin/bankform";
            $.ajax({
                url: url,
                type: "post",
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                },
                beforeSend: function (request) {
                    showInlineLoader();
                },
                success: function(response, textStatus, jqXHR) {

                    console.log(response);

                    $(".crud-modal").modal("hide");
                    alertMessage("Success", response.message, "success");
                    hideInlineLoader();
                   
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 401 && getToken(guard) != null) {
                        refreshToken(guard);
                    } else if (jqXHR.status == 401) {
                        window.location.replace("/admin/login");
                    }

                    if (jqXHR.responseJSON) {
                        alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                    }
                    hideInlineLoader();
                }
            });
        }
    });


    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  
});
</script>
