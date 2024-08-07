@extends('admin.layouts.master')
@section('title','Import User')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('User') }}
@endslot
@slot('menu1')
{{ __('User') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{ url('files/users.csv') }}" class="float-right btn btn-info-rgba mr-2"><i
        class="feather icon-arrow-down mr-2"></i>{{__('Download Example csv File')}}</a>
    <a href="{{ route('user.index') }}" class="float-right btn btn-primary-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
  </div>
</div>

@endslot
@endcomponent
<div class="contentbar">

<div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Import') }} {{ __('User') }}</h5>
        </div>
        <div class="card-body">
			<form action="{{ route('user.csvfileupload') }}" method="POST" enctype="multipart/form-data">
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
						<h5 class="box-title">{{ __('Import User') }}</h5>
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
							<td><b>{{__('First Name')}}</b> </td>
							<td>{{__('Required')}}, {{__('Letters Only')}}.</td>
                        </tr>
                        <tr>
							<td>2</td>
							<td><b>{{__('Last Name')}}</b> </td>
							<td>{{__('Required')}}, {{__('Letters Only')}}.</td>
						</tr>
						<tr>
							<td>3</td>
							<td><b>{{__('Phone Code')}}</b></td>
							<td>{{__('Required')}}, {{__('Numbers Only')}}, {{__('Ex:254')}}.</td>
						</tr>
						<tr>
							<td>4</td>
							<td><b>{{__('Mobile')}}</b></td>
							<td>{{__('Required')}}, {{__('Numbers Only')}}, {{__('maximum:15 Numbers')}}, {{__('Unique Mobile Number')}}.</td>
						</tr>
	
						<tr>
							<td>5</td>
							<td><b>{{__('Email')}}</b></td>
							<td>{{__('Required')}}, {{__('Unique Email')}}.</td>
						</tr>
	
						<tr>
							<td>6</td>
							<td><b>{{__('Address')}}</b></td>
							<td>{{__('Required')}}.</td>
						</tr>          
						<tr>
							<td>7</td>
							<td><b>{{__('Status')}}</b></td>
							<td>{{__('Required')}}, {{__('Ex: 0 (or) 1')}}.</td>
						</tr>
						<tr>
							<td>8</td>
							<td><b>{{__('Role')}}</b></td>
							<td>{{__('Required')}}, {{__('Ex: user (or) instructor (or) admin')}}.</td>
						</tr>
                        <tr>
							<td>9</td>
							<td><b>{{__('Password')}}</b></td>
							<td>{{__('Required')}}, {{__('Minimum 6 words')}}.</td>
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
