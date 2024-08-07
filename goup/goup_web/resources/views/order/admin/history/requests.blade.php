{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">       
            <h6 class="m-0">{{ __('Request Details') }}</h6>
        </div>
        <div class="form_pad">
        <input type="hidden" name="id" value="{{$id}}">
            <div class="row">
                <div class="col-md-6" id="details">
                </div>
                <div class="col-md-6" id="items">
                </div>
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
    var url = getBaseUrl() + "/admin/store/requesthistory/"+id;
        $.ajax({
            url: url,
            type: "GET",
            async : false,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success: function(data) {
            var getData = data.responseData;
            var itembody ='';
            body = ` 
                    <dl class="row">
                    <dt class="col-sm-5">@lang('admin.request.Booking_ID') </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.store_order_invoice_id+`</dd>
                    <dt class="col-sm-5">@lang('admin.request.User_Name') </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.user.first_name+` `+getData.user.last_name+`</dd>
                    <dt class="col-sm-5">Store Name </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.store.store_name+`</dd>
                    <dt class="col-sm-5">Store Location </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.store.store_location+`</dd>
                    <dt class="col-sm-5">Schedule Date And Time </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.schedule_datetime+`</dd>
                    <dt class="col-sm-5">Collectable Delivery Cost </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.collectable_delivery_cost+`</dd>
                    <dt class="col-sm-5">productId </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.productId+`</dd>
                    <dt class="col-sm-5">status </dt>
                    <dt class="col-sm-1"> : </dt>
                    <dd class="col-sm-6">`+getData.status;
                itembody = itembody + ``;
                $('#details').empty().append(body);
                $('#items').empty().append(itembody);
                }
            });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>