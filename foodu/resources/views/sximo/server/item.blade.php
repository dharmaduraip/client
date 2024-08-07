<div class="row">
	@foreach($rows as $row)
		<div class="col-md-3 col-xs-6">
			<div class="spanel item">
				<div class="panel-title">
				<h4> {{ $row->Title }} </h4>
				</div>
				<div class="panel-body">
					<div class="img">
						<img src="{{ $row->Preview }}" class="img-responsive">
					</div>
					<div class="text-center">
					<h5>
					@if($row->PriceReguler >=1)
					$ {{ $row->PriceReguler }}
					@else
					Free
					@endif   
					</h5>            
					</div>	

				</div>
				<div class="panel-footer">
					<a href="http://sximo5.net/product/{{ $row->Slug }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-eye"></i> Detail </a>
					<a href="javascript://ajax" 
					onclick="SximoModal('{{ url("sximo/server/install?id=".$row->ProductID."&t=".$row->ScriptType) }}' ,'Download & Install' ); return false;" class="btn btn-sm btn-primary"><i class="fa fa-download-cloud"></i> Download &  Install </a>
				</div>

			</div>
		</div>	
	@endforeach
</div>
<div class="row">
	<div class="col-md-4 text-left">
		@if( $control->prev_page_url !='')
			<a href="javascript://ajax" onclick="page('{{ ($control->current_page - 1) }}')"  class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Previous </a>
		@endif
	</div>

	<div class="col-md-4 text-center"> Total <b> {{ $control->total }} </b></div>
	<div class="col-md-4 text-right">
		@if( $control->next_page_url !='')
			<a href="javascript://ajax" onclick="page('{{ ($control->current_page + 1) }}')" class="btn btn-sm btn-default"><i class="fa fa-arrow-right"></i> Next </a>
		@endif
	</div>		
</div>
<style type="text/css">
	.spanel.item {
		
		margin-bottom: 20px; 
	}
	.spanel.item .panel-body{
		height: 160px;
		padding: 0;
		
	}
	.spanel.item .panel-body h3 {
		padding: 5px 0;
		margin: 0;font-weight: 700;
	}
	.spanel.item .panel-body .img{
		height: 120px;
		overflow: hidden;
	}
</style>