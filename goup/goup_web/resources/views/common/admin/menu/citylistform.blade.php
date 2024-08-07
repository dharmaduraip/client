{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="modal-header">
    <h4 class="modal-title">{{ __('Menu City') }} {{ __('List') }}</h4>
    <button type="button"  data-dismiss="modal" class="close">&times;</button>
</div>
<div class="row full-section-ser" style="border-top: none;">
    <div class="col-md-4 box-card border-rightme">
    <div class="form_pad myprice">
    </div>
    </div>
    <div class="col-md-8 box-card price_lists_sty priceBody">
        <div class="form_pad">
            @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" id = "city_id" name="id" value="{{$id}}">
            @endif
            <form class="validateForm">
            <input type="hidden" id="country_id" name="country_id" value="">   
            <input type="hidden" id="service_id" name="service_id" value="">   
                <table id="data-tables" class="table table-hover table_width display">
                    <thead>
                        <tr>
                            <th></th>
                            <th width="10px;">{{ __('admin.id') }}</th>
                            <th>{{ __('admin.menu.city') }}</th>
                            <!-- <th><input type="checkbox" id="checkAll" />{{ __('admin.action') }}</th> -->
                        </tr>
                    </thead>
                    <tbody id="menucityList">
                        
                    </tbody> 
                </table>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                @if(Helper::getDemomode() != 1)
                <button type="submit" class="btn btn-accent float-right menucity">{{ __('Add') }}</button>
                @endif
            </form>
        </div>
    </div>
</div>
<style>
.priceBody .dataTables_wrapper .dataTables_filter {
    display:none;
}
</style>
@include('common.admin.includes.redirect')
<script type="text/javascript">
var tableNameCity = '#data-tables';
var table_city = $(tableNameCity);
$(document).ready(function()
{
     basicFunctions();
     var id = "";
    /*
     if($("input[name=id]").length){
        id = $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/menucity/"+id;
        setData( url );
     }*/
    
    $('.validateForm').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData();
        var formGroup = $(this).serialize().split("&");
        for(var i in formGroup) {
            var params = formGroup[i].split("=");
            data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
        }
        data.append( '_method', 'PATCH' );
        var url = getBaseUrl() + "/admin/menucity/"+id;
        if($('[name="city_id[]"]:checked').length>0){
        saveRow( url, null, data);   
        }else{
             alertMessage('Error',"You have to check atleast one City.", "danger");
        }     
    });
    var id =$('#city_id').val();
    if("{{$service}}"=="TRANSPORT"){
     var url= getBaseUrl() + "/admin/gettransportcity?menu_id="+id;
    }else if("{{$service}}"=="SERVICE"){
    var url= getBaseUrl() + "/admin/getservicecity?menu_id="+id; 
    }else{
    var url= getBaseUrl() + "/admin/getordercity?menu_id="+id;
    }
  
    tables = table_city.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
            "url": url,
            "type": "GET",
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
                beforeSend: function() {
                    showLoader();
                },
                data: function(data){
                   
                var info = $(tableNameCity).DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value'];
               /* data.order_by = $(tableNameCity+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];*/
            },
            dataFilter: function(data){
                
                var json = parseData( data );

                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
                json.data = json.responseData.data;
                return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
            { "data": "id"},
            { "data": "id",render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              },
            },
            { "data": "city_id" ,render: function (data, type, row, meta) {
                //if(row.city_transport_price!='' || row.city_service_price!='' || row.city_store_price!='')
                if(row.city_price == 1){
                    return row.city.city_name;
                        }else{
                    return row.city.city_name+" - <span style='color:red'>  (Pricing Logic Is Required)</span>";
                        }
                }
            }
        ],
        "columnDefs": [
            {
                "targets": 0,
                "checkboxes": { 'selectRow': true, 'selectAllRender': function() {
                    return '<input type="checkbox" class="dt-checked-main">';
                }},
                'render': function (data, type, row, meta){
                    var selected = '';
                    //console.log(row);
                    if(row.menu_city) {
                        selected = 'checked';
                    }

                    if(row.city_price == 1){
                        return '<input type="checkbox" name="city_id[]" class="dt-checkboxes dt-checked-main" ' + selected + ' value="'+row.city.id+'">';
                        }

                   
                }
            }
        ],
        'select': {
            'style': 'multi'
        },
        'order': [[1, 'asc']],
        responsive: true,
        paging:false,
        "scrollY": "350px",
        "scrollX": "450px",
        "scrollCollapse": true,
        searching:true,
            info:false,
            lengthChange:false,
            dom: 'Bfrtip',
            buttons: [
                
            ],"drawCallback": function () {
    
                var info = $(this).DataTable().page.info();
                if (info.pages<=1) {
                   $('#data-tables .dataTables_paginate').hide();
                   $('#data-tables .dataTables_info').hide();
                }else{
                    $('#data-tables .dataTables_paginate').show();
                    $('#data-tables .dataTables_info').show();
                }
                hideLoader();
            }
    } );
    $(document).on('click', '.cancel', function(){
        $(".crud-modal").modal("hide");
    });

    menuSelectCities(id);
   
});

</script>