{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="modal-header">
    <h4 class="modal-title">{{ __('City') }} {{ __('List') }}</h4>
    <button type="button"  data-dismiss="modal">&times;</button>
</div>
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            <h6 class="m-0"style="margin:10!important;"> {{ __('City') }} {{ __('List') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" id = "city_id" name="id" value="{{$id}}">
                @endif
                <table id="data-table" class="table table-hover table_width display">
                    <thead>
                        <tr>
                            <th width="10px;">{{ __('admin.id') }}</th>
                            <th>{{ __('admin.menu.city') }}</th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                </table>
                <br>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
                @if(Helper::getDemomode() != 1)
                <button type="submit" class="btn btn-accent float-right menucity">{{ __('Add') }}</button>
                @endif
            </form>
        </div>
    </div>
</div>

@include('common.admin.includes.redirect')
<script>
var table = $('#data-table');
$(document).ready(function()
{
     basicFunctions();
     $('.modal-dialog').removeClass('modal-lg');
     var id = "";
/*
     if($("input[name=id]").length){
        id = $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/menucity/"+id;
        setData( url );
     }*/
    
    $('.menucity').on('click', function(e) {
        e.preventDefault();
        var cities = $('body').find(".validateForm input[name=city_id]:checked").map(function(){return $(this).val();}).get();
        var data = new FormData();
        data.append( '_method', 'PATCH' );
        data.append( 'city_id', cities );
        var url = getBaseUrl() + "/admin/menucity/"+id;
        saveRow( url, null, data);
    });
    var id =$('#city_id').val();
    var result = [];
    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/getmenucity/"+id,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            result = data;
        }
    });
    table = table.DataTable( { 
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": getBaseUrl() + "/admin/getcity",
            "type": "GET",
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
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
           { "data": "id",render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              },
            },
            { "data": "city_id" ,render: function (data, type, row) {
                return row.city.city_name;
                }
            },
            { "data": "id", render: function (data, type, row) {
                var selected = '';
                if(result.includes(row.city.id)) {
                    selected = 'checked';
                }
                return `<a data-id='  `+data+`'> <input type="checkbox" id="`+ data  +`"` + selected + ` value="`+row.city.id+`" name="city_id"> </a>`;
                }
            }
        ],
        responsive: true,
        paging:false,
        searching:false,
            info:false,
            lengthChange:false,
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
    } );
    $(document).on('click', '.cancel', function(){
        $(".crud-modal").modal("hide");
    });

   
});
</script>
