<header class="topnav" id="myTopnav">
        <div class="col-lg-12 col-md-12 col-sm-12 dis-space-btw">
                <div class=" dis-ver-center col-md-7 col-sm-6 p-0">
                <a class="logo" href="{{ url('/home') }}"><img src="{{ Helper::getSiteLogo() }}" class="" alt="logo"></a>
                     </div>
            <div class=" col-md-4 p-0 user float-right">
                    <ul class="w-100 dis-flex-end m-0">
                       <!-- <li class="col-xl-2 col-md-3 col-sm-12 p-0 notifications">
                          <div class="dis-end notify col-xl-3" data-toggle="dropdown">
                             <i class="material-icons">notifications</i>
                             <span id="notification_count" class="count"></span>
                          </div>
                          <div id="notifications" class="dropdown-menu height30vh"></div>
                       </li> -->
                       <li class="col-xl-4 col-md-6 col-sm-12 p-0 text-right">
                        <div class="cat_btn">
                              <div class="ddd">
                                 <i class="material-icons cartmodal" data-toggle="modal" data-target="#cartModal" >shopping_cart</i>
                                 <span class="cart-count  cart_tot">0</span>
                              </div>
                           </div>
                       </li>
                       <li class="col-xl-4 col-md-6 col-sm-12 p-0">
                          <a class="dropdown-toggle dis-row" data-toggle="dropdown">
                          <span class="c-pointer"><span class="user_name"></span></span>
                             <span>
                             <img class="user_image user_image user-img" src="" alt="user">
                                <!-- <span class="server-status" type="up"></span> -->
                             </span>
                          </a>
                          <div class="dropdown-menu header-submenu">
                           <a class="dropdown-item" href="{{ url('/profile/general') }}"><i class="material-icons">account_box</i> {{ __('Profile') }}
                              </a>
                              <a class="dropdown-item" href="{{ url('/wallet') }}"><i class="material-icons">account_balance_wallet</i>
                                 {{ __('Wallet') }}</a>
                              <a class="dropdown-item c-pointer referdetail" data-toggle="modal" data-target="#referModal"><i
                                    class="material-icons">card_giftcard</i> {{ __('Referral') }}</a>
                              <a class="dropdown-item notify c-pointer notification" data-toggle="modal" data-target="#notification"><i class="material-icons ">notifications</i> {{ __('Notification') }}<!--  <span class="count">3</span> --></a>
                              <a class="dropdown-item" href="{{ url('/logout') }}"><i class="material-icons">reply</i> {{ __('Logout') }}</a>
                            </div>
                       </li>
                    </ul>
                 </div>
        </div>
    </header>
    <!-- Refer Modal -->
   <div class="modal" id="referModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Refer Header -->
               <div class="modal-header">
                  <h4 class="modal-title">{{ __('Refer A Friend') }}</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Refer body -->
               <div class="modal-body">
                  <div class="col-md-12 col-xl-12 col-xs-12 p-0 mb-4">
                     <div class=" top small-box green mb-2">
                        <div class="left">
                           <h2>{{ __('Your Referral Code') }}</h2>
                           <h4><i class="material-icons">card_giftcard</i></h4>
                           <h1><span class ="referal_code"></span></h1>
                        </div>
                        <div class="sub-box dis-column">
                           <span class="font-12 txt-white">{{ __('Referral Count') }}: <strong><span class ="user_referal_count"></span></strong></span>
                           <span class="font-12 float-right txt-white">{{ __('Referral Amount') }}: <strong><span class ="user_referal_amount"></span></strong></span>
                        </div>
                     </div>
                  </div>
                  <div class="dis-column col-lg-12 col-md-12 col-sm-12 p-0 bor-bottom mb-4 pb-4">
                     <h5 class="text-center">{{ __('Invite your friends And earn') }} <span class ="currency"></span><span class ="referal_amount"></span> {{ __('for every') }}  <span class ="referal_count"></span> {{ __('Users') }} </h5>
                     <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p> -->
					      <form class="validateForm dis-column" style="color:red">
                     	<input class="form-control" type="text" name="referral_email" placeholder="Enter Email" required>
						      <br>
                     	<a id="invite" href="" class="btn btn-primary">{{ __('Invite') }}</a>
					      </form>
                  </div>
                  <!-- <h5 class="text-center mb-2">Refer Your Friends via Social Media</h5> -->
               </div>
            </div>
         </div>
      </div>
        <!-- Refer Modal -->
      <!-- Notification Modal -->
      <div class="modal" id="notification">
            <div class="modal-dialog">
               <div class="modal-content">
                  <!-- Notification Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">{{ __('Notification') }}</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Notification body -->
                  <div class="modal-body height70vh" id="notification_detail">
                  </div>
               </div>
            </div>
      </div>
      <!-- Notification Modal --> 