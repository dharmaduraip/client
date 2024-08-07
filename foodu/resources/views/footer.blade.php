<div class="toolbar-nav">
	<div class="row">
		<div class="col-sm-4">
			<div class="" style=" padding: 15px 0 0">
				@lang('core.grid_displaying') 
				<b> {{ ($pagination->currentpage()-1) * $pagination->perpage()+1 }} </b>
				@if($pagination->currentpage()*$pagination->perpage()>$pagination->total())
				@lang('core.grid_to')
				<b>  {{$pagination->total()}} </b>
				@else
				@lang('core.grid_to')
				<b>  {{$pagination->currentpage()*$pagination->perpage()}} </b>
				@endif
				@lang('core.grid_of')
				<b>  {{$pagination->total()}} </b>
				@lang('core.grid_entries')
			</div>
		</div>
		<div class="col-sm-8 text-right">
			{!! $pagination->appends($pager)->render() !!}
		</div>
	</div>
</div>
	
	