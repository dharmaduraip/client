@extends('layouts.app')

@section('content')
<?php usort($tableGrid, "SiteHelpers::_sort") ?>
<div class="page-header"><h2>  {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav">
<div class="row m-0">
				<div class="col-md-8"> 	
					@if($access['is_add'] ==1)
					<a href="{{ url('cms/posts/create?return='.$return) }}" class="btn btn-default btn-sm"  
						title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
					@endif

					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-menu5"></i> Bulk Action </button>
				        <ul class="dropdown-menu">
				         @if($access['is_excel'] ==1)
							<li><a href="{{ url( $pageModule .'/export?do=excel&return='.$return) }}" class="nav-link"> Export CSV </a></li>	
						@endif
						@if($access['is_add'] ==1)
							<li class="nav-item"><a class="nav-link" href="{{ url($pageModule .'/import?return='.$return) }}" onclick="SximoModal(this.href, 'Import CSV'); return false;"> Import CSV</a></li>
							<li class="nav-item"><a class="nav-link" href="javascript://ajax" class=" copy " title="Copy" > Copy selected</a></li>
						@endif	
							<li class="nav-item"><a class="nav-link" href="{{ url($pageModule) }}"  > Clear Search </a></li>
				          	<li role="separator" class="divider"></li>
				         @if($access['is_remove'] ==1)
							 <li class="nav-item"><a class="nav-link" href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ __('core.btn_remove') }}">
							Remove Selected </a></li>
						@endif 
				          
				        </ul>
				     </div>    
				       
				</div>
				<div class="col-md-4 text-right">
					<div class="input-group pull-right">
					      <div class="input-group-prepend">
					        <button type="button" class="btn btn-default btn-sm " 
					        onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
					      </div><!-- /btn-group -->
					      <input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
					    </div>
				</div>    
			</div>
</div>
	<div class="p-3">
		<div class="pt-2 px-2">
			<ul class="nav nav-tabs form-tab" >
			  <li class="nav-item"><a href="#info" data-toggle="tab" class="nav-link active"> All Posts </a></li>
			  <li class="nav-item"><a href="#config" data-toggle="tab" class="nav-link"> Post Setting </a></li>
			</ul>
		</div>	

		<div class="tab-content" style="margin-top: 0; padding: 0">
		  	<div class="tab-pane active" id="info" style="padding: 0;">


				<!-- Toolbar Top -->
									
				<!-- End Toolbar Top -->

				<!-- Table Grid -->
				<div class="table-container m-0">
	 				{!! Form::open(array('url'=>'cms/posts?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				
				    <table class="table table-hover " id="{{ $pageModule }}Table">
				        <thead>
							<tr>
								<th style="width: 3% !important;" class="number"> No </th>
								<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
								<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
								
								@foreach ($tableGrid as $t)
									@if($t['view'] =='1')				
										<?php $limited = isset($t['limited']) ? $t['limited'] :''; 
										if(SiteHelpers::filterColumn($limited ))
										{
											$addClass='class="tbl-sorting" ';
											if($insort ==$t['field'])
											{
												$dir_order = ($inorder =='desc' ? 'sort-desc' : 'sort-asc'); 
												$addClass='class="tbl-sorting '.$dir_order.'" ';
											}
											echo '<th align="'.$t['align'].'" '.$addClass.' width="'.$t['width'].'">'.\SiteHelpers::activeLang($t['label'],(isset($t['language'])? $t['language'] : array())).'</th>';				
										} 
										?>
									@endif
								@endforeach
								
							  </tr>
				        </thead>

				        <tbody>        						
				            @foreach ($rowData as $row)
				                <tr>
									<td > {{ ++$i }} </td>
									<td ><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->pageID }}" />  </td>
									<td>

									 	<div class="dropdown">
										  <button class="btn  dropdown-toggle" type="button" data-toggle="dropdown"> {{ __('core.btn_action') }} </button>
										  <ul class="dropdown-menu">
										 	@if($access['is_detail'] ==1)
											<li class="nav-item"><a href="{{ url('posts/read/'.$row->alias)}}" target="_blank" class="tips nav-link" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }} </a></li>
											@endif
											@if($access['is_edit'] ==1)
											<li class="nav-item"><a  href="{{ url('cms/posts/'.$row->pageID.'/edit?return='.$return) }}" class="tips nav-link" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} </a></li>
											@endif
											<li class="divider" role="separator"></li>
											@if($access['is_remove'] ==1)
												 <li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="tips nav-link" title="{{ __('core.btn_remove') }}">
												Remove Selected </a></li>
											@endif 
										  </ul>
										</div>

									</td>														
								 @foreach ($tableGrid as $field)
									 @if($field['view'] =='1')
									 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
									 	@if(SiteHelpers::filterColumn($limited ))
									 	 <?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
										 <td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
										 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
										 </td>
										@endif	
									 @endif					 
								 @endforeach			 
				                </tr>
								
				            @endforeach 
				        </tbody>
				    </table>
					<input type="hidden" name="action_task" value="" />
				
					{!! Form::close() !!}
				
				</div>
				@include('footer')
				<!-- End Table Grid -->

		  	</div>

			<div class="tab-pane" id="config" style="padding: 20px ;">

				<fieldset class="p-5">
					<legend> Post Configuration </legend>
					

					{!! Form::open(array('url'=>'cms/posts/config', 'class'=>'form-horizontal' ,'id' =>'' )) !!}
					 <div class="form-group row  " >
							<label class="col-md-4" > Allow Comment system    </label>
							<div class="col-md-8">									
						  		<input type="checkbox" name="commsys" class="checkbox minimal-green" value="1"
						  		@if($conpost['commsys'] ==1) checked @endif
						  		 />	
						  	</div>					
					  </div> 
					 <div class="form-group row  " >
							<label class="col-md-4" > Display Image in every post(s)   </label>	
							<div class="col-md-8">								
						  		<input type="checkbox" name="commimage" class="checkbox minimal-green" value="1"
						  		@if($conpost['commimage'] ==1) checked @endif
						  		 />
						  	</div>						
					  </div> 
					 <div class="form-group row  " >
							<label class="col-md-4" > Display Latest post(s)   </label>	
							<div class="col-md-8">								
						  		<input type="checkbox" name="commlatest" class="checkbox minimal-green" value="1"
						  		@if($conpost['commlatest'] ==1) checked @endif
						  		 />
						  	</div>						
					  </div>

					 <div class="form-group row  " >
							<label class="col-md-4" > Display Popular post(s)   </label>	
							<div class="col-md-8">								
						  		<input type="checkbox" name="commpopular" class="checkbox minimal-green" value="1" 
						  		@if($conpost['commpopular'] ==1) checked @endif
						  		/>
						  	</div>						
					  </div>				  

					 <div class="form-group row  " >
							<label class="col-md-4" > Allow Share post(s) :    </label>	
							<div class="col-md-8">								
						  		<input type="checkbox" name="commshare" class="checkbox minimal-green" value="1" 
						  		@if($conpost['commshare'] ==1) checked @endif
						  		/>
						  	</div>							
					  </div> 
					 <div class="form-group row  " >
							<label class="col-md-4" > Share post(s) API KEY :    </label>	
							<div class="col-md-8">								
						  		<input type="text" name="commshareapi" class="form-control" value="{{ $conpost['commshareapi'] }}"  />

						  		Get your own API : <a href="http://www.sharethis.com/get-sharing-tools/" target="_blank"> http://www.sharethis.com/get-sharing-tools/ </a>
						  	</div>							
					  </div> 	  	  	

					 <div class="form-group row  " >
							<label class="col-md-4" > Display post(s) per/page  </label>
							<div class="col-md-8">									
						  		<input type="text" name="commperpage" class="form-control" style="width: 50px;" value="{{ $conpost['commperpage'] }}" />
						  	</div>							
					  </div> 
					 <div class="form-group row  " >
							<label class="col-md-4" >   </label>
							<div class="col-md-8">									
						  		<button type="submit" class="btn btn-primary"> Save Configuration </button>
						  	</div>							
					  </div> 

					  {!! Form::close() !!}
				</fieldset> 

			</div>
		</div> 
	</div> 
</div>	
<style type="text/css">
	.table-container {
		    height: calc(100vh - 185px);
	}
</style>

@stop