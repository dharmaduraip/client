@extends('admin.layouts.master')
@section('title','Import Institute')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Institute') }}
@endslot
@slot('menu1')
{{ __('Institute') }}
@endslot

@slot('button')
	<div class="col-md-4 col-lg-4">
		<div class="widgetbar">
			<a href="{{url('institute')}}" class="btn btn-primary-rgba"><i
				class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
		</div>
	</div>
@endslot

@endcomponent
<div class="contentbar">

<div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
			<div class="d-flex justify-content-between">
				<h5 class="box-tittle">{{ __('Import Institute') }}</h5>
				<a href="{{ url('files/institute.csv') }}" class="float-right btn btn-info-rgba"><i
					class="feather icon-arrow-down"></i> {{__('Download Example csv File')}}</a> 
			</div>
        </div>
        <div class="card-body">
			<form action="{{ route('institute.csvfileupload') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
		  
		  <div class="row">
			  <div class="form-group col-md-6">
			   <label for="file">{{__('Select csv File :')}}</label>
				<input required="" type="file" name="file" class="form-control">
				@if ($errors->has('file'))
				  <span class="invalid-feedback text-danger" role="alert">
					  <strong>{{ $errors->first('file') }}</strong>
				  </span>
			   @endif
			  <br>
			   <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                Submit</button>
			  </div>

			  
		  </div>

		  </form>
		</div>
		<div class="row">
		
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('Import Institute') }}</h5>
					</div>
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="" class="table table-striped table-bordered">
								<thead>
								<tr>
                                    <th>{{__('Column No')}}</th>
                                    <th>{{__('Column Name')}}</th>
                                    <th>{{__('Description')}}</th>
                        </tr>
					</thead>
	
					<tbody>
						<tr>
							<td>1</td>
							<td><b>{{__('Image')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of Image')}}</td>
	
							
						</tr>
	
						<tr>
							<td>2</td>
							<td><b>{{__('Address')}}</b> {{__('Required')}}</td>
							<td>{{__('Address')}}</td>
						</tr>
	
						<tr>
							<td>3</td>
							<td><b>{{__('Email')}}</b> {{__('Required')}}</td>
							<td>{{__('Email')}}</td>
						</tr>
	
						<tr>
							<td>4</td>
							<td><b>{{__('Mobile')}}</b> {{__('Required')}}</td>
							<td>{{__('Mobile')}}</td>
						</tr>
	
						<tr>
							<td>5</td>
							<td><b>{{__('Skills')}}</b> {{__('Required')}}</td>
							<td>{{__('Skills')}}</td>
						</tr>
	        			<tr>
							<td>6</td>
							<td><b>{{__('About')}}</b> {{__('Required')}}</td>
							<td>{{__('About')}}</td>
						</tr>
                        <tr>
							<td>7</td>
							<td><b>{{__('Status')}}</b> {{__('Required')}}</td>
							<td>{{__('Status')}}</td>
						</tr>
                        <tr>
							<td>8</td>
							<td><b>{{__('Verified')}}</b> {{__('Required')}}</td>
							<td>{{__('Verified')}}</td>
						</tr>
						<tr>
							<td>9</td>
							<td><b>{{__('Title')}}</b> {{__('Required')}}</td>
							<td>{{__('Title')}}</td>
						</tr>
						<tr>
							<td>10</td>
							<td><b>{{__('UserID')}}</b> {{__('Required')}}</td>
							<td>{{__('UserID')}}</td>
						</tr>
						<tr>
							<td>11</td>
							<td><b>{{__('Affilated')}}</b> {{__('Required')}}</td>
							<td>{{__('Affilated')}}</td>
						</tr>
                    </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</div>

</div>	


@endsection
