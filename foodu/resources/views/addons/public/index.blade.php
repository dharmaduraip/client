<div class="container" class="pt-3 pb-3">	
    <div class="row m-b-lg animated fadeInDown delayp1 text-center">
        <h3> {{ $pageTitle }} <small> {{ $pageNote }} </small></h3>
         
    </div>
</div>
	
<div class="table-container">    
    <table class="table table-striped table-bordered">
        <thead>
			<tr>
				<th> No </th>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')				
						<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
						
							<th>{{ $t['label'] }}</th>			
						@endif 
					@endif
				@endforeach
				<th>

				</th>
				
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
				<td> {{ ++$i }}</td>									
				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
					 	@if(SiteHelpers::filterColumn($limited ))
						 <td>					 
						 	{!! SiteHelpers::formatRows($row->{$field['field']},$field,$row) !!}						 
						 </td>
						@endif	
					 @endif					 
				 @endforeach
				 <td>
					<a href="?view={{ $row->id }}" oncl> <i class="fa fa-search"></i></a> 				
					
				</td>				 
                </tr>
				
            @endforeach
              
        </tbody>        

    </table>  
</div>  
<div class="text-center"> {!! $pagination->render() !!}</div>

