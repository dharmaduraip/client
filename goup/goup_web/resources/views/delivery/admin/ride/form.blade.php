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
            
            <button type="reset" class="btn btn-danger cancel">{{ __('Close') }}</button>        
        </div>
    </div>
</div>


<script>
$(document).ready(function()
{
    var body = '';
    var id = $("input[name=id]").val();
    var url = getBaseUrl() + "/admin/delivery/requesthistory/"+id;

        $.ajax({
            url: url,
            type: "GET",
            async : false,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success: function(data) {
           var getData = data.responseData;
            body = `    <div class="col-md-6">
                        <dl class="row">

                        <dt class="col-sm-5">@lang('admin.request.Booking_ID') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.booking_id+`</dd>
                        
                        <dt class="col-sm-5">@lang('admin.request.User_Name') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.user.first_name+` `+getData.user.last_name+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.Provider_Name') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ (getData.provider != null ? getData.provider.first_name:'')+ ` ` +(getData.provider != null ? getData.provider.last_name:'') +`</dd>
                      
                        <dt class="col-sm-5">@lang('admin.request.total_distance') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.distance+`</dd>`;

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
                        var d_address = '';
               $.each(getData.deliveries,function(key,value){
                  d_address += value.d_address+'</br>';
               }); 

          body +=      `<dt class="col-sm-5">@lang('admin.request.pickup_address') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.s_address+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.drop_address') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+d_address+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.ride_status') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.status+`</dd>

                       </dl>
                       </div>
                       <div class="col-md-6">
                            <dl class="row">
                            <dt class="col-sm-8"> <img class = "map_key_img" src="https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=320x380&maptype=terrian&format=png&visual_refresh=true&markers=icon:`+window.url+`/assets/layout/images/common/marker-start.png%7C`+getData.s_latitude+`,`+getData.s_longitude+`&markers=icon:`+window.url+`/assets/layout/images/common/marker-end.png%6C`+getData.d_latitude+`,`+getData.d_longitude+`&path=color:0x191919|weight:3|enc:`+getData.route_key+`&key=`+getSiteSettings().site.browser_key+`" /> </dt>
                            </div>
                        </div>
                        `;
                $('#details').empty().append(body);
                }
            });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>