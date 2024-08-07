{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0" style="margin:10!important;"> {{$action_text}} {{ __('Manual') }} {{ __('Payroll') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm" files="true">
                @csrf()
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
                 <input type="hidden" name="type" value="MANUAL">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="country_id">{{ __('admin.country_name') }}</label>
                        <select name="country_id" id="country_id" class="form-control">
                        <option value="">Select Country</option>
                        @foreach(Helper::getCountryList() as $key => $country)
                            <option value={{$key}}>{{$country}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city_id">{{ __('admin.city_name') }}</label>
                        <select name="city_id" id="city_id" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city_id">{{ __('admin.zone_name') }}</label>
                        <select name="zone_id" id="zone_id" class="form-control">
                        </select>
                    </div>
                </div>
               
                 <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city_id" class="label_name">{{ __('admin.provider') }}</label>
                        <input type="text" name="provider_id" id="autocomplete" class="form-control"  />
                    </div>
                </div>
                <div class="row">
                <table id="data-table-provider" class="table table-hover table_width display">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                        <th data-value="first_name">{{ __('admin.name') }}</th>
                        <th data-value="wallet_balance">{{ __('admin.users.Wallet_Amount') }}</th>
                        <!--<th data-value="status">Status</th>-->
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
<link href="{{asset('assets/plugins/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.js')}}"></script>

<script>
var zone_id = 0;
var provider_list = [];
$( function() {

});
var poptableName = '#data-table-provider';
var poptable = $(poptableName);


$(document).ready(function()
{
    

    @if(!empty($id))

    var id = '{{$id}}';
    @else

    var id = '';
    @endif
    var  template_id = 0;
      poptable = poptable.DataTable( {
        /*"processing": false,
        "serverSide": false,
        "pageLength": 10,*/
        "data":provider_list,
                "columns": [
                    { "data": "id" ,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                    render: function (data, type, row, meta) {
                       //return meta.row + meta.settings._iDisplayStart + 1;
                       return '<input type="checkbox" checked name="pid[]" value="' + $('<div/>').text(data).html() + '">';
                      }
                    },
                    { "data": "name" },
                    { "data": "wallet_balance",render:function(data, type, row, meta){
                        //console.log(row.id);
                        return '<input class="form-control" id="wallet" name="wallet['+row.id+']" type="number" max="'+data+'" min="1" value = ' + data + '  ><span id="wallet['+row.id+']-error"></span>';
                    }},
                    /*{ "data": "status" }*/
                    { "data": function (data, type, row) {
                       
                        var button ='';
                        if({{Helper::getDemomode()}} != 1){
                         var button='<a href="javascript:;" data-id="'+data.id+'" class="dropdown-item popdelete"><i class="fa fa-trash"></i> Delete</a> ';
                        }
                         return  button;  

                    }}

                ],
                responsive: false,
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

      $('#zone_id').on('change', function(){
          var user_type=$(this).find(':selected').data('value');
          $(".label_name").text(user_type+ " NAME"); 
        
        if( $(this).val() != "") {
            $( "#autocomplete" ).autocomplete({
                source: getBaseUrl() + "/admin/searchprovider/"+$("#zone_id option:selected").data('value').toLowerCase()+"/"+$("#zone_id").val(),
                minLength: 2,
                select: function( event, ui ) {
                    addrow(ui);
                }
            });
        }
        
    });
    function addrow(provider){
        poptable.clear();
        provider_list = [];
        provider_list.push(provider.item);
        poptable.row.add(provider.item).draw();              
    }
    $('body').on('click', '.popdelete', function() {
      
        poptable
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });
    $('#country_id').on('change', function(){ 
        
        var country_id =$("#country_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/countrycities/"+country_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#city_id").empty();
                $("#city_id").append('<option>Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                });
                $("#zone_id").empty();
                hideInlineLoader();
            }
        });
    });
    $('#city_id').on('change', function(){ 
        
        var city_id =$("#city_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/cityzones/"+city_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#zone_id").empty();
                $("#zone_id").append('<option>Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#zone_id").append('<option data-value="'+item.user_type+'"  value="'+item.id+'">'+item.name+' ('+item.user_type+')'+'</option>');
                });

                hideInlineLoader();
            }
        });
    });
    

    $('#example-select-all').on('click', function(){ 
       // Get all rows with search applied
       var rows = poptable.rows({ 'search': 'applied' }).nodes();
       // Check/uncheck checkboxes for all rows in the table
       $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

     

    
    
    /*if($("input[name=id]").length){

        id = "/" +$("input[name=id]").val();
        var url = getBaseUrl() + "/admin/users"+id;
        setData( url );
    }*/

        
    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            'pid[]': { required: true ,minlength: 1 },
            'wallet[]': { required: true,minlength: 1 }
		},

		messages: {
			'pid[]': { required: "checked atleast anyone checkbox" },
            'wallet[]': { required: "wallet is required." }
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
        errorPlacement: function(error, element) {
            $.each(error ,function(index,item){
                if(element[index].id=='wallet'){
                error.insertAfter($("input[name='"+element[index].name+"']")); 
                }else{
                   error.insertAfter($("#example-select-all"));
                }
            })
            
            //if ($("#checkboxes").has(element).size() > 0) {
                
            //} else {
                //error.insertAfter(element);
            //}
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
            var url = getBaseUrl() + "/admin/payroll"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>