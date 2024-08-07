<div class="col-md-3 col-sm-12 col-12 page-sidebar bhoechie-tab-menu">
                <a href="{!! URL::to('profile') !!}" class="@if($segment == 'profile') active @endif">
                    <span class="circle_icon"><i class="fa fa-user" aria-hidden="true"></i></span>{!! Lang::get('core.my_profile') !!}
                </a>
                <!-- <a href="{!! URL::to('changepass') !!}" class="@if($segment == 'changepass') active @endif">
                    <span class="circle_icon"><i class="fa fa-lock" aria-hidden="true"></i></span>{!! Lang::get('core.change_pwd') !!}
                </a> -->
                <a href="{!! URL::to('orders') !!}" class="@if($segment == 'orders') active @endif">
                    <span class="circle_icon"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span>{!! Lang::get('core.orders') !!}
                </a>
                <a href="{!! URL::to('offers') !!}" class="@if($segment == 'offers') active @endif">
                    <span class="circle_icon"><i class="fa fa-percent" aria-hidden="true"></i></span>{!! Lang::get('core.offers') !!}
                </a>
                <a href="{!! URL::to('favourites') !!}" class="@if($segment == 'favourites') active @endif">
                    <span class="circle_icon"><i class="fa fa-heart" aria-hidden="true"></i></span>{!! trans('core.abs_favourites') !!}
                </a>
                 <a href="{!! URL::to('payments') !!}" class="@if($segment == 'payments') active @endif" >
                    <span class="circle_icon"><i class="fa fa-credit-card" aria-hidden="true"></i></span>{!! Lang::get('core.abs_wallet') !!}
                </a>
                <a href="{!! URL::to('offer-wallet') !!}" class="@if($segment == 'offer-wallet') active @endif" >
                    <span class="circle_icon"><i class="fa fa-gift" aria-hidden="true"></i></span>{!! Lang::get('core.abs_offer_wallet') !!}
                </a>
                <a href="{!! URL::to('manage_addresses') !!}" class="@if($segment == 'manage_addresses') active @endif">
                    <span class="circle_icon"><i class="fa fa-map-pin" aria-hidden="true"></i></span>{!! Lang::get('core.address') !!}
                </a>
            </div>