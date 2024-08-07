{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">       
            <h6 class="m-0">{{ __('Request Details') }}</h6>
        </div>
        <div class="form_pad">
        <input type="hidden" name="id" value="{{$id}}">
            <div class="row" id="details">
                
            </div>           
            <br>
            <button type="reset" class="btn btn-danger cancel">{{ __('Close') }}</button>        
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{
    var body = '';
    var id = $("input[name=id]").val();
    var url = getBaseUrl() + "/admin/service/requesthistory/"+id;
        $.ajax({
            url: url,
            type: "GET",
            async : false,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success: function(data) {
            var getData = data.responseData;
            var beforeImageShow =`<dt>@lang('admin.request.before')</dt>
                                <dt> &nbsp;&nbsp;&nbsp;&nbsp;No Image available</dt>`;
            var afterImageShow =`<dt>@lang('admin.request.after')</dt>
                                <dt>&nbsp;&nbsp;&nbsp;&nbsp; No Image available</dt>`;
            if(getData.before_image != null){
                beforeImageShow = `<dt>@lang('admin.request.before')</dt>
                                <dt> <img src="`+getData.before_image+`" style="width:280px;" /></dt>`;
            }
            if(getData.after_image != null){
                afterImageShow = `<dt>@lang('admin.request.after')</dt>
                                <dt> <img src="`+getData.after_image+`" style="width:280px;" /></dt>`;
            }
            body = `   <div class="col-md-6">
                        <dl class="row">

                        <dt class="col-sm-5">@lang('admin.request.Booking_ID') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.booking_id+`</dd>
                        
                        <dt class="col-sm-5">@lang('admin.request.User_Name') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.user.first_name+` `+getData.user.last_name+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.Provider_Name') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ (getData.provider != null ? getData.provider.first_name:'') + ` `+ (getData.provider != null ? getData.provider.last_name:'')+`</dd>`;
                      
                        if(getData.status !="SCHEDULED"){ 
                        
                        body +=     `<dt class="col-sm-5">@lang('admin.request.total_amount') </dt>
                                    <dt class="col-sm-1"> : </dt>
            
                                    <dd class="col-sm-6">`+ (getData.payment != null ? getData.currency+(getData.payment.total-getData.payment.discount) : getData.currency+'0.00')+`</dd>
            
            
                                    <dt class="col-sm-5">@lang('admin.request.ride_start_time') </dt>
                                    <dt class="col-sm-1"> : </dt>
                                    <dd class="col-sm-6">`+ ( getData.started_time != null ? getData.started_time:'') +`</dd>
            
                                    <dt class="col-sm-5">@lang('admin.request.ride_end_time') </dt>
                                    <dt class="col-sm-1"> : </dt>
                                    <dd class="col-sm-6">`+ ( getData.finished_time != null ? getData.finished_time :'')+`</dd>`;
                                    }else{
            
                      body +=      `<dt class="col-sm-5">@lang('admin.request.Schedule_time') </dt>
                                    <dt class="col-sm-1"> : </dt>
                                    <dd class="col-sm-6">`+ ( getData.schedule_time != null ? getData.schedule_time :'')+`</dd>`;
            
                                    }
            
                      body +=      `<dt class="col-sm-5">@lang('admin.request.pickup_address') </dt>
                                    <dt class="col-sm-1"> : </dt>
                                    <dd class="col-sm-6">`+getData.s_address+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.end_time') </dt> 
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.finished_time+`</dd> 
                       

                        <dt class="col-sm-5">@lang('admin.request.service.service_name')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.service.service_name+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.service.category')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.service_category.service_category_name+`</dd>
                       
                        <dt class="col-sm-5">@lang('admin.request.service.user_rating')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+(getData.user?getData.user.rating:'')+`</dd>
                            
                        <dt class="col-sm-5">@lang('admin.request.service.provider_rating')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+(getData.provider?getData.provider.rating:'')+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.service.status')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.status+`</dd>

                       </dl>
                       </div>
                       <div class="col-md-6">
                       <dl class="row">
                            <div class="col-md-12">
                                <dl class="row">` + beforeImageShow +`
                                
                            </div>
                            <div class="col-md-12">
                                <dl class="row"> ` + afterImageShow + `
                                </div>
                            </div>
                            </div>
                        </div>`
                        ;
                $('#details').empty().append(body);
                }
            });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>