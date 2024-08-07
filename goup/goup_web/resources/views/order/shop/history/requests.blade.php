{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
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
<script>
$(document).ready(function()
{
    var body = '';
    var id = $("input[name=id]").val(); 
    var url = getBaseUrl() + "/shop/requesthistory/"+id;

        $.ajax({
            url: url,
            type: "GET",
            async : false,
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            success: function(data) {
                console.log(data);
           var getData = data.responseData;
           var items = getData.order_invoice.items;
           var itemsLength = getData.order_invoice.items.length;
           var mapAddress = '';
           var pickUpStore = '';
           var pickUpLocation = '';
           var providerRating = '';
           if(getData.provider != null){
                providerRating = getData.provider.rating;
           }
           if(getData.delivery != null){
                mapAddress = getData.delivery.map_address;
           }
           if(getData.pickup != null){
                pickUpStore =getData.pickup.store_name;
                pickUpLocation =getData.pickup.store_location;
           }
           var itembody ='';
            body = `   
                        <dl class="row">

                        <dt class="col-sm-5">@lang('admin.request.Booking_ID') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.store_order_invoice_id+`</dd>
                        
                        <dt class="col-sm-5">@lang('admin.request.User_Name') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.user.first_name+` `+getData.user.last_name+`</dd>`;

                        if(getData.provider) {
                        body += `<dt class="col-sm-5">@lang('admin.request.Provider_Name') </dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ (getData.provider != null ? getData.provider.first_name:'') + ` `+ (getData.provider != null ? getData.provider.last_name:'')+`</dd>`;
                        }

                        body += `<dt class="col-sm-5">@lang('admin.request.order.payment_mode')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.order_invoice.payment_mode+`</dd>
                        
                        <dt class="col-sm-5">@lang('admin.request.order.total_amount')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.currency+(getData.order_invoice.total_amount-getData.order_invoice.discount)+`</dd>
                       
                        <dt class="col-sm-5">@lang('admin.request.order.promo_amount')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.currency+getData.order_invoice.discount+`</dd>

                        <dt class="col-sm-5">@lang('admin.request.order.user_rating')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.user.rating+`</dd>`;
                        
                        if(getData.provider) {
                        body += `<dt class="col-sm-5">@lang('admin.request.order.provider_rating')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ providerRating +`</dd>`;
                        }

                        body += `<dt class="col-sm-5">@lang('admin.request.service.status')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+getData.status+`</dd>`;
                        if(getData.status== 'CANCELLED') {
                          body += `  <dt class="col-sm-5">Cancel By</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+(getData.cancelled_by != null ?  getData.cancelled_by : '')+`</dd> <dt class="col-sm-5">Reason</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+(getData.reason != null ?  getData.reason.reason :  getData.cancel_reason)+`</dd> `;

                         }

                       body += `</dl> <p>LOCATION <hr /></p>
                       <dl class="row">  <dt class="col-sm-5">@lang('admin.request.order.delivery_location')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ mapAddress +`</dd>

                        <dt class="col-sm-5">@lang('admin.request.order.storename')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ pickUpStore +`</dd>

                        <dt class="col-sm-5">@lang('admin.request.order.store_location')</dt>
                        <dt class="col-sm-1"> : </dt>
                        <dd class="col-sm-6">`+ pickUpLocation+`</dd></dl>
                       `;
                itembody =  itembody +`<p>ITEM DETAILS</p>`;
                for(var i=0;i<itemsLength;i++){
                    itembody =  itembody + 
                    `<dl class="row"> <dt class="col-sm-5"> Item Name </dt> <dt class="col-sm-1"> : </dt> <dd class="col-sm-6">` +items[i].product.item_name+`</dd>
                    <dt class="col-sm-5"> Item QTY </dt> <dt class="col-sm-1"> : </dt> <dd class="col-sm-6">` +items[i].quantity+`</dd>
                   <dt class="col-sm-5"> Item Price </dt> <dt class="col-sm-1"> : </dt> <dd class="col-sm-6">` +getData.currency+items[i].product.item_price+`</dd>
                   `;
                   if(items[i].cartaddon.length>0){
                    itembody+=`<dt class="col-sm-5" >Addons:- </dt><dd class="col-sm-7"></dd>`;
                    $.each(items[i].cartaddon,function(index,addon){
                        
                        itembody+=`<dt class="col-sm-5"> Addon Name </dt> <dt class="col-sm-1"> : </dt> <dd class="col-sm-6">` +addon.addon_name+`</dd><dt class="col-sm-5"> Addon Price </dt> <dt class="col-sm-1"> : </dt> <dd class="col-sm-6">` +getData.currency+addon.addon_price+`</dd>`;
                    })
                   }
                   itembody+=`<dt class="col-sm-5"> Total </dt> <dt class="col-sm-1"> : </dt> <dd class="col-sm-6">` +getData.currency+parseFloat(items[i].total_item_price)+`</dd>`;
                   itembody+=`</dl><hr />`;
                
                }
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