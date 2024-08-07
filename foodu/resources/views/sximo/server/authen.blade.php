{!! Form::open(array('url'=>'sximo/server?do=install', 'class'=>'form-horizontal well','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'doUpdate')) !!}

	<p> Please make sure you have an account at <a href="http://sximo5.net" target="_blank"> Sximo5.NET </a></p>
<div class="form-group">
	<div class="col-md-3">
		Email Address
	</div>
	<div class="col-md-9">
		<input name="email" class="form-control input-sm" required="true" type="text" />
	</div>
</div>
<div class="form-group">
	<div class="col-md-3">
		Password
	</div>
	<div class="col-md-9">
		<input name="password" class="form-control input-sm"  required="true" type="password"  />
	</div>
</div>		                    		


<div class="form-group">
	<div class="col-md-3">
		
	</div>
	<div class="col-md-9">
		<button class="btn btn-primary btn-sm processing"> Download Update(s) & Install Now </button>
	</div>
</div>		
<input type="hidden" name="ProductID"  value="{{ $id }}">
<input type="hidden" name="do" value="install">
<input type="hidden" name="type" value="{{ $type }}">
 {!! Form::close() !!}	

 <script type="text/javascript">
$(function(){
	var form = $('#doUpdate'); 
    form.parsley();
    form.submit(function()
    {         
      if (form.parsley().isValid())
      {      
        var options = { 
          dataType:      'json', 
          beforeSubmit : function() {
				$('.failed-update').hide()
				$('.authen-update').hide();
				$('.progress-update').show();
				$('.progress-result').html('');
				$('.processing').html('...Authentication & Downloading ..')
          },
          success: function( data ) {
	          if(data.status == 'success')
	          {     
	         	 notyMessage(data.message);
	         	 $.get('{{ url("sximo/config/clearlog") }}',function(){})
	          	
	          } else {
	          	$('.failed-authen').show();
	          	$('.progress-update').hide();
	            notyMessageError(data.message);
	          	$('.processing').html('Download Update(s) & Install Now')
	           
	          }
          }  
        }  
        $(this).ajaxSubmit(options); 
        return false;                 
	} 
	else {
		notyMessageError('Error ajax wile submiting !');
		return false;
	}      
	});	
})
</script> 