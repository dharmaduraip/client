@extends('admin.layouts.master')
@section('title', 'Meeting Recordings - Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Meeting Recordings') }}
@endslot
@slot('menu1')
   {{ __('Meetings') }}
@endslot
@slot('menu2')
   {{ __('Meeting Record') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
	  @can('meetings.meeting-recordings.create')
			<a  href="{{url('meeting-recordings/create')}}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add Meeting Record")}}</a>
      @endcan
  </div>                        
</div>
@endslot
@endcomponent
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Meeting Record')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
							<th>
								#
							</th>
							
							<th>
								{{ __('Meeting') }} {{ __('Name') }}  
							</th>
							<th>
								{{ __('Edit') }} 
							</th>
							<th>
								{{ __('Meeting') }} {{ __('URL') }} 
							</th>
							
						</thead>
			
						<tbody>
							<?php $i=0;?>
			
							@foreach($recordings as $recording)
							<?php $i++;?>
								<tr>
									<td><?php echo $i;?></td>
									<td><b>{{ $recording->title }}</b></td>
									<td>
										<a   href="{{url('meeting-recordings/'.$recording->id)}}" class="btn btn-primary-rgba"><i class="feather icon-edit-2"></i></a>
										
										
									  </td>
									
									<td>
			
										 <a href="{{ $recording->url }}" target="_blank" class="btn btn-primary-rgba"> {{ __('View') }}  {{ __('Recording') }}  </a>
									</td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- End col -->
</div>
<!-- End row -->
</div>        
@endsection
