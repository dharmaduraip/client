 <div class="modal-dialog dis-center">
   <div class="modal-content min-70vw">
      <!-- Cart Header -->
      <div class="modal-header">
         <h4 class="modal-title">@lang('store.user.Cart')</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Cart body -->
      <div class="modal-body">
         <!-- Empty Cart -->
         <div class="widget widget-cart empty-cart d-none">
            <div class="widget-heading bg-white b-0 p-0 dis-column">
               <div class="clearfix"></div>
               <img class="w-50 mt-3" src="../img/foody/empty-cart.svg">
            </div>
         </div>
         <!-- Empty Cart -->
         <div class="row m-0">
            <div class="widget-body col-sm-12 col-md-12 col-xl-6" id="rcart_list">
               loading.......................
            </div>
            <div class="cart-totals-fields col-sm-12 col-md-12 col-xl-6">
               <table class="table">
                  <tbody>
                     <tr>
                        <td>@lang('store.user.Total_Items_Price')</td>
                        <td><span class="tot_gross right"></span></td>
                     </tr>
                     <tr class="shop_offer_tr d-none">
                        <td>@lang('store.user.Shop_Offer')</td>
                        <td><span class="shop_offer right"></span></td>
                     </tr>
                     <tr>
                        <td>@lang('store.user.Shop_GST')</td>
                        <td><span class="shop_gst right"></span></td>
                     </tr>
                      <tr>
                        <td>@lang('store.user.Shop_Package_Charge')</td>
                        <td><span class="shop_pkg right"></span></td>
                     </tr>
                     <tr class="d-none">
                        <td>@lang('store.user.Promocode')</td>
                        <td><span class="promocode right"></span></td>
                     </tr>
                    <!--  <tr>
                        <td class="others d-none" >Shipping &amp; Handling</td>
                        <td class="food d-none">Delivery Charge</td>
                        <td class="delivery_charge right">$2.00</td>
                     </tr> -->
                  </tbody>
               </table>
               <div class="widget-body green">
                  <div class="price-wrap text-center">
                     <i class="material-icons address-category">attach_money</i>
                     <p class="txt-white">@lang('store.user.SUB_TOTAL')</p>
                     <h3 class="value txt-white"><strong class="Total">$ 25,49</strong></h3>
                     <p class="txt-white freeship">@lang('store.user.Free_Shipping')</p>
                     <!-- <a id="checkout" href="./checkout.php" class="btn btn-primary bg-white primary-color">Checkout <i class="fa fa-arrow-right" aria-hidden="true"></i></a> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Cart footer -->
      <div class="modal-footer">
         <a  class="btn btn-primary chk_url" href="{{url('/store/checkout/')}}">@lang('store.user.Checkout') <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
      </div>
   </div>
</div>