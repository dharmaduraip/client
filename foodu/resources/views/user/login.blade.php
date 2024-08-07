@extends('layouts.login')

@section('content')
	
		<div class="ajaxLoading"></div>
	    
		<div class="form-signin">
			
			<p class="message alert alert-danger " style="display:none;"></p>	
	 
		    	@if(Session::has('status'))
		    		@if(session('status') =='success')
		    			<p class="alert alert-success">
							{!! Session::get('message') !!}
						</p>
					@else
						<p class="alert alert-danger">
							{!! Session::get('message') !!}
						</p>
					@endif		
				@endif

			<ul class="parsley-error-list">
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>		
	

		
		<div  class="authentication-form">




	 		{!! Form::open(array('url'=>'user/signin', 'class'=>'','id'=>'LoginAjax' , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	 		<div class="form-group">
                <input type="email" id="inputEmail" class="form-control"  name="email"  placeholder="{{ __('core.email') }}" required autofocus>
                <i class="fa fa-user"></i>
            </div>
            <div class="form-group">
                <input type="password" id="inputPassword"  name="password" class="form-control" placeholder="{{ __('core.password') }}" required>
                <i class="fa fa-key"></i>
            </div>
	      	<div class="checkbox pt-3 mb-3">
		        <label>
		          <input type="checkbox" class="minimal-green" name="remember" value="1"  style="display: inline-block;" /> Remember me
		        </label>
		      </div>


			@if(config('sximo.cnf_recaptcha') =='true') 
			<div class="form-group has-feedback  animated fadeInLeft delayp1">
				<label class="text-left"> Are u human ? </label>	
				<div class="g-recaptcha" data-sitekey="6Le2bjQUAAAAABascn2t0WsRjZbmL6EnxFJUU1H_"></div>				
				<div class="clr"></div>
			</div>	
		 	@endif	
		 	<div class="text-center">
			 	<button class="btn btn-lg btn-primary" type="submit">Sign in</button> 	
			</div> 	




			<div class=" pt-2 pb-2 " >					       
					<p class="text-center ">						
						<a href="javascript:void(0)" class="forgot"> @lang('core.forgotpassword') ? </a> | 
						<a href="{{ url('user/register')}}"> @lang('core.registernew') </a>
					</p>					
			</div>	
			
			<div class="animated fadeInUp delayp1">
				<div class="form-group  ">
					@if($socialize['google']['client_id'] !='' || $socialize['twitter']['client_id'] !='' || $socialize['facebook'] ['client_id'] !='') 
					
					<p class="text-muted text-center"><b> {{ Lang::get('core.loginsocial') }} </b>	  </p>
					
					<div style="padding:15px 0; text-align: center;">
						@if($socialize['facebook']['client_id'] !='') 
						<a href="{{ url('user/socialize/facebook')}}" class="btn btn-circle btn-success"><i class="fa fa-facebook"></i> </a>
						@endif
						@if($socialize['google']['client_id'] !='') 
						<a href="{{ url('user/socialize/google')}}" class="btn btn-circle btn-danger"><i class="fa fa-google"></i> </a>
						@endif
						@if($socialize['twitter']['client_id'] !='') 
						<a href="{{ url('user/socialize/twitter')}}" class="btn btn-circle  btn-info"><i class="fa fa-twitter"></i> </a>
						@endif
					</div>
					@endif
				</div>	

			  <p style="padding:5px 0" class="text-center">
			  <a href="{{ url('')}}"> {{ Lang::get('core.backtosite') }} </a>  
		   		</p>
		   	</div>	
		   </form>			
		</div>
		
		

		<div class=" m-t" id="tab-forgot" style="display: none">	

			
			{!! Form::open(array('url'=>'user/request', 'class'=>'form-vertical', 'parsley-validate'=>'','novalidate'=>' ')) !!}
			   <div class="form-group has-feedback">
			   <div class="">
					<label>{{ Lang::get('core.enteremailforgot') }}</label>
					<input type="text" name="credit_email" placeholder="{{ Lang::get('core.email') }}" class="form-control" required/>
				</div> 	
				</div>
				<div class="form-group has-feedback">    
					<a href="javascript:;" class="forgot btn btn-warning"> Cancel </a>     
			      <button type="submit" class="btn btn-primary "> {{ Lang::get('core.sb_submit') }} </button>        
			  </div>
			  
			  <div class="clr"></div>

			  
			</form>		
		</div>
		
	</div>
	
 



<script type="text/javascript">
	$(document).ready(function(){

		$('.forgot').on('click',function(){
			$('#tab-forgot').toggle();
			$('#tab-sign-in').toggle();
		})
		var form = $('#LoginAjax'); 
		form.parsley();
		form.submit(function(){
			
			if(form.parsley().isValid()){			
				var options = { 
					dataType:      'json', 
					beforeSubmit :  showRequest,
					success:       showResponse  
				}  
				$(this).ajaxSubmit(options); 
				return false;
							
			} else {
				return false;
			}		
		
		});

	});

function showRequest()
{
	$('.ajaxLoading').show();		
}  
function showResponse(data)  {		
	
	if(data.status == 'success')
	{
		window.location.href = data.url;	
		$('.ajaxLoading').hide();
	} else {
		$('.message').html(data.message)	
		$('.ajaxLoading').hide();
		$('.message').show(data.message)	
		return false;
	}	
}	
</script>

@stop