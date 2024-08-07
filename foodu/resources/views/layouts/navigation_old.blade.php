<?php $sidebar = SiteHelpers::menus('sidebar') ;
$active = Request::segment(1);
?>
  <div class="navigation">
    <div class="sidebar-compact" id="side-nav">
      <ul>
          <li class="logo" >
            @if(file_exists(public_path().'/uploads/images/'.config('sximo')['cnf_logo']) && config('sximo')['cnf_logo'] !='')
              <img src="{{ asset('uploads/images/'.config('sximo')['cnf_logo'])}}" alt="{{ config('sximo')['cnf_appname'] }}" width="40" />
              @else
              <img src="{{ asset('uploads/logo.png')}}" alt="{{ config('sximo')['cnf_appname'] }}"  width="40" />
              @endif 
           </li>  
          <li  >
            <a href="javascript:;" code="menu-home" @if( $active !='user' && $active !='core'  && $active !='sximo' && $active !='cms') class="active" @endif ><i class="lni-home"></i>
            </a>
          </li>          
          <li>
            <a href="javascript:;"  code="menu-profile" @if( $active =='user') class="active" @endif>
              <i class="lni-user"></i>
            </a>
          </li>
           
          @if( session('gid') =='1' || session('gid') =='2' )
           <li  >
            <a href="javascript:;" code="menu-page" @if( $active =='cms' )  class="active" @endif ><i class="lni-rss-feed"></i>
            </a>
          </li>
          <li > <a href="javascript:;" code="menu-admin" @if( $active =='core') class="active" @endif ><i class="lni-control-panel"></i></a></li>
            @if( session('gid') =='1' )
            <li > <a href="javascript:;" code="menu-app"  @if( $active =='sximo') class="active" @endif><i class="lni-grid-alt"></i></a></li>
            @endif
          @endif
          <li class="bottom logout" style="margin-bottom: 50px;"> 
            <a href="{{ url('notification') }}"  code="menu-home"  >
              <span class="badge badge-pill badge-danger countNotif">0</span>
              <i class="lni-alarm"></i>
          </a></li>
          <li  class="bottom logout"><a href="{{ url('user/logout')}}"class="confirmLogout" ><i class="lni-power-switch"></i></a></li>
      </ul>    
    </div>


  <nav id="sidebar" class="sidebar sidebar-bg" >  
    <div class="sidebar-content ">
     
        <div class="sidebar-header">
          <a href="{{ url('/') }}">                   
           {{ config('sximo.cnf_appname') }} <br /> <small> {{ config('sximo.cnf_appdesc') }} </small> </a>
          <a href="javascript:;" class="toggleMenu expanded-menu"  ><i class="fa fa-times"></i></a>
         
        </div>
        <div class="sidebar-menu" id="menu-profile" >
              <div class="sidebar-profile">
              
                <div class="user-pic">
                  <a href="{{ url('user/profile') }}">
                      {!! SiteHelpers::avatar( 48 ) !!}
                  </a>
                  <p>
                  <b> Welcome back , </b> <br />
                  {{ session('fid')}}</p>
                </div>  
              </div>  
             
             <div class="p-3">

             <ul >
                   <li class="header-menu"><span > Profile  </span></li>
                  <li><a href="{{ url('user/profile')}}"> Edit Profile  </a> </li>
                   <li class="sidebar-dropdown">
                      <a href="javascript:;"> Change Language  </a> 
                      <div class="sidebar-submenu " >
                        <ul>
                          @foreach(SiteHelpers::langOption() as $lang)
                            <li><a href="{{ url('home/lang/'.$lang['folder'])}}"><img class="flag-lang" src="{{ asset('sximo5/images/flags/'. $lang['folder'].'.png')}}" width="16" height="11" alt="lang"  /> {{  $lang['name'] }}</a></li>
                          @endforeach
                        </ul>
                      </div>  
                  </li>
                  <li class="sidebar-dropdown">
                      <a href="javascript:;"> Change Theme  </a> 
                      <div class="sidebar-submenu " >
                        <ul class="themeable">
                         
                            <li><a href="javascript:;" code="sx-dark-theme"> Default </a></li>
                            <li><a href="javascript:;" code="sx-indigo-theme"> Indigo </a></li>
                            <li><a href="javascript:;" code="sx-blue-theme"> Blue </a></li>
                            <li><a href="javascript:;" code="sx-green-theme"> Green </a></li>
                            <li><a href="javascript:;" code="sx-teal-theme"> Teal </a></li>
                            <li><a href="javascript:;" code="sx-purple-theme"> Purple </a></li>
                            <li><a href="javascript:;" code="sx-deep-purple-theme"> Deep Purple </a></li>
                          
                        </ul>
                      </div>  
                  </li>
              </ul>   
              </div>   

        </div>      
     

 
            <div class="sidebar-menu" id="menu-app" >
              <div class="p-3">
                <ul >
                  <li class="header-menu"><span > Applications  </span></li>
                  
                  <li><a href="{{ url('') }}/sximo/config"><i class="lni-list"></i> @lang('core.t_generalsetting') </a> </li> 
                  <li class="header-menu"><span > Builder / Generator  </span></li>
                  <li><a href="{{ url('sximo/module')}}"><i class="lni-offer"></i> @lang('core.m_codebuilder')  </a> </li>
                  <!--<li><a href="{{ url('sximo/rac')}}"><i class="fa fa-random"></i> RestAPI Generator </a> </li> -->
                  <li><a href="{{ url('sximo/tables')}}"><i class="lni-database"></i> @lang('core.m_database') </a> </li>
                  <li><a href="{{ url('sximo/form')}}"><i class="lni-radio-button"></i> @lang('core.m_formbuilder') </a> </li>
                  <li class="header-menu"><span > utility  </span></li>
                  
                  <li><a href="{{ url('sximo/menu')}}"><i class="lni-radio-button"></i>  @lang('core.m_menu')</a> </li>              
                  <li> <a href="{{ url('sximo/code')}}"><i class="lni-infinite"></i> @lang('core.m_sourceeditor') </a>  </li>
                  
                  
                  <li> <a href="{{ url('sximo/config/clearlog')}}" class="clearCache"><i class="lni-spinner-arrow"></i> @lang('core.m_clearcache')</a> </li>

                </ul>
              </div>
            </div>

            <div class="sidebar-menu" id="menu-admin" >
              <div class="p-3">
                <ul >
                  <li class="header-menu"><span > Users and Activities  </span></li>
                    <li ><a href="{{ url('core/users')}}"><i class="lni-users"></i>  @lang('core.m_users') <br /></a> </li> 
                    <li ><a href="{{ url('core/groups')}}"><i class="lni-network"></i>  @lang('core.m_groups') </a> </li>
                    <li><a href="{{ url('core/users/blast')}}"><i class="lni-envelope"></i>  @lang('core.m_blastemail') </a></li> 
                    <li><a href="{{ url('core/elfinder')}}"><i class="fa fa-picture-o"></i> Files &  Media </a> </li>
                    <li> <a href="{{ url('core/logs')}}"><i class="fa fa-bookmark-o"></i> @lang('core.m_logs') </a>  </li>
                    
                  </ul>
              </div>      

            </div>
            <div class="sidebar-menu" id="menu-page" >
              <div class="p-3">
                <ul >                    
                    <li class="header-menu"><span > Page & Article Posts  </span></li>
                    <li><a href="{{ url('cms/pages')}}"><i class="lni-empty-file"></i>   @lang('core.m_pagecms')  </a></li>
                    <li ><a href="{{ url('cms/posts')}}"><i class="lni-files"></i>  @lang('core.m_post')</a></li>
                    <li ><a href="{{ url('cms/categories')}}"><i class="lni-bookmark"></i>  Categories </a></li>
                  
                    
                  </ul>
              </div>      

            </div>
            
            <div class="sidebar-menu" id="menu-home">
              <div class="p-2">
 

            <ul > 
                <li class="header-menu"><span > Main Menu </span></li>
                <li> <a href="{{ url('dashboard') }}" ><span class="iconic">  <i class="lni-home"></i></span> Dashboard</a></li>

        @foreach ($sidebar as $menu)   

            @if($menu['module'] =='separator')
              <li class="header-menu"> <span> {{$menu['menu_name']}} </span></li>  

            @else

                  @if(count($menu['childs']) > 0 ) 
                       <li class="sidebar-dropdown">
                  @else 
                       <li> 
                  @endif

                <a 

                    @if(count($menu['childs']) > 0 ) 
                        href="javascript:void(0);" 
                    @elseif($menu['menu_type'] =='external')
                        href="{{ $menu['url'] }}" 
                    @else
                        href="{{ url($menu['module'])}}" 
                    @endif         
                    @if(Request::segment(1) == $menu['module']) class="active" @endif
                    >    
                    <span class="iconic"> <i class="{{$menu['menu_icons']}}"></i> </span>                                         
                          {{ (isset($menu['menu_lang']['title'][session('lang')]) ? $menu['menu_lang']['title'][session('lang')] : $menu['menu_name']) }}
                     
                        
                  </a> 

                  @if(count($menu['childs']) > 0 ) 
                    <div class="sidebar-submenu " >
                        <ul>
                            @foreach ($menu['childs'] as $menu2)
                            <li>
                                <a 
                                    @if(count($menu2['childs']) > 0 ) 
                                        href="javascript:void(0);" 
                                    @elseif($menu2['menu_type'] =='external')
                                        href="{{ $menu2['url'] }}" 
                                    @else
                                        href="{{ url($menu2['module'])}}" 
                                    @endif  

                                    @if(Request::segment(1) == $menu2['module']) class="active" @endif       
                                >
                                 <span>
                                    {{ (isset($menu2['menu_lang']['title'][session('lang')]) ? $menu2['menu_lang']['title'][session('lang')] : $menu2['menu_name']) }}
                                </span>
                                </a> 

                                @if(count($menu2['childs']) > 0 ) 
                                    <div class="sidebar-submenu " >
                                        <ul>
                                            @foreach ($menu2['childs'] as $menu3)
                                            <li>
                                                <a 
                                                    @if(count($menu3['childs']) > 0 ) 
                                                        href="javascript:void(0);" 
                                                    @elseif($menu3['menu_type'] =='external')
                                                        href="{{ $menu3['url'] }}" 
                                                    @else
                                                        href="{{ url($menu3['module'])}}" 
                                                    @endif  

                                                    @if(Request::segment(1) == $menu3['module']) class="active" @endif       
                                                >
                                                 <span>
                                                    {{ (isset($menu3['menu_lang']['title'][session('lang')]) ? $menu3['menu_lang']['title'][session('lang')] : $menu3['menu_name']) }}
                                                </span>
                                                </a> 
                                            </li>

                                            @endforeach

                                        </ul>
                                    </div>
                                @endif

                            </li>

                            @endforeach

                        </ul>
                    </div>
                  @endif


            </li>       
            @endif

           
        @endforeach
            </div>
          </div>
      

    </div>

  
  </nav>  
</div>   
<script type="text/javascript">
$(document).ready(function(){
    $('.sidebar-menu').hide();

    <?php if($active =='sximo') { ?> 
      $('#menu-app').show(); 
    <?php } else if ($active =='user') { ?> 
      $('#menu-profile').show();
    <?php } else if ($active =='cms') { ?> 
      $('#menu-page').show();  
    <?php } else if ($active =='core') {  ?> 
          $('#menu-admin').show(); 
    <?php } else { ?>
        $('#menu-home').show(); 
    <?php } ?>


    $('.sidebar-compact ul li a ').mouseover(function(){                 
        $('.sidebar-compact ul li a').removeClass('active')
        $(this).addClass('active') 
        $('.sidebar-menu').hide();
        var id = $(this).attr('code');
        $('#'+id).show(); 
    }).mouseout(function() {
       
    })

    $('.sidebar-submenu  ul li a.active').closest('li.sidebar-dropdown').addClass('active')

     $('li.sidebar-dropdown a').click(function(){
            
            $('li.sidebar-dropdown').removeClass('active')
            $(this).parent().addClass('active')

        })

  $('.confirmLogout').click(function() {
      Swal.fire({
        title: 'Logout ?',
        text: ' Logout from the aplikasi ',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, please',
        cancelButtonText: 'cancel'
      }).then((result) => {
        if (result.value) {

          var url = $(this).attr('href');
          window.location.href = url;
          
        }
      })

      return false;

  })  
})

</script>

<script type="text/javascript">
    $(document).ready(function(){
       
    })
</script>