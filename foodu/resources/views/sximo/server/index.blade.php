
		<div class="sbox bg-gray"  >
			<div class="sbox-title"> <h4><i class="fa fa-recycle"></i> Sximo5 VERSION <label class="badge badge-primary">  {{ ucwords($version['Version']) }} </label></div>
			<div class="sbox-content">

			
			  		<div class="row">
				  		<div class="col-md-12">
							<div class="form-horizontal ">
				
								<div class="form-group">
									<div class="col-md-4">
										CodeName
									</div>
									<div class="col-md-8">
										 {{ ucwords($version['Codename']) }}
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-4">
										Version
									</div>
									<div class="col-md-8">
										 {{ ucwords($version['Version']) }}
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										Build Date
									</div>
									<div class="col-md-8">
										 {{ $version['Build'] }}
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										
									</div>
									<div class="col-md-8">
										  <a href="javascript://ajax" class= "btn btn-primary btn-sm autoupdate "><i class="fa fa-recycle"></i> Check for updates  .</a> 
									</div>
								</div>																				
		
					  		</div>
					  	</div>	

				  		<div class="col-md-12">

							<div class="authen-update available" style="display: none; background: none; padding: 20px;" >
	              				 {!! Form::open(array('url'=>'sximo/server', 'class'=>'form-horizontal ','files' => true , 'parsley-validate'=>'','novalidate'=>' ' ,'id'=>'doUpdate')) !!}

	              				 <div class="m-t m-b text-center">
		              				 <i class="fa fa-thumbs-o-up fa-5x"></i>
									<h4> Update Available ! </h4>
								</div>	

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
	                    				<button class="btn btn-primary btn-sm"> Download Update(s) & Install Now </button>
	                    			</div>
	                    		</div>		
	                    		<input type="hidden" name="codename" id="" value="">		
	                    		<input type="hidden" name="version" value="2.0.1">
	                    		<input type="hidden" name="build" value="">
	                    		<input type="hidden" name="process" value="">
								 {!! Form::close() !!}	
								</div>


							<div class="progress-update" style="display: none;">
								<p>Downloading New Update</p>
								<p>Update Downloaded And Saved</p>
								<p>Installing ..... Please dont navigate this page ... </p>
								<div class="well progress-result">

								</div>
							</div>							

							<div class="failed-update" style="display: none; padding: 50px 0; text-align: center;" >
								<i class="fa fa-thumbs-o-up fa-5x"></i>
								<p> There's nothing to update(s) </p>
							</div>

							<div class="failed-authen" style="display: none; padding: 50px 0; text-align: center;" >
								<i class="fa fa-warning fa-5x text-danger"></i>
								<p>Failed To Access Server  </p>
							</div>





				  		</div>				  		

			  		</div>
				</div>



				
			
			</div> 				

		  </div>
	  </div>

<style type="text/css">
	#sximo-modal-content {
		background: #f1f3f6 ;
	}
</style>
<script type="text/javascript">
$(function(){
	$('.autoupdate').on('click',function(){
		$.get('{{ url("sximo/server/version?check") }}',function( callback ) {
			if(callback.status =='success'){
				$('.available').show();
				$(' .available .panel-title h4').text(callback.message + ' To : ' + callback.version );
				$('.authen-update').show();
				$('.progress-update').hide();
				$('.failed-authen').hide();

			} else {
				  $('.failed-update').show()
			}
		})
	})	

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
          },
          success: function( data ) {
	          if(data.status == 'success')
	          {     
	         	 $('.progress-result').html(data.message);
	         	 $.get('{{ url("sximo/config/clearlog") }}',function(){})
	          	
	          } else {
	          	$('.failed-authen').show();
	          	$('.progress-update').hide();
	            notyMessageError(data.message);
	          
	           
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

