{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<link rel="stylesheet" href="{{ asset('assets/layout/css/service-master.css')}}">
<div class="card-header border-bottom">
            
            <h6 class="m-0"style="margin:10!important;">{{ __('Approval') }}</h6>
</div>
<div class="row p-5">
    
    <div class="col-md-4 box-card border-rightme myprice">

    </div>
    <div class="col-md-8 box-card price_lists_sty priceBody">
       
            <div class="col-xs-12">
                <nav class="services">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active serviceslist" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Provider Vehicles') }}</a>
                    </div>
                </nav>
                <div class="services pricing-nav nav-wrapper" id="nav-tabContent">
                    <div  class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                       <table class="table table-bordered table-striped  provider_vehicle">
                        </table>
                    </div>
                    </div>
                
                <nav class="nav_document">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Provider Document') }}</a>
                    </div>
                </nav>
                <div class="nav_document pricing-nav nav-wrapper" id="nav-tabContent">
                    <div  class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                        <table class="table table-bordered table-striped  provider_document">
                        </table>
                    </div>
                </div>
                <nav class="Profile">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Profile Picture') }}</a>
                </div>
                </nav>
                <div class="Profile pricing-nav nav-wrapper" id="nav-tabContent">
                    <div  class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                    <div class="form_pad">
                        <div class="form-row m-0">
                        <div class=" col-md-12 p-1  noimage" >
                             
                            <img src = "" class ="img2" height ="200px;" width ="200px;" autocomplete="off" />
                            
                        </div>
                         </div><br>
                           <div id="approve_btns"></div>
                            <div id="delete_profile"></div> 
                            <button type="button" class="btn btn-danger cancel zcnl float-right">{{ __('Cancel') }}</button>
                       
                    </div>
                    </div>
                </div>
                <!-- Address -->
                <nav class="Address">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Address') }}</a>
                    </div>
                </nav>
                <div class="Address pricing-nav nav-wrapper" id="nav-tabContent">
                    <div  class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                  
                       <table class="table table-bordered table-striped  provider_address">
                        </table>
                        <div id="proof_name"></div>
                         <img src = "" class ="img3" height ="200px;" width ="200px;" autocomplete="off" /><br>
                           <div id="approve_btns1"></div>
                            <div id="delete_btns1"></div> 
                            <button type="button" class="btn btn-danger cancel zcnl float-right">{{ __('Cancel') }}</button>
                       
                  
                    </div>
                </div>
                <nav class="zone">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Zone') }}</a>
                    </div>
                </nav>
                <div class="zone pricing-nav nav-wrapper" id="nav-tabContent">
                    <div  class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                    <div class="form_pad">
                        <div class="form-row m-0">
                        <div class="form-group col-md-6 p-1">
                            <label for="zone_id">{{ __('admin.country.zone') }}</label>
                            <select name="zone_id" id="zone_id" class="form-control">
                            </select>
                            <br>
                            
                            <button type="button" class="btn btn-accent update ">{{ __('Update') }}</button>
                            <button type="button" class="btn btn-danger cancel zcnl float-right">{{ __('Cancel') }}</button>
                        </div>
                           
                        </div>
                    </div>
                    </div>
                </div>
                
            </div>
           
            <button type="button" class="btn btn-success  approve_all">{{ __('Approve All') }}</button>
            <button type="button" class="btn btn-danger cancel rld">{{ __('Cancel') }}</button>
            
            </div>
            
        
   
</div>
@include('common.admin.includes.redirect')
<script>
    basicFunctions();
    var id={{$id}};
    var providerservice={};
    var totaldocuments={};
    var services={};
    var vechile_details=[]; 
    
    $('.services,.nav_document,.approve_all,.Profile,.Address').hide();
    $('.services,.nav_document,.rld').hide();



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
                    url: getBaseUrl() + "/admin/provider/zoneapprove/"+id+"?zone_id="+zone_id,
                    headers: {
                        Authorization: "Bearer " + getToken("admin")
                    },
                    success:function(data){
                        alertMessage("Success",data.message, "success");
                    }
                });
            }else{
                alertMessage("error","Please Select Zone", "danger");  
            }
  })
    $('body').on('click', '.address_profile_approve', function(){
        
        var type =$(this).data('value');
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/provider/address_profile/"+id+"?type="+type,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                var state = document.querySelector('#state'+id);
                $(state).text('ACTIVE');
                alertMessage("Success", 'Approved Successfully', "success");
                providerservice={};
                totaldocuments={};
                services={};
                total_deatils();

             }
        });
    });

    $('body').on('click', '.address_profile_delete', function() {
        var type=$(this).data('value');
      
        confirm("Are you Sure Want To Delete!");
        $.ajax({
            type:"DELETE",
            url:getBaseUrl() + "/admin/provider/delete_address_pfofile/"+id+"?type="+type,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                alertMessage("Success", 'Deleted Successfully', "success");
                providerservice={};
                totaldocuments={};
                services={};
                total_deatils();
            }
        });
    });
       
total_deatils();
function total_deatils(){
  $.ajax({
        url: getBaseUrl() + "/admin/provider_total_deatils/"+id,
        type: "GET",
        async : false,
        'beforeSend': function (request) {
                showLoader();
        },
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success: function(datas) {
            
         var providerdetails=datas.responseData[0];
         $("#approve_btns").empty();
         $("#delete_profile").empty();
         if(providerdetails.picture_draft)
         {
            $('.img2').attr('src', providerdetails.picture_draft);
            
            if(providerdetails.picture_draft){
                $("#approve_btns").html(`<button  data-value="Profile" class="btn btn-success btn-large address_profile_approve pull-left"  style = "margin-right:20px;">Approve</button>`);
                $("#delete_profile").html(`<button  data-value="Profile" class='btn btn-danger btn-large doc-delete pull-left address_profile_delete' style = "margin-right:20px;">Remove</button>`);
            }  
         }
         else
         {  
            $(".noimage").html(` No Draft Profile Picture Uploaded`);
         }
     
        var html1 = `<thead>
            <tr>
               <th>flat no</th>
               <th>street</th>
               <th>Address</th>
            </tr>
        </thead>`;
        $("#approve_btns1").empty();
        $("#delete_btns1").empty();
        $("#proof_name").empty();
        if(providerdetails.provider_address !=null){
            html1 += `<tbody>
                        <tr>
                            <td>`+providerdetails.provider_address.flat_no+`</td>
                            <td>`+providerdetails.provider_address.street+`</td>
                            <td>`+providerdetails.provider_address.map_address+`</td>
                         </tr>
                        </tbody>`;
                $('#proof_name').html('Proof Name :'+providerdetails.provider_address.proof_name);
                $('.img3').attr('src', providerdetails.provider_address.address_proof);
                if(providerdetails.provider_address.status =='ASSESSING'){
                    $("#approve_btns1").html(`<button data-value="Address"  class="btn btn-success btn-large  address_profile_approve pull-left"  style = "margin-right:20px;">Approve</button>`);
                    $("#delete_btns1").html(`<button  data-value="Address" class='btn btn-danger btn-large doc-delete pull-left address_profile_delete' style = "margin-right:20px;">Remove</button>`);
                }
          
        } else {   
        $('.img3').hide();  
            html1 += `<tbody>
                        <tr>
                        <td colspan='4'>No Address Uploaded</td>
                        </tr>
                    </tbody>`;
        }
        $('.provider_address').html(html1);  
           
         var servicenames='';
             if(providerdetails.providerservice.length > 0 ){
                $.each(providerdetails.providerservice,function(key,service){
                  services[service.admin_service.id]=service.admin_service.admin_service;

                 if(providerservice[service.admin_service.admin_service] != undefined){
                    providerservice[service.admin_service.admin_service].push(service);
                  }else{
                    providerservice[service.admin_service.admin_service]=[];  
                    providerservice[service.admin_service.admin_service].push(service);
                  }
                  
               });
               
                servicenames +=`<label class="country_list_style">Services</label>`;
               $.each(services,function(k,servicename){
                servicenames += `<a href="#" class="list-group-item cityActiveClass" onclick="getData('`+servicename+`')" ><span>`+servicename.charAt(0).toUpperCase()+servicename.slice(1).toLowerCase()+`</span></a>`;
               });
                if(providerdetails.totaldocument.length > 0){
                    $.each(providerdetails.totaldocument,function(key,documents){
                        if(totaldocuments[documents.document.type] != undefined){
                            totaldocuments[documents.document.type].push(documents);
                        }else{
                            totaldocuments[documents.document.type]=[];  
                            totaldocuments[documents.document.type].push(documents);
                        }

                    }); 
                
                }
            }
            $('.myprice').empty().append(`<div class="form-group">
                        <div class="select_city nav-wrapper" style="height:380px;">
                        <div class="list-group">
                            `+servicenames+`
                         <label class="country_list_style">Common</label>
                         <a href="#" class="list-group-item cityActiveClass" onclick="getData('ALL')" ><span>Common Document</span></a>
                        <a href="#" class="list-group-item cityActiveClass" onclick="getData('Profile')" ><span>Profile Picture</span></a>
                        
                         <a href="#" class="list-group-item cityActiveClass" onclick="getData('zone')" ><span>Zone</span></a>    
                         <a href="#" class="list-group-item cityActiveClass" onclick="overall_approval()"><span>Provider Approve</span></a>    
                        </div>
                        </div>
                   </div>
            `   );
           hideLoader();    
       },
        error: (jqXHR, textStatus, errorThrown) => {
            hideLoader();
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
        }
    });
}

function overall_approval(){
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/provider/approve/"+id,
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
                    var data = parseData(data);
                    if (table != null) {
                    var info = $('#data-table').DataTable().page.info();
                    table.order([[ 0, 'asc' ]] ).draw( false );
                    }
                    alertMessage("Success",data.message, "success");
                    $(".crud-modal").modal("hide");
                //window.location.reload();
                }
                hideLoader();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                hideLoader();
                alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
        });
    
}   

function getData(service){
    $('.services,.nav_document,.zone,.approve_all,.zcnl,.Profile,.Address').hide();
    if(service=='TRANSPORT' || service=='ORDER'){
        $('.services,.approve_all,.rld').show();

        var html = `<thead>
                        <tr>
                          <th>Sno</th>
                          <th>Type</th>`;
                           if(service=='TRANSPORT') html+=`<th> Vehicle Type</th>`;
                           html+=`<th>Vechile Name</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>`;
            var result = providerservice[service];
            for (var i in result) {
                if(result[i].vehicle){
                    var j=parseInt(i)+1;
                    vechile_details[result[i].vehicle.id]= result[i].vehicle; 
                    btn=`<button class="btn btn-block btn-block btn-success view_vechile" data-value=`+service+`  data-id =`+result[i].vehicle.id+`>View Vehicle</button>`;
                    html += `<tbody>
                                <tr>
                                <td>`+j+`</td>
                                <td>`+result[i].vehicle.type+`</td>`;
                                if(service=='TRANSPORT') html +=`<td>`+result[i].vehicle.vehicle_name+`</td>`;
                                html +=`<td>`+result[i].vehicle.vehicle_make+`</td>
                                 <td>`+btn+`</td>
                                 </tr>
                                 </tbody>`;
                        $(".services .serviceslist").text("Provider Vehicles");
                        $('.provider_vehicle').html(html);
                }  
            }
    } else if(service=='SERVICE') {
        $('.services,.approve_all').show();
      var url=getBaseUrl() + "/admin/service/servicedocuments/"+id;  
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
                            </tr>
                        </thead>`;
            var result = data.responseData;
            for (var i in result) {
                if(result[i].provideradminservice){
                   
                    html += `<tbody>
                                <tr>
                                 <td>`+result[i].service_category.service_category_name+`</td>
                                 <td>`+result[i].servicesub_category.service_subcategory_name+`</td>
                                 <td>`+result[i].service_name+`</td>
                                 <td>`+result[i].provideradminservice.base_fare+`</td>
                                 
                                 </tr>
                                 </tbody>`;
                }  
            }
            $(".services .serviceslist").text("Provider Services");
            $('.provider_vehicle').html(html); 
        },
        error: (jqXHR, textStatus, errorThrown) => {
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
        }
    });
    }

    // }else if(service=='zone'){
    //     $('.zone,.zcnl').show();
    //     $('.nav_document,.approve_all,.rld').hide();
    // }else{
    $('.nav_document,.rld').show();
    $('.approve_all').hide();
       var html = `<input type="hidden" class="service_names" value=`+service+`>
                     <thead>
                        <tr>
                           <th>Sno</th>
                           <th>Document Name</th>
                           <th>Status</th>
                           <th>@lang('admin.action')</th>
                        </tr>
                    </thead>`;

    if(totaldocuments[service] != undefined){
          var result = totaldocuments[service];
        for (var i in result) {
            if(result[i].document){
                var j=parseInt(i)+1;
                btn=`<button class="btn btn-block btn-block btn-success view_button" data-value=`+service+`  data-id =`+result[i].id+`>View Document</button>`;
                html += `<tbody>
                            <tr>
                                <td>`+j+`</td>
                                <td>`+result[i].document.name+`</td>
                                <td><span class="`+service+`" id='state`+result[i].id+`'>`+result[i].status+`</span></td>
                                <td>`+btn+`</td>
                             </tr>
                            </tbody>`;
                if(result[i].status == "ASSESSING")
                 $('.approve_all').show();            
              } 
            }
      } else {   
         $('.approve_all').hide(); 
        html += `<tbody>
                    <tr>
                    <td colspan='4'>No Document Uploaded</td>
                    </tr>
                </tbody>`;
   }
   $('.provider_document').html(html);

  // }
   if(service=='Profile'){
        $('.Profile,.zcnl').show();
        $('.zone,.nav_document,.approve_all,.rld').hide();
    }

    if(service == 'Address'){

        $('.Address,.zcnl').show();
        $('.zone,.nav_document,.approve_all,.rld,.Profile').hide();
  
    }

   if(service=='zone'){
        $('.zone,.zcnl').show();
        $('.nav_document,.approve_all,.rld,.Profile').hide();
    }


 }  


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
   
});

$(document).on('click', '.view_button', function(e){
        var id =$(this).data('id');
        e.preventDefault();
        $.get("{{ url('admin/provider/') }}/"+$(this).data('id')+"/view_image", function(data) {
            $('.documentdetails .modal-container').html("");
            $('.documentdetails .modal-container').html(data);
        });
        $('.documentdetails').modal('show');
    });
     $('.vechileCancel').on('click', function(){
        $(".vechiledetails").modal('hide');
        $('.crud-modal').css({'overflow-y': 'auto',"overflow-x": "hidden"});
     });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });


    $(document).on('click', '.document_approve', function(){
        
        var id =$('#document_id').val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/provider/approve_image/"+id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                var state = document.querySelector('#state'+id);
                $(state).text('ACTIVE');
                alertMessage("Success", 'Approved Successfully', "success");
                providerservice={};
                totaldocuments={};
                services={};
                total_deatils();
                $('.documentdetails').modal("hide");
                $('.crud-modal').css({'overflow-y': 'auto',"overflow-x": "hidden"});

             }
        });
    });

    $(document).on('click', '.approve_all', function(){
        
        var service =$('.service_names').val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/provider/approveall/"+service,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                $('.approve_all').hide();
                $('.'+service).text('ACTIVE');
                alertMessage("Success", 'Approved Successfully', "success");
                providerservice={};
                totaldocuments={};
                services={};
                total_deatils();
                $('.documentdetails').modal("hide");
                $('.crud-modal').css({'overflow-y': 'auto',"overflow-x": "hidden"});

             }
        });
    });


    $('body').on('click', '.delete', function() {
        var document_id = $(this).data('id');
        var service_name=$(this).data('value');
        confirm("Are you Sure Want To Delete!");
        $.ajax({
            type:"DELETE",
            url:getBaseUrl() + "/admin/provider/delete_view_image/"+document_id+"?provider_id="+id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                alertMessage("Success", 'Deleted Successfully', "success");
                providerservice={};
                totaldocuments={};
                services={};
                total_deatils();
                getData(service_name);
                $('.documentdetails').modal("hide");
                $('.crud-modal').css({'overflow-y': 'auto',"overflow-x": "hidden"});
            }
        });
    });


</script>