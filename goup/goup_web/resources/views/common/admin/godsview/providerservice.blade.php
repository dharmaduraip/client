{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<link rel="stylesheet" href="{{ asset('assets/layout/css/service-master.css')}}">
<div class="card-header border-bottom">
            
            <h6 class="m-0"style="margin:10!important;">{{ __('Provider Details') }}</h6>
</div>
<div class="row p-3">
    
    <div class="col-md-4 box-card border-rightme myprice">

    </div>
    <div class="col-md-8 box-card price_lists_sty priceBody">
       
            <div class="col-xs-12  list_ser_p">
                <nav class="services">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Provider Services') }}</a>
                    </div>
                </nav>
                <div class="services pricing-nav nav-wrapper" id="nav-tabContent">
                    <div  class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                       <table class="table table-bordered table-striped  provider_vehicle">
                        </table>
                    </div>
                    </div>
               
               
              
               
                
            </div>
           
           <br/>
            <button type="button" class="btn btn-danger cancel rld ">{{ __('Cancel') }}</button>
            
            </div>
            
        
   
</div>
<style type="text/css">
div.list_ser_p {
  
  height: 300px;

  overflow-y: scroll;
}
</style>
@include('common.admin.includes.redirect')
<script>
    basicFunctions();
    var id={{$id}};
    var providerservice={};
    var totaldocuments={};
    var services={};
    var vechile_details=[]; 
    
   


   
        
      
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
                /*if(providerdetails.totaldocument.length > 0){
                    $.each(providerdetails.totaldocument,function(key,documents){
                        if(totaldocuments[documents.document.type] != undefined){
                            totaldocuments[documents.document.type].push(documents);
                        }else{
                            totaldocuments[documents.document.type]=[];  
                            totaldocuments[documents.document.type].push(documents);
                        }

                    }); 
                
                }*/
            }
            $('.myprice').empty().append(`<div class="form-group">
                        <div class="select_city nav-wrapper" style="height:380px;">
                        <div class="list-group">
                            `+servicenames+`    
                        </div>
                        </div>
                   </div>
            `   );
           hideLoader();    
       }
    });
}

@if($sid)
getData("{{strtoupper($sid)}}");
@endif

function getData(service){
    
    if(service=='TRANSPORT'){
            var url=getBaseUrl() + "/admin/transportdocuments/"+id;  
       $.ajax({
        type:"GET",
        url: url,
        'beforeSend': function (request) {
            showLoader();
        },
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){ 
            var html = `<thead>
                        
                    </thead>`;
            var result = data.responseData;
            for (var i in result) {
                
                html += `<tbody>
                <tr>
                
                <td>`+result[i].ride_name+`</td>
                 
                 </tr>
                 </tbody>`;   
            }
            $('.provider_vehicle').html(html);
            hideLoader();
         }
          
        });



    }else if(service=='ORDER'){
        
        var url=getBaseUrl() + "/admin/store/orderdocuments/"+id;  
       $.ajax({
        type:"GET",
        url: url,
        'beforeSend': function (request) {
            showLoader();
        },
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
        var html = `<thead>
                        
                    </thead>`;
            var result = data.responseData;
            for (var i in result) {
                
                    html += `<tbody>
                                <tr>
                                
                                <td>`+result[i].name+`</td>
                                 
                                 </tr>
                                 </tbody>`;
                        $('.provider_vehicle').html(html);
                 
            }
            hideLoader();
            }
         });
    } else if(service=='SERVICE') {
        
      var url=getBaseUrl() + "/admin/service/servicedocuments/"+id;  
       $.ajax({
        type:"GET",
        url: url,
        'beforeSend': function (request) {
            showLoader();
        },
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            var html = `<thead>
                            <tr>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Service</th>
                                
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
                                 
                                 
                                 </tr>
                                 </tbody>`;
                }  
            }
            $('.provider_vehicle').html(html); 
            hideLoader();
        }
    });


    }
    $('.nav_document,.approve_all').show();
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
              }  
            }
      }else {
        html += `<tbody>
                    <tr>
                    <td colspan='4'>No Document Uploaded</td>
                    </tr>
                </tbody>`;
   }
   $('.provider_document').html(html);

   if(service=='zone'){
        $('.zone').show();
        $('.nav_document,.approve_all').hide();
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







</script>