<?php
$sidebar = SiteHelpers::menus('sidebar') ;
$active = Request::segment(1);
?>


<div class="navigation spc-cls">
	<nav id="sidebar" class="sidebar sidebar-bg h-100" >  
		<div class="sidebar-content ">
			<!-- <div class="sidebar-header bg-sidemenu">
				@if(file_exists(public_path().'/uploads/images/'.config('sximo')['cnf_logo']) && config('sximo')['cnf_logo'] !='')
				<img src="{{ asset('uploads/images/'.config('sximo')['cnf_logo'])}}" alt="{{ config('sximo')['cnf_appname'] }}" width="40" />
				@else
				<img src="{{ asset('uploads/logo.png')}}" alt="{{ config('sximo')['cnf_appname'] }}"  width="40" />
				@endif
				<a href="{{ url('/') }}">
					{{ config('sximo.cnf_appname') }} <br /> <small> {{ config('sximo.cnf_appdesc') }} </small>
				</a>
				{{-- <a href="javascript::void();" class="toggleMenu expanded-menu"  ><i class="fa fa-times"></i></a> --}}
			</div> -->
			<div class="sidebar-menu bg-sidemenu" id="menu-profile" >
				<div class="sidebar-profile">
					<div class="user-pic">
						<a href="{{ url('user/profile?'.time()) }}">
							{!! SiteHelpers::avatar( 48 ) !!}
						</a>
						<p> <b>{{ session('fid')}} </b> <br />
						Last Login:
						<small>{{ date("F j, Y", strtotime(Session::get('ll'))) }}</small></p>
					</div>
				</div>
					<ul >
						@if(Auth::user()->group_id == 1 || Auth::user()->group_id == 2)
						<li> <a href="{{ url('dashboard?'.time()) }}" @if(\Request::is('dashboard')) class="active" @endif ><span class="iconic d-flex align-items-center"> <i class="lni-home"></i>Dashboard</span> </a></li>
						@endif
						<li><a href="{{ url('user/profile?'.time())}}" @if(\Request::is('user/profile')) class="active" @endif><span class="iconic d-flex align-items-center"> <i class="icon-profile"></i>Profile </span> </a> </li>
						{{-- <li><a href="{{ url('') }}/sximo/config"><i class="lni-list"></i> @lang('core.t_generalsetting') </a> </li> --}} 
						{{-- <li><a href="{{ url('sximo/module')}}"><i class="lni-offer"></i> @lang('core.m_codebuilder')  </a> </li>
						<li><a href="{{ url('sximo/tables')}}"><i class="lni-database"></i> @lang('core.m_database') </a> </li>
						<li><a href="{{ url('sximo/form')}}"><i class="lni-radio-button"></i> @lang('core.m_formbuilder') </a> </li>
						<li><a href="{{ url('sximo/menu')}}"><i class="lni-radio-button"></i>  @lang('core.m_menu')</a> </li>              
						<li> <a href="{{ url('sximo/code')}}"><i class="lni-infinite"></i> @lang('core.m_sourceeditor') </a>  </li> --}}
					   {{--  <li> <a href="{{ url('sximo/config/clearlog')}}" class="clearCache"><i class="lni-spinner-arrow"></i> @lang('core.m_clearcache')</a> </li> --}}
					   {{--  <li ><a href="{{ url('core/users')}}"><i class="lni-users"></i>  @lang('core.m_users') <br /></a> </li> 
						<li ><a href="{{ url('core/groups')}}"><i class="lni-network"></i>  @lang('core.m_groups') </a> </li> --}}
						{{-- Dynamic menus Begin --}}
						@foreach ($sidebar as $menu)
						<?php $res = \App\Models\Restaurant::where('admin_status', 'waiting')->count(); ?>
						@if(\SiteHelpers::checkService($menu['menu_id']))
						@if($menu['module'] =='separator')
						{{-- <li class="header-menu"> <span> {{$menu['menu_name']}} </span></li> --}}
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
							href="{{ url('/').'/'.$menu['url'].'?'.time() }}" 
							@else
							href="{{ url($menu['module'].'?'.time())}}" 
							@endif
							@if(Request::segment(1) == $menu['module']) class="active" @endif >
							@if($menu['module'] == 'approval')
							@if($res > 0)
							<div class="approva" style="position: absolute;right: 8px;background-color: red;border-radius: 50px;width: 20px;height: 20px;">
							<span class="approvalCount" style="line-height: 20px; display: flex;justify-content: center;align-items: center;font-size: 10px;font-weight: 600;color: #fff;">{{$res}}</span>
							</div>
							@endif
							@endif
							<span class="iconic d-flex align-items-center"> <i class="{{$menu['menu_icons']}}"></i>
							{{ (isset($menu['menu_lang']['title'][session('lang')]) ? $menu['menu_lang']['title'][session('lang')] : $menu['menu_name']) }}
							</span>
							</a>
							@if(count($menu['childs']) > 0 )
							<div class="sidebar-submenu ">
								<ul>
									@foreach ($menu['childs'] as $menu2)
									@if(\SiteHelpers::checkService($menu2['menu_id']))
									<li>
										<a 
										@if(count($menu2['childs']) > 0 ) 
										href="javascript:void(0);" 
										@elseif($menu2['menu_type'] =='external')
										href="{{ url('/').'/'.$menu2['url'] }}" 
										@else
										href="{{ url($menu2['module'])}}" 
										@endif  

										@if(Request::segment(1) == $menu2['module']) class="active" @endif>
										<span class="iconic d-flex align-items-center">
											<i class="{{$menu2['menu_icons']}}"></i>
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
													href="{{ $menu3['url'].'?'.time() }}" 
													@else
													href="{{ url($menu3['module'].'?'.time())}}" 
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
									@endif
									@endforeach
								</ul>
							</div>
							@endif
							@endif
						</li>
						@endif
						@endforeach
						@if(Auth::user()->group_id == 1)
						<li><a href="{{ url('core/users/blast?'.time())}}"><span class="iconic d-flex align-items-center"><i class="lni-envelope"></i>  @lang('core.m_blastemail') </span></a></li> 
						@endif
						@if(Auth::user()->group_id == 1)
						{{--<li class="bottom logout"> 
							<a href="{{ url('notification?'.time()) }}"  code="menu-home"  >
								<span class="badge badge-pill badge-danger countNotif">0</span>
								<span class="iconic d-flex align-items-center"><i class="lni-alarm"></i> Notifications</span>  
							</a>
						</li>--}}
						@endif
					</ul>
			</div>
		</div>
	</nav>  
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.sidebar-compact ul li a ').mouseover(function(){                 
			$('.sidebar-compact ul li a').removeClass('active')
			$(this).addClass('active') 
			$('.sidebar-menu').hide();
			var id = $(this).attr('code');
			$('#'+id).show(); 
		}).mouseout(function() {
		})
		$('.sidebar-submenu ul li a.active').closest('li.sidebar-dropdown').addClass('active');
		$('li.sidebar-dropdown > a').click(function(){
			if($(this).parent().hasClass('active')){
				$(this).parent().removeClass('active');               
			}
			else{
				$('li.sidebar-dropdown').removeClass('active');
				$(this).parent().addClass('active');   
				$('.sidebar-submenu ul li.sub-dropdown').removeClass('select');              
			}
		})

		// let subList = document.querySelectorAll(".sidebar-submenu ul li div.sidebar-submenu");
		// console.log(subList);

		if($(".sidebar-submenu ul li div.sidebar-submenu").children().length > 0){
			$(".sidebar-submenu ul li div.sidebar-submenu").parent().addClass('sub-dropdown');
		}  

		$('.sidebar-submenu ul li.sub-dropdown a').click(function(){
			if($(this).parent().hasClass('select')){
				$(this).parent().removeClass('select');               
			}
			else{
				$(this).parent().addClass('select');                
			}
		}) 

		if($('li.sub-dropdown .sidebar-submenu ul > li > a').hasClass('active')){
			$('.sidebar-submenu li.sub-dropdown > a').addClass('active'); 
			$('.sidebar-submenu li.sub-dropdown').addClass('select');              
		}




		$('.confirmLogout').click(function() {
			Swal.fire({
				title: 'Logout ?',
				text: 'Logout from the application ',
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
	});
</script>