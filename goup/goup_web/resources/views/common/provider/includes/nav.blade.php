<nav class="menu" >
   <div id="header">
         <div class="menu-item menu-one " id="menu-one">
            <a  class="dis-column" href="{{ url('/provider/home') }}">
               <div class="dis-center"><i class="material-icons">dashboard</i></div>
               <span>{{ __('Dashboard') }}</span>
            </a>
         </div>
         <div class="menu-item menu-two " id="menu-two">
            <a   class="dis-column" href="{{ url('provider/wallet') }}">
               <div class="dis-center"><i class="material-icons">account_balance_wallet</i></div>
               <span>{{ __('Account') }}</span>
            </a>
         </div>
         <div class="menu-item menu-three " id="menu-three">
                  <a   class="dis-column" href="{{ url('provider/trips/transport') }}">
                     <div class="dis-center"><i class="material-icons">history</i></div>
                     <span>{{ __('History') }}</span>
                  </a>
         </div>
        <div class="menu-item menu-four profiledetail" id="menu-four">
               <a   class="dis-column" href="{{ url('provider/profile/general') }}">
                  <div class="dis-center"><i class="material-icons">account_box</i></div>
                  <span>{{ __('Profile') }}</span>
               </a>
       </div>

       <div class="menu-item menu-five " id="menu-five">
               <a   class="dis-column" href="{{ url('provider/document/ALL') }}">
                  <div class="dis-center"><i class="material-icons">insert_drive_file</i></div>
                  <span>{{ __('My Documents') }}</span>
               </a>
       </div>

       <div class="menu-item menu-six " id="menu-six">
                  <a   class="dis-column" href="{{ url('provider/myservice') }}">
                      <div class="dis-center"><i class="material-icons">build</i></div>
                      <span>{{ __('My Services') }}</span>
                  </a>
              </div>

      </div>
</nav>

@section('scripts')
@parent

<script>
   
 $('.menu-item').removeClass('menu-active');
 $('.menu-item').each(function(){
   var url=$(this).find("a").attr("href");
   var current_url=window.location.href;
   if(url==current_url){
      $(this).addClass('menu-active');
   }
 })




 function openNav(open) {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
  open.style.display = 'none'; //it will hide the element that is passed in the function parameter
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
  document.body.style.backgroundColor = "white";
  document.getElementById('openButton').style.display = 'block'; //it will show the button that is used to open the menu 
}

</script> 



@stop
