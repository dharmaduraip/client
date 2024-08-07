<nav class="menu" >
   <div id="header">
      <div class="menu-item menu-one " id ="home">
         <a  class="dis-column" href="{{ url('/home') }}">
            <div class="dis-center"><i class="material-icons">home</i></div>
            <span>{{ __('Home') }}</span>
         </a>
      </div>
      <div class="menu-item menu-two" id ="history-detail">
         <a class="dis-column" href="javascript:;">
            <div class="dis-center"><i class="material-icons">location_on</i></div>
            <span class=my-history-detail >{{ __('My History') }}</span>
         </a>
      </div>
      <div class="menu-item menu-three ">
         <a class="dis-column" href="{{ url('/profile/general') }}">
            <div class="dis-center"><i class="material-icons">account_box</i></div>
            <span>{{ __('Profile') }}</span>
         </a>
      </div>
      <div class="menu-item menu-four">
         <a class="dis-column" href="{{ url('/wallet') }}">
            <div class="dis-center"><i class="material-icons">account_balance_wallet</i></div>
            <span>{{ __('Wallet') }}</span>
         </a>
      </div>
   </div>
</nav>
<div class="subnav" style="display:none"> 
      @foreach(Helper::getServiceList() as $service)
         <div class="menu-item menu-one ">
            @if($service =='TRANSPORT')
               <div id ="transport-detail">
                  <a  class="dis-column" href="{{ url('/transport/trips') }}">
                     <div class="dis-center"><i class="material-icons">local_taxi</i></div>
                     <span class ="transport-detail">{{ __('TRANSPORT') }}</span>
                  </a>
               </div>
            @elseif($service =='ORDER')
               <a  class="dis-column" href="{{ url('/order/trips') }}">
                  <div class="dis-center"><i class="material-icons">fastfood</i></div>
                  <span class ="order-detail">{{ __('ORDER') }}</span>
               </a>
             @elseif($service =='DELIVERY')
               <a  class="dis-column" href="{{ url('/delivery/trips') }}">
                  <div class="dis-center"><i class="material-icons">fastfood</i></div>
                  <span class ="order-detail">{{ __('DELIVERY') }}</span>
               </a>
            @else
               <a  class="dis-column" href="{{ url('/services/trips') }}">
               <div class="dis-center"><i class="material-icons">local_laundry_service</i></div>
                  <span class ="service-detail">{{ __('SERVICE') }}</span>
               </a>
            @endif
         </div>
      @endforeach
      <!-- <div class="menu-item menu-one ">
         <a  class="dis-column" href="../taxi-booking/my-trips.php">
            <div class="dis-center"><i class="material-icons">local_taxi</i></div>
            <span>Taxi</span>
         </a>
      </div>
      <div class="menu-item menu-two menu-active ">
         <a   class="dis-column" href="./my-orders.php">
            <div class="dis-center"><i class="material-icons">fastfood</i></div>
            <span>Food</span>
         </a>
      </div>
      <div class="menu-item menu-three ">
         <a   class="dis-column" href="../services/my-services.php">
            <div class="dis-center"><i class="material-icons">local_laundry_service</i></div>
            <span>Book Services</span>
         </a>
      </div> -->
</div>

@section('scripts')
@parent

<script>
$(document).ready(function() {
   $(".menu .menu-item a").each(function() {
   var url=$(this).attr("href");
   var current_url=window.location.href;
   if(url==current_url){
      console.log($(this).parent().siblings());
      $(this).parent().addClass('menu-active');
   } else if(current_url.includes('trip')) {
      $('#history-detail').addClass('menu-active');
   }
   });


 $('#history-detail').on('click', function () {
   $('#booking-form').removeClass('content-box');
   $('#booking-form').addClass('content-box-2');
});

});
</script>

@stop
