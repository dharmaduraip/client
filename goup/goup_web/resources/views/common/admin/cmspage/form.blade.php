@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('CMS Page') }} @stop

@section('styles')
@parent
@stop
@section('content') 

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('ADD') }} {{ 
            __('Cms Page') }}</span>
            <h3 class="page-title">{{ __('Cms Page') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="note_txt">
                @if(Helper::getDemomode() == 1)
                <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                <span class="pull-left">(*personal information hidden in demo)</span>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('Cms Page') }}</h6>
                </div>

          <div class="col-md-12">
					<form class="validateForm">
						@csrf()
                        <div class="method">
                        </div>
                        
						<input type="hidden" name="id" id="id" value="">
                                <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name" class="col-xs-2 col-form-label">{{ __('admin.pages.name') }}</label>
                                <select name="page_name" id="page_name" class="form-control">
                                    <option value="">Select</option>
                                    <option value="help">Help</option>
                                    <option value="page_privacy">Privacy Policy</option>
                                    <option value="terms">Terms of Use</option>
                                    <option value="cancel">Cancelation Policy</option>
                                    <option value="about_us">About Us</option>
                                    <option value="legal">Legal</option>
                                    <option value="faq">Faq</option>
                                </select>
                            </div>
                        </div>
                            <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description" class="col-xs-2 col-form-label">{{ __('admin.pages.description') }}</label>
                            <div class="col-lg-12 p-0" id="load_cont">
                                <!-- <textarea class="form-control" id="content" name="content"></textarea> -->

                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('admin.pages.status')</label>
						<select name="status" id="status" class="form-control">
                          
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				  </div>
                 @if(Helper::getDemomode() != 1)
                <button type="submit" class="btn btn-accent">{{ __('Submit') }}</button>
                @endif
						<br><br><br>
					</form>
                </div>  
            </div>
        </div>
    </div>
</div>
@stop

<style type="text/css">
    .cke_contents > iframe{
  width: 100% !important;
}
</style>
@include('common.admin.includes.redirect')
@section('scripts')
@parent

<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

<script>

$(document).ready(function()
{
   
     basicFunctions();
     var page_id="";

     page_name(page_id);

     $('#page_name').change(function(){
var page='/'+$(this).val();
page_name(page);

     })




     
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focusurl the last invalid input
		rules: {
            page_name: { required: true },
            content: { required: true },
            status: { required: true },
		},

		messages: {
			page_name: { required: "Page Name is required." },
			content: { required: "Content is required." },
            status: { required: "Status is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},
		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},
        submitHandler: function(form) {

            var formGroup = $(".validateForm").serialize().split("&");
         
           var data = new FormData();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append('content',CKEDITOR.instances['content'].getData());
			var id=$('#id').val();
			if(id){
            var url = getBaseUrl() + "/admin/cmspage/"+id;
			}else{
				var url = getBaseUrl() + "/admin/cmspage";
			}
           
            saveRow( url, null, data,'admin','/admin/cmspage');
			

        }
    });

    function page_name(page_id){
       
        showInlineLoader();
  
	
$.ajax({
   type:"GET",
   url: getBaseUrl() + "/admin/cmspage"+page_id,
   headers: {
       Authorization: "Bearer " + getToken("admin")
   },
   success:function(data){

       var result = data.responseData;
       $("#load_cont").html('');
       var html='<textarea class="form-control" id="content" name="content"></textarea>';
       $("#load_cont").html(html);
      if(result.length) {
       $('#page_name').val(result[0].page_name);
     $('#content').val(result[0].content);
       CKEDITOR.replace('content');
     $('#status').val(result[0].status);
       $('#id').val(result[0].id);
       $('.method').html('<input type="hidden" name="_method" id="method" value="PATCH">');
       }else{
        $('#content').val("");
       CKEDITOR.replace('content');
      $('#id').val("");
       $('.method').html(''); 
       }
       hideInlineLoader();
       
   }
});
}


});
</script>
@stop