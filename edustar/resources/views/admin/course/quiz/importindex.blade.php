@extends('admin.layouts.master')
@section('title','Import Question')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Question') }}
@endslot
@slot('menu1')
{{ __('Question') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{ url('files/QuizQuestions.xlsx') }}" class="float-right btn btn-primary-rgba mr-2"><i
        class="feather icon-arrow-down mr-2"></i>{{ __('Download Example xls/csv File') }}</a> </div>
</div>

@endslot
@endcomponent
<div class="contentbar">

<div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Import') }} {{ __('Question') }}</h5>
        </div>
        <div class="card-body">
			<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
		  
		  <div class="row">
			  <div class="form-group col-md-6">
			   <label for="file">{{ __('Select xls/csv File') }} :</label>
				<input required="" type="file" name="file" class="form-control">
				@if ($errors->has('file'))
				  <span class="invalid-feedback text-danger" role="alert">
					  <strong>{{ $errors->first('file') }}</strong>
				  </span>
			   @endif
			  <br>
			   <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __('Submit') }}</button>
			  </div>

			  
		  </div>

		  </form>
		</div>
		<div class="row">
		
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('Import Question') }}</h5>
					</div>
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped table-bordered">
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
							<td><b>{{__('Course')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of course')}}</td>
	
							
						</tr>
	
						<tr>
							<td>2</td>
							<td><b>{{__('QuizTopic')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of Quiz Topic')}}</td>
						</tr>
	
						<tr>
							<td>3</td>
							<td><b>{{__('Question')}}</b> {{__('Required')}}</td>
							<td>{{__('Name of Question')}}</td>
						</tr>
	
						<tr>
							<td>4</td>
							<td><b>{{__('A')}}</b> {{__('Required')}}</td>
							<td>{{__('Option A.')}}</td>
						</tr>
	
						<tr>
							<td>5</td>
							<td><b>{{__('B')}}</b> {{__('Required')}}</td>
							<td>{{__('Option B.')}}</td>
						</tr>
	
						<tr>
							<td>6</td>
							<td><b>{{__('C')}}</b> {{__('Optional')}}</td>
							<td>{{__('Option C.')}}</td>
						</tr>
	
						<tr>
							<td>7</td>
							<td><b>{{__('D')}}</b> {{__('Optional')}}</td>
							<td>{{__('Option D.')}}</td>
						</tr>

						<tr>
							<td>8</td>
							<td><b>{{__('E')}}</b> {{__('Optional')}}</td>
							<td>{{__('Option E.')}}</td>
						</tr>
	
						<tr>
							<td>9</td>
							<td><b>{{__('Correct Answer')}}</b> {{__('Required')}}</td>
							<td>Question correct answer -> options (a,b,c,d,e)</td>
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
