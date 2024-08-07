@extends('order.shop.layout.base')
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}

@section('title') @lang('admin.account.bank_details') @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">@lang('admin.account.bank_details')</span>
            <h3 class="page-title">@lang('admin.account.bank_details')</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">@lang('admin.account.bank_details')</h6>
                </div>
                <div class="col-md-12">
				<form class="bankForm" style= "color:red;">

            </form>
                </div>  
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
@parent
<script>
$(document).ready(function()
{
     basicFunctions();

	 var id = "";
$.ajax({
         url: getBaseUrl() + "/shop/bankdetails/template",
         type: "get",
         async: false,
          headers: {
               Authorization: "Bearer " + getToken("shop")
         },
         success: (data, textStatus, jqXHR) => {
            var bankform = data.responseData;
            if(bankform.length !=0){
               var html=`<div class="row">`;
            for(var i in bankform) {
               html +=`<div class="col-md-4 "><h5 class=""><strong>`+bankform[i].label+`</strong></h5>`;
               var type='number';
               if(bankform[i].type=='VARCHAR'){
                  type='text';
               }
               var editid="";
               var inputvalue="";
               if(bankform[i].bankdetails){
                  inputvalue=bankform[i].bankdetails.keyvalue;
                  editid=bankform[i].bankdetails.id;
               } 
               html +=`<input type="hidden" name ="bankform_id[`+i+`]" value ="`+bankform[i].id+`">
                       <input type="`+type+`" class="form-control" name="keyvalue[`+i+`]" value ="`+inputvalue+`" placeholder="`+bankform[i].label+`" >
                       <input type="hidden" class="editid" name ="id[`+i+`]" value ="`+editid+`"> </div>`;
            }
               html +=`</div><button type="submit" id="submit-button"  class="btn btn-success mt-3">Save</button><br><br><br>`;
           } else {
               var html=`<div class="row"><p>NO Bank Details for this Country Contact Admin</p> </div>`;
              
               alertMessage("error", "No Bank Details for this country ", "danger");
            }
            $('.bankForm').html(html);
           
         },
         error: (jqXHR, textStatus, errorThrown) => {
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
         }
      }); 

      $('.bankForm').validate({
		errorElement: 'span', 
		errorClass: 'help-block txt-red',
		focusInvalid: false,
	   highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},
      submitHandler: function(form,e) {
           var data = new FormData();
            var formGroup = $(".bankForm").serialize().split("&");
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append(decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }
            var bankdetails_id=$('.editid').val();
            if(!bankdetails_id)
            var url = getBaseUrl() + "/shop/addbankdetails";
            else
            var url = getBaseUrl() + "/shop/editbankdetails";
            savefunction(data,url)  
         }
    });

    function savefunction(data,url){
     $.ajax({
        url: url,
        type: "post",
        data: data,
        'beforeSend': function (request) {
                showLoader();
        },
        headers: {
           Authorization: "Bearer " + getToken("shop")
        },
        processData: false,
        contentType: false,
        success: function(response, textStatus, jqXHR) {
               var data = parseData(response);
               var shopSettings = getShopDetails();
               shopSettings.is_bankdetail=1;
               setShopDetails(shopSettings);
               alertMessage("Success", data.message, "success");
               setTimeout(function(){
                 location.reload();
                 }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
           alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
        }
     });
  }
	

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>

@stop






















