@extends('layouts.app')
@section('content')
<input type="hidden" name="min_val" id="delicharge" value="<?php if(!empty($sitedetails)){ echo $sitedetails->minimum_delivery_charge; } ?>">
<div class="page-content edit-fooditem">
	<!-- Page header -->
	<div class="page-header flex-wrap justify-content-between">
		<div class="page-title my-sm-0 my-1">
			<h3> Pick product <small>Choose from master list</small></h3>
		</div>
		<ul class="breadcrumb bg-trans mx-sm-0 mx-0 my-sm-0 my-1 p-0">
			<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}">{!! Lang::get('core.home') !!}</a></li>
			<li class="breadcrumb-item"><a href="{{ URL::to('fooditems/resdatas/'.$res_id) }}">Pick product</a></li>
			<li class="breadcrumb-item active">{!! Lang::get('core.addedit') !!} </li>
		</ul>
	</div>
	<div class="page-content-wrapper head-table p-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
		<div class="sbox animated fadeInRight">
			<div class="sbox-title">
				<h4> <i class="fa fa-table"></i> </h4>
			</div>
			<div class="sbox-content"> 	
				{!! Form::open(array('url'=>'fooditems/insertproducts', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=>'Addfood')) !!}
					<div class="col-md-12">
						<fieldset>  
							<input type="hidden" name="res_id" class="res_id" value="{{ $res_id }}">
							<legend> {!! trans('core.abs_food_item_details') !!} </legend>
							<div class="form-group" > 
								<label for="Category" class=" control-label col-md-4 text-left"> Choose Category <span class="asterix"> * </span></label>
								<div class="col-md-6">
									<select name='category' rows='5' id='category' class='select2 ' required></select>
								</div>
							</div>
							<div class="form-group" id="procutsDiv" style="display: none;" > 
								<label for="Product" class=" control-label col-md-4 text-left"> Add Products <span class="asterix"> * </span></label>
								<div class="col-md-6">
									<select name='products[]' rows='5' id='products' class='' multiple required></select>
								</div>
							</div>
						</fieldset>
					</div>
					<div style="clear:both"></div>	
					<div class="form-group">
						<label class="col-sm-4 text-right">&nbsp;</label>
						<div class="col-sm-12 text-center">	
							<button type="submit" name="apply" class="btn btn-green btn-sm" ><i class="fa  fa-check-circle"></i> {!! Lang::get('core.sb_apply') !!}</button>
							<button type="submit" name="submit" class="btn btn-black btn-sm" ><i class="fa  fa-save "></i> {!! Lang::get('core.sb_save') !!}</button>
							<button type="button" onclick="location.href='{{ URL::to('fooditems/resdatas/'.$res_id) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
						</div>	  
					</div> 
				{!! Form::close() !!}
			</div>
		</div>		 
	</div>	
</div>
<script type="text/javascript">
	$("#category").jCombo("<?php echo URL::to(''); ?>/fooditems/comboselect?filter=abserve_food_categories:id:cat_name:type:=:'category'",{selected_value : ''});
	$(document).ready(function(){
		$("#products").select2({width:"500px"});
	})
	$('#category').change(function(){
		$('#procutsDiv').hide();
		if ($(this).val() != '') {
			$.ajax({
				url		: "<?php echo URL::to(''); ?>/fooditems/listproducst",
				type	: "POST",
				data	: { 'cat_id':$(this).val() },
				dataType: "json",
				success: function(data) {
					$('#procutsDiv').show();
					$("#products").select2("destroy");
					$("#products").html(data.html);
					$("#products").select2({width:"500px"});
				}
			});
		}
	});
</script>		 
@stop