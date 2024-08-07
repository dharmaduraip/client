<div class="nav-wrapper">
    <ul class="nav flex-column">
        
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/shop/dashboard') }}">
                <i class="material-icons">dashboard</i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
      
       <li class="nav-item">
           <a class="nav-link" href="{{ url('/shop/view') }}/{{base64_encode(Session::get('shop_id'))}}" >
                <i class="material-icons">store</i>
                <span>{{ __('Shop') }}</span>
            </a>
        </li>

        <li class="nav-item addon_menu">
           <a class="nav-link" href="{{ url('/shop/addonindex') }}/{{base64_encode(Session::get('shop_id'))}}">
                <i class="material-icons">stars</i>
                <span>{{ __('Add On') }}</span>
            </a>
        </li>

        <li class="nav-item">
           <a class="nav-link" href="{{ url('/shop/categoryindex') }}/{{base64_encode(Session::get('shop_id'))}}">
                <i class="material-icons">list</i>
                <span>{{ __('Category') }}</span>
            </a>
        </li>

        <li class="nav-item">
           <a class="nav-link" href="{{ url('/shop/itemsindex') }}/{{base64_encode(Session::get('shop_id'))}}">
                <i class="material-icons">list_alt</i>
                <span>{{ __('Item') }}</span>
            </a>
        </li>

        <li class="nav-item">
           <a class="nav-link" href="{{ url('/shop/dispatcher-panel') }}/{{base64_encode(Session::get('shop_id'))}}">
                <i class="material-icons">local_shipping</i>
                <span>{{ __('Dispatcher') }}</span>
            </a>
        </li>

        <li class="nav-item">
           <a class="nav-link" href="{{ url('/shop/bankdetail') }}">
                <i class="material-icons">account_balance</i>
                <span>{{ __('Bank Details') }}</span>
            </a>
        </li>

        <li class="nav-item">
           <a class="nav-link" href="{{ url('/shop/wallet') }}">
                <i class="material-icons">account_balance_wallet</i>
                <span>{{ __('Wallet') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('/shop/order-history') }}">
                <i class="material-icons">history</i>
                <span> {{ __('Requests History') }}</span>
            </a>
        </li>
         <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#collapse3">
                    <i class="material-icons">account_balance</i>
                    <span class="menudrop_icon">{{ __('Statement') }}</span>
                </a>            
                <div id="collapse3" class="collapse in">
                    <a class="nav-link "  href="{{ url('/shop/statement/order') }}">
                    <i class="material-icons">list_alt</i>
                        <span>{{ __('Orders Statement') }}</span>
                    </a>
                    <a class="nav-link "  href="{{ url('/shop/statement/store') }}">
                    <i class="material-icons">motorcycle</i>
                    <span>{{ __('Store Statement') }}</span>
                    </a>
                </div>
            </li>

    </ul>
</div>

@section('scripts')
@parent

<script>
   
 $('.nav-item').removeClass('active');
 $('.nav-item').each(function(){
   var url=$(this).find("a").attr("href");
   var current_url=window.location.href;
   if(url==current_url){
      $(this).addClass('active');
   }
 })

</script>



@stop