@extends('common.provider.layout.base')
@section('styles')
@parent
<link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
@stop
@section('content')
@include('common.admin.includes.image-modal')
      <section class="z-1 content-box" id="profile-form">
      <div class="clearfix ">
      <h4><strong class="title-bor">@lang('provider.bank_details')</strong></h4>
       <!--Add card and amount details!-->
       <div class="col-md-12">
             <form class="validateForm" style= "color:red;">
               
               
            </form>
            </div>
        </div>
    
       </section>
@stop
@section('scripts')
@parent
   
   <script>
      // Header-Section
      function openNav() {
         document.getElementById("mySidenav").style.width = "50%";
      }
      function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
      }
      $(document).ready(function()
      {
         basicFunctions();
	      var id = "";
	   $.ajax({
         url: getBaseUrl() + "/provider/bankdetails/template",
         type: "get",
         async: false,
          headers: {
               Authorization: "Bearer " + getToken("provider")
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
               html +=`</div><button type="submit" id="submit-button"  class="btn btn-primary mt-3">Save</button>`;
            $('.validateForm').html(html);
            }
         },
         error: (jqXHR, textStatus, errorThrown) => {
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
         }
      });

      $('.validateForm').validate({
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
            var formGroup = $(".validateForm").serialize().split("&");
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append(decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }
            var bankdetails_id=$('.editid').val();
            if(!bankdetails_id)
            var url = getBaseUrl() + "/provider/addbankdetails";
            else
            var url = getBaseUrl() + "/provider/editbankdetails";
            savefunction(data,url)  
         }
    }); 
    function savefunction(data,url){
     $.ajax({
        url: url,
        type: "post",
        data: data,
        headers: {
           Authorization: "Bearer " + getToken("provider")
        },
        processData: false,
        contentType: false,
        success: function(response, textStatus, jqXHR) {
            var data = parseData(response);
            var providerdata=localStorage.getItem('provider');
                providerdata=JSON.parse(decodeHTMLEntities(providerdata));
                providerdata.is_bankdetail=1;
                localStorage.setItem("provider", JSON.stringify(providerdata));
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


	
});

   </script>
@stop