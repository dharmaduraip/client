{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            
            <h6 class="m-0" style="margin:10!important;"> {{ __('Shop') }} {{ __('Wallet Details') }}</h6>
        </div>
        <div class="form_pad">
              <table id="data-tables" class="table table-hover table_width display">
                <thead>
                    <tr>
                        <th data-value="id">{{ __('store.admin.id') }}</th>
                        <th data-value="transaction_alias">{{ __('store.admin.wallet.trn_alias') }}</th>
                        <th data-value="transaction_desc">{{ __('store.admin.wallet.trn_des') }}</th>
                        <th data-value="type">{{ __('store.admin.wallet.type') }}</th>
                        <th data-value="amount">{{ __('store.admin.wallet.amt') }}</th>
                        <th data-value="created_at">{{ __('store.admin.wallet.time') }}</th>
                    </tr>
                 </thead>


                </table>

                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
        </div>

    </div>
</div>
<script>

var tableName = '#data-tables';

var table = $(tableName);

$(document).ready(function() {
    
    var url = getBaseUrl() + "/admin/store/wallet/"+{{$id}}; 
  
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
              
                var info = $(tableName).DataTable().page.info();
                delete data.columns;
               data.page = info.page + 1;
                // data.search_text = data.search['value']; 
                data.order_by = $(tableName+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];
                
            },
            dataFilter: function(response){        
                var json = parseData(response); 
                
                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
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
            { "data": "type" },
            { "data": "amount" },
            { "data": "created_at", render: function (data, type, row) {
                let date = moment(data, "YYYY-MM-DD");
                return date.fromNow();
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
    
});
$('.cancel').on('click', function(){
    $(".crud-modal").modal("hide");
});

</script>