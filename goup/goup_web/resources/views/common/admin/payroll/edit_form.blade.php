{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0" style="margin:10!important;"> {{$action_text}} {{ __('Payroll') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm" files="true">
                @csrf()
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif

                
                 
                <div class="row">
                <table id="data-table-provider" class="table table-hover table_width display">
                <thead>
                    <tr>
                        <th><input type="checkbox" checked name="select_all" value="1" id="example-select-all"></th>
                       <!--  <th data-value="transaction_id">{{ __('admin.transaction_id') }}</th> -->
                        <th data-value="first_name">{{ __('admin.first_name') }}</th>
                        <th data-value="last_name">{{ __('admin.last_name') }}</th>
                        <th data-value="wallet_balance">{{ __('admin.users.Wallet_Amount') }}</th>
                        <!-- <th data-value="status">Status</th> -->
                        <th>{{ __('admin.action') }}</th>
                    </tr>
                 </thead>


                </table>
                </div>

                

                
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Payroll') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>
var poptableName = '#data-table-provider';
var poptable = $(poptableName);


$(document).ready(function()
{
    

    @if(!empty($id))

    var id = '{{$id}}';
    @else

    var id = '';
    @endif
    var provider_list = [];
    var  template_id = 0;
      poptable = poptable.DataTable( {
        /*"processing": true,
        "serverSide": true,
        "pageLength": 10,*/
            "data":provider_list,
                "columns": [
                    { "data": "id" ,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    render: function (data, type, row, meta) {
                       //return meta.row + meta.settings._iDisplayStart + 1;
                       return '<input type="checkbox" name="pid[]" checked value="' + $('<div/>').text(data).html() + '"><input type="hidden" name="proid['+row.id+']" checked value="' + row.provider_id + '">';
                      }
                    },
                    { "data": "first_name" ,render:function(data, type, row, meta){
                        return row.provider.first_name;
                    } },
                    { "data": "last_name" ,render:function(data, type, row, meta){
                        return row.provider.last_name;
                    } },
                    /*{ "data": "provider_id" },*/
                    { "data": "wallet",render:function(data, type, row, meta){
                        //console.log(row.id);
                        return '<input class="form-control" id="wallet" name="wallet['+row.id+']" type="number" max="'+data+'"  min="1"  value = ' + data + '  ><input class="form-control" id="template_id" name="template_id" type="hidden"  value = ' + row.template_id + '  ><input class="form-control" id="zones" name="zones['+row.id+']" type="hidden"  value = ' + row.zone_id + '  >';
                    }},
                    { "data": function (data, type, row) {
                       
                        var button ='';
                        if({{Helper::getDemomode()}} != 1){
                         var button='<a href="javascript:;" data-id="'+data.id+'" class="dropdown-item popdelete"><i class="fa fa-trash"></i> Delete</a> ';
                        }
                         return  button;  

                    }}

                ],
                responsive: true,
                paging:false,
                    info:false,
                    lengthChange:false,
                    dom: '',
                    buttons: [
                        /*'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'*/
                    ],"drawCallback": function () {
    
                        var info = $(this).DataTable().page.info();
                        if (info.pages<=1) {
                           $('.dataTables_paginate').hide();
                           $('.dataTables_info').hide();
                        }else{
                            $('.dataTables_paginate').show();
                            $('.dataTables_info').show();
                        }
                    }
            });
    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/payroll/"+id+'?id='+id,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        'beforeSend': function (request) {
            showInlineLoader();
        },
        success:function(response){  
            //var provider_list = response.responseData;
            poptable.clear();
            poptable.rows.add(response.responseData).draw(); 
            hideInlineLoader();
        }
    });
      

    $('#example-select-all').on('click', function(){ 
       // Get all rows with search applied
       var rows = poptable.rows({ 'search': 'applied' }).nodes();
       // Check/uncheck checkboxes for all rows in the table
       $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    $('body').on('click', '.popdelete', function() {
      
        poptable
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });
    
    
   /* if($("input[name=id]").length){

        id = "/" +$("input[name=id]").val();
        var url = getBaseUrl() + "/admin/payroll"+id;
        setData( url );
    }*/

        
    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            provider: { required: true },
            wallet: { required: true }
		},

		messages: {
			provider_id: { required: "First name is required." },
			wallet: { required: "wallet is required." }
		},

		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
            
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
            $('.selected-flag').css('height','100%');
		},

		submitHandler: function(form) {

            var formGroup = $(".validateForm").serialize().split("&");
            //console.log(formGroup);
            var data = new FormData();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                ///console.log(decodeURIComponent(params[0]));
                data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }
            //console.log(data);
            var url = getBaseUrl() + "/admin/payroll/"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>