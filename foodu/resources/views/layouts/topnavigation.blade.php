<!-- <?php $sidebar = SiteHelpers::menus('sidebar') ;
$active = Request::segment(1);
?> -->

<section>
    <div class="admin-navbar">
        <nav class="nav-bar d-flex flex-wrap align-items-center justify-content-md-between justify-content-start bg-light py-1 px-3">
            
            <div class="d-flex align-items-center">
                <div class="px-1 d-md-none d-block">
                    <a href="javascript:;" class="toggleMenu font-weight-bold text-dark flying-button">
                        <i class="lni-menu font-mob"></i>
                    </a>
                </div>
                <a class="navbar-brand mx-md-3 mx-1" href="#">
                    <img src="{{ asset('uploads/logo.png') }}" class="backlogo">
                </a>
            </div>


            <div class="d-flex" id="navbarSupportedContent">
                <ul class="navbar-nav flex-row ml-auto">
                    <!-- <li class="nav-item mx-lg-3 mx-3">
                        <a class="nav-link" href="#">
                            <i class="icon-list font-mob"></i>
                            <span class="label-notify">99</span>
                        </a>
                    </li>
                    <li class="nav-item mx-lg-3 mx-3">
                        <a class="nav-link" href="#">
                            <i class="icon-office font-mob"></i>
                            <span class="label-notify">66</span>
                        </a>
                    </li> -->
                    <li class="nav-item dropdown mx-lg-2 mx-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-1"><i class="fa fa-user font-mob"></i></span>
                            <span class="font-meter my-acc">My Account</span>
                        </a>
                        <div class="dropdown-menu p-0" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item py-2" href="{{ URL::to('user/profile')}}">
                                <div>
                                    <span class="mr-1"><i class="fa fa-user font-meter"></i></span>
                                    <span class="font-meter">Profile</span>
                                </div>
                            </a>
                            <a class="dropdown-item py-2" href="{{ URL::to('/')}}">
                                <div>
                                    <span class="mr-1"><i class="fa fa-user font-meter"></i></span>
                                    <span class="font-meter">Main Site</span>
                                </div>
                            </a>
                            <a class="dropdown-item py-2" href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div>
                                    <span class="mr-1"><i class="fa fa-sign-out font-meter"></i></span>
                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form> <span class="font-meter">Logout</span>
                              </div>
                          </a>
                      </div>
                  </li>
              </ul>
          </div>
      </nav>
  </div>
</section>