@extends('layouts.app')

@section('content')
<style type="text/css">
	ol#olAllContent{
		-webkit-column-count: 2;
		-moz-column-count: 2;
		column-count: 2;
		-webkit-column-width: 50%;
		-moz-column-width: 50%;
		column-width: 50%;
		-webkit-column-gap: 4em;
		-moz-column-gap: 4em;
		column-gap: 4em;
	}
</style>
<script type="text/javascript" src="{{ asset(CNF_THEME.'/js/plugins/jquery.nestable.js') }}"></script>

<input type="hidden" name="msgstatus" @if(session()->has('msgstatus')) value="{{session()->get('msgstatus')}}" @else value="" @endif>
<input type="hidden" name="messagetext" @if(session()->has('messagetext')) value="{{session()->get('messagetext')}}" @else value="" @endif>

<?php //dd(session()->all());?>

<div class="page-content">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-title">
			<h3> {!! Lang::get('core.t_menu') !!} <small>{!! Lang::get('core.t_menusmall') !!}</small></h3>
		</div>
	</div>
	{!! Form::open(array('url'=>'admin/giveservice?return=', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
	<input type="hidden" name="user_id" value="{{$user_id}}">
	@if(Session::has('message'))
	{{ Session::get('message') }}
	@endif	

	<div class="page-content-wrapper p-3">  
		<ul class="nav nav-tabs select_service" style="margin:10px 0;">
			<li class="active"><a href="javascript:void(0);"><i class="icon-paragraph-justify2 pr-2"></i>Select Service</a></li>
		</ul>
		<div class="">

			<div class="box ">

				<div id="list2" class="dd" style="min-height:350px;">
					<ol class="dd-list" id="olAllContent">
						@foreach ($menus as $mKey => $menu)
						@if($menu['active'] == '1' || $menu['active'] == 1 || in_array($menu['module'], $serviceException))
						@php
						$checked = '';
						if(!empty($service) && in_array($menu['menu_id'], $service) || empty($service)){
							$checked = 'checked';
						}
						@endphp
						<li data-id="{{$menu['menu_id']}}" class="dd-item dd3-item parent item">
							<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu['menu_name']}}
								<span class="pull-right">
									<input class="giveService" type="checkbox" name="services[]" data-place="parent" value="{{base64_encode($menu['menu_id'])}}" {{$checked}}>
								</span>
							</div>
							@if(count($menu['childs']) > 0)
							<ol class="dd-list child" style="">
								@foreach ($menu['childs'] as $menu2)
								@if($menu2['active'] == '1' || $menu2['active'] == 1)
								@php
								$checked = '';
								if(!empty($service) && in_array($menu2['menu_id'], $service) || empty($service)){
									$checked = 'checked';
								}
								@endphp
								<li data-id="{{$menu2['menu_id']}}" class="dd-item dd3-item">
									<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu2['menu_name']}}
										<span class="pull-right">
											<input class="giveService" type="checkbox" name="services[]" data-place="child" value="{{base64_encode($menu2['menu_id'])}}" {{$checked}}>
										</span>
									</div>
									@if(count($menu2['childs']) > 0)
									<ol class="dd-list sibiling" style="">
										@foreach($menu2['childs'] as $menu3)
										@if($menu3['active'] == '1' || $menu3['active'] == 1)
										@php
										$checked = '';
										if(!empty($service) && in_array($menu3['menu_id'], $service) || empty($service)){
											$checked = 'checked';
										}
										@endphp
										<li data-id="{{$menu3['menu_id']}}" class="dd-item dd3-item">
											<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{ $menu3['menu_name'] }}
												<span class="pull-right">
													<input class="giveService" type="checkbox" name="services[]" value="{{base64_encode($menu3['menu_id'])}}" data-place="sibiling" {{$checked}}>
												</span>
											</div>
										</li>	
										@endif
										@endforeach
									</ol>
									@endif
								</li>
								@endif
								@endforeach
							</ol>
							@endif
						</li>
						@endif
						@endforeach
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>
	<div class="form-group" style="margin-top: 15px;">
		<button type="submit" name="submit" class="btn btn-black btn-sm" ><i class="fa  fa-save "></i> {!! Lang::get('core.sb_save') !!}</button>
	</div>
	{!! Form::close() !!}
</div>
<script type="text/javascript">
	/*Check Box Checking Function*/

	$(document).on('click','.giveService',function(){
		var typeSeq = $(this).attr('data-place');
		if($(this).is(':checked')){
			if(typeSeq == 'parent'){
				var divEle = $(this).closest('li.parent');
				divEle.find('.giveService').prop('checked',true);
			}else if(typeSeq == 'child'){
				var divEle = $(this).closest('ol.child');
				divEle.find('.giveService').each(function(){
					var findAttr = $(this).attr('data-place');
					if(findAttr == 'sibiling'){
						$(this).prop('checked',true);
					}
				});
				divEle.closest('li.parent').find('input[name="services[]"][data-place="parent"]').prop('checked',true);
			}else if(typeSeq == 'sibiling'){
				var divEle = $(this).closest('ol.child');
				divEle.closest('input[name="services[]"][data-place="child"]').prop('checked',true);
				var divEleParent = $(this).closest('ol.child');
				divEleParent.closest('input[name="services[]"][data-place="parent"]').prop('checked',true);
			}
		}else{
			if(typeSeq == 'parent'){
				var divEle = $(this).closest('li.parent');
				divEle.find('.giveService').prop('checked',false);
			}else if(typeSeq == 'child'){
				var divEle = $(this).closest('ol.child');
				divEle.find('.giveService').each(function(){
					var findAttr = $(this).attr('data-place');
					if(findAttr == 'sibiling'){
						$(this).prop('checked',false);
					}
				});
				var ucheckParent = true;
				var mainParent = divEle.closest('li.parent');
				mainParent.find('input[name="services[]"]').each(function(){
					if($(this).is(':checked') && $(this).attr('data-place') != 'parent'){
						ucheckParent = false;
					}
				})
				if (ucheckParent) {
					mainParent.find('input[name="services[]"][data-place="parent"]').prop('checked',false);
				}
			}else if(typeSeq == 'sibiling'){
				var divEle = $(this).closest('ol.child');
				var ucheckChild = true;
				divEle.find('input[name="services[]"]').each(function(){
					if($(this).is(':checked') && $(this).attr('data-place') != 'parent' && $(this).attr('data-place') != 'child'){
						ucheckParent = false;
					}
				})
				if (ucheckChild) {
					divEle.closest('input[name="services[]"][data-place="child"]').prop('checked',false);
					var ucheckParent = true;
					var mainParent = divEle.closest('li.parent');
					mainParent.find('input[name="services[]"]').each(function(){
						if($(this).is(':checked') && $(this).attr('data-place') != 'parent'){
							ucheckParent = false;
						}
					})
					if (ucheckParent) {
						mainParent.find('input[name="services[]"][data-place="parent"]').prop('checked',false);
					}
				}
			}
		}
	});

	/*Check Box Checking Function End*/

	$(document).ready(function(){
		toastr.options={
			"closeButton":true,
			"positionClass":"toast-top-right",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"

		};
		var errorType = $('input[name="msgstatus"]').val();
		var errorText = $('input[name="messagetext"]').val();
		if (errorType == 'success' ) {
			toastr.success('Success ! <br/> '+errorText+' </b>');
		}else if(errorType =='error'){
			toastr.warning('Error ! <br/> '+errorText+' </b>');
		}
		// $('input[name="msgstatus"]').remove();
		// $('input[name="messagetext"]').remove();
	})
</script>
@stop 
