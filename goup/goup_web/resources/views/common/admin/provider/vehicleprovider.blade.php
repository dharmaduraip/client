{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            <h6 class="m-0">{{ __('Provider Service Type Allocation') }}</h6>
            <button class="btn btn-block btn-block btn-success approve" style="width: 100px;position: absolute;right: 20px;top: 6px;">@lang('admin.provides.Approve')</button>
        </div>
 
        <div class="col-xs-4">
        <nav>
                <div class="nav nav-tabs nav-fill " id="nav-tab " role="tablist">
                @foreach(Helper::getServiceList() as $k=>$v)
                <a class="nav-item nav-link admin_list {{$v}}" id="nav-daily-tab" data-toggle="tab" data-value={{$v}} data-id="{{$k}}" href="#{{$v}}" role="tab" aria-controls="daily" aria-selected="true">{{$v}}</a>
                @endforeach
               </div>
        </nav>
            <div class="tab-content pricing-nav nav-wrapper" id="nav-tabContent">
            @foreach(Helper::getServiceList() as $k=>$v)
            <div class="tab-pane fade show active" id="{{$v}}" role="tabpanel" aria-labelledby="nav-daily-tab">
                <div class="col-xs-12">
                    <table class="table table-striped table-bordered provider_{{$k}}">
                    </table>

                    </div>
            </div>
            @endforeach 
            </div>
        </div>
        <div class="form_pad">
            <div class="form-row m-0">
            <div class="form-group col-md-6 p-1">
                <label for="zone_id">{{ __('admin.country.zone') }}</label>
                <select name="zone_id" id="zone_id" class="form-control">
                </select>
            </div>
                <div class="form-group col-md-2">
                <label for="zone_id">{{ __('Action') }}</label>
                <button type="button" class="btn btn-accent update float-right">{{ __('Update') }}</button>
                </div>
            </div>
       </div>

        <div class="form_pad">
                
                 @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" id="provider_service_id" name="id" value="{{$id}}">
                @endif
            <br>
            <table id="data-table" class="table table-hover table_width display p-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin.provides.document_type')</th>
                    <th>@lang('admin.status')</th>
                    <th>@lang('admin.action')</th>
                </tr>
                </thead>
            </table>
            <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
        </div>
    </div>
</div>



<script>
var table = $('#data-table');
$(document).ready(function()
{
    basicFunctions();
     var id = "";
     var vechile_details=[];
     var provider_service_id =$('#provider_service_id').val();
   $('.TRANSPORT').click(function(){
       var service_id = $(this).data('id');
       var service_name = $(this).data('value');
       var url=getBaseUrl() + "/admin/transportdocuments/"+provider_service_id;  
       $.ajax({
        type:"GET",
        url: url,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            var html = `<thead>
                            <tr>
                                <th>@lang('admin.provides.type')</th>
                                <th>Ride Type</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                        </thead>`;
            var result = data.responseData;
            for (var i in result) {
                if(result[i].provideradminservice){
                    vechile_details[result[i].provideradminservice.providervehicle.id]= result[i].provideradminservice.providervehicle;  
                    btn=`<button class="btn btn-block btn-block btn-success view_vechile" data-value='TRANSPORT'  data-id =`+result[i].provideradminservice.providervehicle.id+`>View Vehicle</button>
                        <button class="btn btn-block btn-block btn-danger offbutton" data-value='TRANSPORT'  id =`+result[i].provideradminservice.id+`>Delete</button>`;
                    html += `<tbody>
                                <tr>
                                 <td>`+service_name+`</td>
                                 <td>`+result[i].ride_name+`</td>
                                 <td>`+btn+`</td>
                                 </tr>
                                 </tbody>`;
                        $('.provider_'+service_id).html(html);
                    
                }  
            }
        }
    });
});


$('.ORDER').click(function(){
       var service_id = $(this).data('id');
       var service_name = $(this).data('value');
       var url=getBaseUrl() + "/admin/store/orderdocuments/"+provider_service_id;  
       $.ajax({
        type:"GET",
        url: url,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            var html = `<thead>
                            <tr>
                                <th>@lang('admin.provides.type')</th>
                                <th>Store Type</th>
                                <th>@lang('admin.action')</th>
                            </tr>
                        </thead>`;
            var result = data.responseData;
            for (var i in result) {
                if(result[i].provideradminservice){
                    vechile_details[result[i].provideradminservice.providervehicle.id]= result[i].provideradminservice.providervehicle;  
                    btn=`<button class="btn btn-block btn-block btn-success view_vechile" data-value='ORDER'  data-id =`+result[i].provideradminservice.providervehicle.id+`>View Vechile</button>
                        <button class="btn btn-block btn-block btn-danger offbutton" data-value='ORDER'  id =`+result[i].provideradminservice.id+`>Delete</button>`;
                    html += `<tbody>
                                <tr>
                                 <td>`+service_name+`</td>
                                 <td>`+result[i].name+`</td>
                                 <td>`+btn+`</td>
                                 </tr>
                                 </tbody>`;
                        $('.provider_'+service_id).html(html);
                    
                } 
                
            }
        }
    });
});


$('.SERVICE').click(function(){
       var service_id = $(this).data('id');
       var service_name = $(this).data('value');
       var url=getBaseUrl() + "/admin/service/servicedocuments/"+provider_service_id;  
       $.ajax({
        type:"GET",
        url: url,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            var html = `<thead>
                            <tr>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Service</th>
                                <th>BaseFare</th>
                                <th>Action</th>
                            </tr>
                        </thead>`;
            var result = data.responseData;
            for (var i in result) {
                if(result[i].provideradminservice){
                    btn=` <button class="btn btn-block btn-block btn-danger offbutton"  data-value='SERVICE'  id =`+result[i].provideradminservice.id+`>Delete</button>`;
                    html += `<tbody>
                                <tr>
                                 <td>`+result[i].service_category.service_category_name+`</td>
                                 <td>`+result[i].servicesub_category.service_subcategory_name+`</td>
                                 <td>`+result[i].service_name+`</td>
                                 <td>`+result[i].provideradminservice.base_fare+`</td>
                                 <td>`+btn+`</td>
                                 </tr>
                                 </tbody>`;
                        $('.provider_'+service_id).html(html);
                    
                }  
            }
        }
    });
});



$(document).on('click', '.view_vechile', function(){
  var vechile_id=$(this).data('id');
  var model_name=$(this).data('value');
  $('.transport').show();
  if(model_name=="ORDER"){
      $('.transport').hide();
  }else{
    $('.vehicle_year').text(vechile_details[vechile_id].vehicle_year);
    $('.vehicle_model').text(vechile_details[vechile_id].vehicle_model);
    $('.vehicle_color').text(vechile_details[vechile_id].vehicle_color); 
  }
    $('.vehicle_make').text(vechile_details[vechile_id].vehicle_make);
    $('.vehicle_no').text(vechile_details[vechile_id].vehicle_no);
    $('.img').attr('src', vechile_details[vechile_id].picture);
    $('.img1').attr('src', vechile_details[vechile_id].picture1);
    $(".vechiledetails").modal("show");
})

 //Status on
    $(document).on('click', '.onbutton', function(){
        var service_id =$(this).attr('id');
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/service_on/"+service_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                alertMessage("Success", 'Status Activated', "success");
               
                window.location.reload();
            }
        });
    });
    //Approve
    $(document).on('click', '.approve', function(){
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/provider/approve/"+provider_service_id,
            'beforeSend': function (request) {
                showLoader();
            },
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                if(data.responseData.status==1){
                alertMessage("error",data.message, "danger");
                }
                else 
                {
                alertMessage("Success",data.message, "success");
                $(".crud-modal").modal("hide");
                }
                hideLoader();
            }
        });
    });

    //status off
    $(document).on('click', '.offbutton', function(){
        var service_id =$(this).attr('id');
        var tabname=$(this).data('value');
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/deleteservice/"+service_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                $('.'+tabname).trigger('click');
                //alert('Status DeActivated');
                //window.location.reload();
            }
        });
    });

    //Document listing image  in view button
    $(document).on('click', '.view_button', function(e){
        var id =$(this).data('id');
        e.preventDefault();
        $.get("{{ url('admin/provider/') }}/"+$(this).data('id')+"/view_image", function(data) {
            $('.documentdetails .modal-container').html("");
            $('.documentdetails .modal-container').html(data);
        });
        $('.documentdetails').modal('show');
    });
   
    //list the document details
    
    var provider_id =$('#provider_service_id').val();
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": getBaseUrl() + "/admin/providerdocument/"+provider_id,
            "type": "GET",
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            data: {
                "page": 1
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
            { "data": "id"  ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
                }
             },
            { "data": "document_id" ,render: function (data, type, row) {
              return row.document.name;
             }
            },
            { "data": "status" ,render: function (data, type, row) {
              return "<span data-id='"+row.id+"' id='state"+row.id+"'>"+row.status+"</span>";
             }
            },
            { "data": "id", render: function (data, type, row) {
                return "<button data-id='"+data+"' id='"+data+"' class='btn btn-success btn-large view_button'>View</button> <button data-id='"+data+"' class='btn btn-danger btn-large doc-delete delete'>Delete</button>";
            }}

        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
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

    $('.cancel').on('click', function(){
            $(".crud-modal").modal("hide");
    });

    

    var tabs=$( ".admin_list" ).first().text();
    $('.'+tabs).trigger('click');
    
    $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/zonetype/{{$cityid}}?type=PROVIDER",
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#zone_id").empty();
                $("#zone_id").append('<option value="">Select</option>');
                var selected="";
                $.each(data.responseData,function(key,item){
                    if(item.id == {{$zoneid}}){
                        selected='selected';
                    }

                 $("#zone_id").append('<option value="'+item.id+'" '+selected+'>'+item.name+'</option>');
                });

                hideInlineLoader();
            }
        });

     $('.update').click(function(){
     var zone_id =$('#zone_id').val();
     if(zone_id){
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/provider/zoneapprove/"+provider_service_id+"?zone_id="+zone_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                alertMessage("Success",data.message, "success");
                var info = $('#data-table').DataTable().page.info();
                table.order([[ info.page, 'asc' ]] ).draw( false );
            }
        });

     }else{
        alertMessage("error","Please Select Zone", "danger");  
     }


     })   
    
    
});
</script>
