@extends('layouts.app')

@section('content')
<div class="page-header"><h2>  {{ $pageTitle }} <small> {{ $pageNote }} </small>  </h2></div>
<div class="toolbar-nav">
    <div class="btn-group">
    	<a href="{{ url('sximo/menu/index/0?pos=top')}}" class="btn  btn-sm"> <i class="fa fa-plus"></i> new  </a>
        <a href="{{ url('sximo/menu?pos=top')}}" class="btn  btn-sm"> <i class="fa fa-bars"></i> {{ __('core.tab_topmenu') }}  </a>
        <a href="{{  url('sximo/menu?pos=sidebar') }}" class="btn  btn-sm post_url"> <i class="fa fa-bars"></i> {{ __('core.tab_sidemenu') }} </a>
    </div>
</div>

<script type="text/javascript" src="{{ asset('sximo5/js/plugins/jquery.nestable.js') }}"></script>

<div class="p-5">

			<div class="sbox-content">

				<div class="row">	
				
				
				<div class="col-md-5" >
					<fieldset style="min-height: 400px;">
						<legend> Menu navigation</legend>

						<div id="list2" class="dd myadmin-dd-empty " style="min-height:350px;">
				            <ol class="dd-list">
							@foreach ($menus as $menu)
								  <li data-id="{{$menu['menu_id']}}" class="dd-item dd3-item">
									<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu['menu_name']}}
										<span class="pull-right">
										<a href="{{ url('sximo/menu/index/'.$menu['menu_id'].'?pos='.$active)}}"><i class="fa fa-pencil"></i></a></span>
									</div>
									@if(count($menu['childs']) > 0)
										<ol class="dd-list" style="">
											@foreach ($menu['childs'] as $menu2)
											 <li data-id="{{$menu2['menu_id']}}" class="dd-item dd3-item">
												<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu2['menu_name']}}
													<span class="pull-right">
													<a href="{{ url('sximo/menu/index/'.$menu2['menu_id'].'?pos='.$active)}}"><i class="fa fa-pencil"></i></a></span>
												</div>
												@if(count($menu2['childs']) > 0)
												<ol class="dd-list" style="">
													@foreach($menu2['childs'] as $menu3)
													 	<li data-id="{{$menu3['menu_id']}}" class="dd-item dd3-item">
															<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{ $menu3['menu_name'] }}
																<span class="pull-right">
																<a href="{{ url('sximo/menu/index/'.$menu3['menu_id'].'?pos='.$active)}}"><i class="fa fa-pencil"></i></a>
																</span>
															</div>
														</li>	
													@endforeach
												</ol>
												@endif
											</li>							
											@endforeach
										</ol>
									@endif
								</li>
							@endforeach			  
				              </ol>
				            </div>


							 {!! Form::open(array('url'=>'sximo/menu/saveorder', 'class'=>'form-horizontal','files' => true)) !!}	
								<input type="hidden" name="reorder" id="reorder" value="" />
									 <div class="infobox infobox-danger ">
									 <p> {{ Lang::get('core.t_tipsnote') }}	</p>
									</div>			
							
								<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_reorder') }} </button>	
							 {!! Form::close() !!}	


					</fieldset>
				</div>	
				
				<div class="col-md-7" >
					<fieldset style="min-height: 400px;">
						<legend> Create / Update</legend>
		 			{!! Form::open(array('url'=>'sximo/menu/save', 'class'=>'form-horizontal','files' => true  , 'parsley-validate'=>'','novalidate'=>' ')) !!}
						

							
							<input type="hidden" name="menu_id" id="menu_id" value="{{ $row['menu_id'] }}" />
							<input type="hidden" name="parent_id" id="parent_id" value="{{ $row['parent_id'] }}" />	
											
						 
						  <div class="form-group row  " >
							<label for="ipt" class=" control-label col-md-4 text-right">{{ Lang::get('core.fr_mtitle') }}  </label>
							<div class="col-md-8">
							  {!! Form::text('menu_name', $row['menu_name'],array('class'=>'form-control-sm input-sm ', 'placeholder'=>'','required'=>'true')) !!} 
							  @if($sximoconfig['cnf_multilang'] ==1)
							    <?php $lang = SiteHelpers::langOption();
								foreach($lang as $l) { 
									if($l['folder'] !='en') {
									?>
										<div class="input-group input-group-sm" style="margin:1px 0 !important;">
										 <input name="language_title[<?php echo $l['folder'];?>]" type="text"   class="form-control-sm" placeholder="Title for <?php echo $l['name'];?>"
										 value="<?php echo (isset($menu_lang['title'][$l['folder']]) ? $menu_lang['title'][$l['folder']] : '');?>" />
										<span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
									   </div> 								
									<?php
									}
								
								}
							   ?>
							  @endif				  
							  
							 </div> 
						  </div> 

						  <div class="form-group row   " >
							<label for="ipt" class=" control-label col-md-4 text-right"> {{ Lang::get('core.fr_mtype') }}  </label> 
							<div class="col-md-8 menutype">
							
								
							<input type="radio" name="menu_type" value="internal" class="minimal-green"   required="true" 
							@if($row['menu_type']=='internal' || $row['menu_type']=='') checked="checked" @endif />
							
							Internal
							
							<input type="radio" name="menu_type" value="external"  class="minimal-green" required="true" 

							@if($row['menu_type']=='external' ) checked="checked" @endif  /> External 
							  
							 </div> 
						  </div> 

						  			  					
						  <div class="form-group row  ext-link" >
							<label for="ipt" class=" control-label col-md-4 text-right"> Url  </label>
							<div class="col-md-8">
							   {!! Form::text('url', $row['url'],array('class'=>'form-control-sm input-sm', 'placeholder'=>' Type External Url')) !!} 
							 </div> 
						  </div> 	


										  					
						  <div class="form-group row  int-link" >
							<label for="ipt" class=" control-label col-md-4 text-right"> Controller / Route  </label>
							<div class="col-md-8">
							 		
							
							<select name='module' rows='5' id='module'  style="width:100%" 
									class='form-control-sm input-sm	'    >

									<option value=""> -- Select Module or Page -- </option>
									<option value="separator" @if($row['module']== 'separator' ) selected="selected" @endif> Separator Menu </option>
									<optgroup label="Module ">
									@foreach($modules as $mod)
										<option value="{{ $mod->module_name}}"
										@if($row['module']== $mod->module_name ) selected="selected" @endif
										>{{ $mod->module_title}}</option>
									@endforeach
									</optgroup>
									<optgroup label="Page CMS ">
									@foreach($pages as $page)
										<option value="{{ $page->alias}}"
										@if($row['module']== $page->alias ) selected="selected" @endif
										>Page : {{ $page->title}}</option>
									@endforeach	
									</optgroup>						
							</select> 
							 </div> 

						  </div> 										
							

						  <div class="form-group row  " >
							<label for="ipt" class=" control-label col-md-4 text-right"> {{ Lang::get('core.fr_mposition') }}  </label>
							<div class="col-md-8">
								<div class="">
									<input type="radio" name="position"  value="top" required  class="minimal-green" 
									@if($row['position']=='top' ) checked="checked" @endif /> {{ Lang::get('core.tab_topmenu') }} 
								</div>
								<div class="">	
									<input type="radio" name="position"  value="sidebar"  required class="minimal-green" 
									@if($row['position']=='sidebar' ) checked="checked" @endif  /> {{ Lang::get('core.tab_sidemenu') }} 
								</div>	
							 </div> 
						  </div> 	 				
						  <div class="form-group row  " >
							<label for="ipt" class=" control-label col-md-4 text-right">{{ Lang::get('core.fr_miconclass') }}  </label>
							<div class="col-md-8">
							  {!! Form::text('menu_icons', $row['menu_icons'],array('class'=>'form-control-sm input-sm', 'placeholder'=>'')) !!}
							  <p> {{ Lang::get('core.fr_mexample') }} : <span class="label label-info"> fa fa-desktop </span> </p>
							  <p> View Icon Codes : 
							  <a href="{{ url('sximo/menu/icon')}}" onclick="SximoModal(this.href,'Select Icon'); return false;"> Browse Icons  </a>  
							 </div> 
						  </div> 					
						  <div class="form-group row  " >
							<label for="ipt" class=" control-label col-md-4 text-right"> {{ Lang::get('core.fr_mactive') }}  </label>
							<div class="col-md-8 ">
								<div class="">
									<input type="radio" name="active"  value="1"  class="minimal-green" 
									@if($row['active']=='1' ) checked="checked" @endif /> <label>{{ Lang::get('core.fr_mactive') }} </label>
								</div>
								<div class="">
									<input type="radio" name="active" value="0"  class="minimal-green" 
									@if($row['active']=='0' ) checked="checked" @endif  /> <label>{{ Lang::get('core.fr_minactive') }} </label>
								</div>	
												
							 
							 </div> 
						  </div> 

					  <div class="form-group row">
						<label for="ipt" class=" control-label col-md-4 text-right">{{ Lang::get('core.fr_maccess') }}  <code>*</code></label>
						<div class="col-md-8">
								<?php 
							$pers = json_decode($row['access_data'],true);
							foreach($groups as $group) {
								$checked = '';
								if(isset($pers[$group->group_id]) && $pers[$group->group_id]=='1')
								{
									$checked= ' checked="checked"';
								}						
									?>		
						  <div class="">
						  <input type="checkbox" name="groups[<?php echo $group->group_id;?>]" value="<?php echo $group->group_id;?>" <?php echo $checked;?> class="minimal-green"  />   
						  	<label><?php echo $group->name;?>  </label>
						  </div>
					
						  <?php } ?>
								 </div> 
					  </div> 

					  <div class="form-group row  " >
					  	<label for="ipt" class=" control-label col-md-4 text-right">{{ Lang::get('core.fr_mpublic') }}   </label>
					  	<div class="col-md-8">
					  		<div class="">
					  			<input  type='checkbox' name='allow_guest'  class="minimal-green"  
					  			@if($row['allow_guest'] ==1 ) checked  @endif	
					  			value="1"	/> <label>  Yes  </lable>
					  			</div>   
					  		</div>
					  	</div>						
					  	<!-- menu creation for show menus particular users  -->
					  	@if(isset($row) && $row['menu_id'] != '')
					  	<div class="form-group row">
					  		<label for="ipt" class=" control-label col-md-4 text-right">Menu Access  <code>*</code></label>
					  		<div class="col-md-8">
					  			<?php 
					  			$check = '';
					  			$check1 = '';
					  			if($row['p_active']=='1')
					  			{
					  				$check= ' checked="checked"';
					  			}	
					  			if($row['d_active']== '1'){
					  				$check1= ' checked="checked"';
					  			}					
					  			?>		
					  			<div class="">
					  				<input type="checkbox" name="p_active" class = "activestatus" id="p_active" value="<?php echo $row['p_active']; ?>" <?php echo $check; ?>  />  partner active <br>
					  				<input type="checkbox" name="d_active" class = "activestatus" id="d_active" value="<?php echo $row['d_active']; ?>" <?php echo $check1;?> />
					  				<label>boy active  </label>
					  			</div>
					  		</div> 
					  	</div> 
					  	@endif						  
					  	<div class="form-group row">
					  		<label class="col-sm-4 text-right">&nbsp;</label>
					  		<div class="col-sm-8">	
					  			<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_submit') }}  </button>
					  			@if($row['menu_id'] !='')
					  			<button type="button"onclick="SximoConfirmDelete('{{ url('sximo/menu/destroy/'.$row['menu_id'].'?pos='.$active)}}')" class="btn btn-danger ">  Delete </button>
					  			@endif	
					  		</div>	  
					  	</div> 
				</div>	  
				 
				 {!! Form::close() !!}	

	 		
				</fieldset>				
			</div>	
			
	
</div>
                               
<script>
$(document).ready(function(){
	$('.dd').nestable();
    update_out('#list2',"#reorder");
    
    $('#list2').on('change', function() {
		var out = $('#list2').nestable('serialize');
		$('#reorder').val(JSON.stringify(out));	  

    });
	$('.ext-link').hide(); 

	$('.menutype input:radio').on('ifClicked', function() {
	 	 val = $(this).val();
  			mType(val);
	  
	});
	
	mType('<?php echo $row['menu_type'];?>'); 
	
			
});	

function mType( val )
{
		if(val == 'external') {
			$('.ext-link').show(); 
			$('.int-link').hide();
		} else {
			$('.ext-link').hide(); 
			$('.int-link').show();
		}	
}

	
function update_out(selector, sel2){
	
	var out = $(selector).nestable('serialize');
	$(sel2).val(JSON.stringify(out));

}

$('input.activestatus').on('change', function() {

	    if ($(this).is(":checked")) {
	    	$(this).val('1');
	    } else {
	    	$(this).val('0');
	    }

});
</script>	  
@endsection