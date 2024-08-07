@if(Session::has('successMessage'))
    <div style="display: none;" class="toast alert alert-success alert-dismissible" role="alert">
    	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">×</span>
		<span class="sr-only">{{ __('Close') }}</span></button>
        <span class="title" style="font-weight: bold;">{{ __('Success') }}</span><br> 
		<span class="message">{{ Session::get('successMessage') }}</span>
    </div>
@endif

@if($errors->any())
	@foreach($errors->all() as $error)
	<div style="display: none;" class="toast alert alert-danger alert-dismissible" role="alert">
    	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">×</span>
		<span class="sr-only">{{ __('Close') }}</span></button>
        <span class="title" style="font-weight: bold;">{{ __('Error') }}</span><br> 
		<span class="message">{{ $error }}</span>
    </div>
    @endforeach
@endif