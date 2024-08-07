{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

<div class="row mb-4">
    <div class="col-md-12">
        <div class="modal-header border-bottom">
            
            <h4 class="m-0" style="margin:10!important;"> {{ __('Add') }} {{ __('Payroll') }}</h4>
        </div>
        <div class="modal-body p-2">
            <form class="validateForm" files="true">
                @csrf()
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif

                
                
                <div class="">
                {{ __('Choose What type of payroll You Want to Create?') }}
                </div>

                
                <br>
                
<!--                 
                <button type="button" class="btn btn-accent  addmanual float-left">Manual Payroll</button>
                <br>
                <button type="button" class="btn btn-accent  addtemplate float-right">Template Payroll</button>
               
                <br> -->
                <div class="row m-0">
                <button type="button" class="btn btn-accent  addmanual">{{ __('Manual Payroll') }}</button>
                <button type="button" class="btn btn-accent  addtemplate ml-2">{{ __('Zone Payroll') }}</button>
                <button type="reset" class="btn btn-danger cancel ml-2">{{ __('Cancel') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{
    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>
