{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            
            <h6 class="m-0" style="margin:10!important;"> {{ __('Wallet Details') }}</h6>
        </div>
        <div class="form_pad">
              <table id="wallet-tables" class="table table-hover table_width display">
                <thead>
                    <tr>
                        <th data-value="id">{{ __('admin.id') }}</th>
                        <th data-value="transaction_alias">{{ __('admin.wallet.trn_alias') }}</th>
                        <th data-value="transaction_desc">{{ __('admin.wallet.trn_des') }}</th>
                        <th data-value="type">{{ __('admin.wallet.type') }}</th>
                        <th data-value="amount">{{ __('admin.wallet.amt') }}</th>
                        <th data-value="created_at">{{ __('admin.wallet.time') }}</th>
                    </tr>
                 </thead>


                </table>

                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
        </div>

    </div>
</div>
@include('common.admin.includes.redirect')
<script>

var tableName1 = '#wallet-tables';

var table = $(tableName1);

$(document).ready(function() {
    var type = "<?= $type ?>";
    var id = "<?= $id ?>";
    var url = getBaseUrl() + "/admin/"+type+"/wallet/"+id;
  
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": url,
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            data: function(data){
              
                var info = $(tableName1).DataTable().page.info();
                delete data.columns;
               data.page = info.page + 1;
                // data.search_text = data.search['value']; 
                data.order_by = $(tableName1+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];
                
            },
            dataFilter: function(response){        
                var json = parseData(response); 
                
                json.recordsTotal = json.responseData.total.toFixed(2);
                json.recordsFiltered = json.responseData.total.toFixed(2);
                json.data = json.responseData.data;
                hideLoader();
                
                return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "transaction_alias" },
            { "data": "transaction_desc" },
            { "data": "type" ,render: function (data, type, row, meta) {
               if(data=="C"){
                return "Credit";
               }else{
                return "Debit";
               }
            } },
            { "data": "amount" , render: function (data, type, row) {
                 
                 return row.provider?row.provider.currency_symbol + row.amount.toFixed(2):row.user.currency_symbol + row.amount.toFixed(2);
                 }
            },
            { "data": "created_time", render: function (data, type, row) { 
               
                    return data;
                }
            }
        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            searching:false,
            dom: 'Bfrtip',
            buttons: [
            ],"drawCallback": function () {
    
                var info = $('#wallet-tables').DataTable().page.info();
                if (info.pages<=1) {
                   $('#wallet-tables .dataTables_paginate').hide();
                   $('#wallet-tables .dataTables_info').hide();
                   $('#wallet-tables_paginate').hide();
                }else{
                    $('#wallet-tables .dataTables_paginate').show();
                    $('#wallet-tables .dataTables_info').show();
                    $('#wallet-tables_paginate').show();
                }
            }
    });
    
});
$('.cancel').on('click', function(){
    $(".crud-modal").modal("hide");
});

</script>