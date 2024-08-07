

		 {!! Form::open(array('url'=>'weeklypaymentforhost', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Weekly payment for host</legend>
				{!! Form::hidden('id', $row['id']) !!}					
									  <div class="form-group row  " >
										<label for="Group Id" class=" control-label col-md-4 text-left"> Group Id </label>
										<div class="col-md-6">
										  <input  type='text' name='group_id' id='group_id' value='{{ $row['group_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Unique Id" class=" control-label col-md-4 text-left"> Unique Id </label>
										<div class="col-md-6">
										  <input  type='text' name='unique_id' id='unique_id' value='{{ $row['unique_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Manager Id" class=" control-label col-md-4 text-left"> Manager Id </label>
										<div class="col-md-6">
										  <input  type='text' name='manager_id' id='manager_id' value='{{ $row['manager_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Phone Number" class=" control-label col-md-4 text-left"> Phone Number </label>
										<div class="col-md-6">
										  <input  type='text' name='phone_number' id='phone_number' value='{{ $row['phone_number'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Phone Otp" class=" control-label col-md-4 text-left"> Phone Otp </label>
										<div class="col-md-6">
										  <input  type='text' name='phone_otp' id='phone_otp' value='{{ $row['phone_otp'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Username" class=" control-label col-md-4 text-left"> Username </label>
										<div class="col-md-6">
										  <input  type='text' name='username' id='username' value='{{ $row['username'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Password" class=" control-label col-md-4 text-left"> Password </label>
										<div class="col-md-6">
										  <input  type='text' name='password' id='password' value='{{ $row['password'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Email" class=" control-label col-md-4 text-left"> Email </label>
										<div class="col-md-6">
										  <input  type='text' name='email' id='email' value='{{ $row['email'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="First Name" class=" control-label col-md-4 text-left"> First Name </label>
										<div class="col-md-6">
										  <input  type='text' name='first_name' id='first_name' value='{{ $row['first_name'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Last Name" class=" control-label col-md-4 text-left"> Last Name </label>
										<div class="col-md-6">
										  <input  type='text' name='last_name' id='last_name' value='{{ $row['last_name'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Avatar" class=" control-label col-md-4 text-left"> Avatar </label>
										<div class="col-md-6">
										  <input  type='text' name='avatar' id='avatar' value='{{ $row['avatar'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="SocialmediaImg" class=" control-label col-md-4 text-left"> SocialmediaImg </label>
										<div class="col-md-6">
										  <textarea name='socialmediaImg' rows='5' id='socialmediaImg' class='form-control form-control-sm '  
				           >{{ $row['socialmediaImg'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Active" class=" control-label col-md-4 text-left"> Active </label>
										<div class="col-md-6">
										  <input  type='text' name='active' id='active' value='{{ $row['active'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Login Attempt" class=" control-label col-md-4 text-left"> Login Attempt </label>
										<div class="col-md-6">
										  <input  type='text' name='login_attempt' id='login_attempt' value='{{ $row['login_attempt'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Last Login" class=" control-label col-md-4 text-left"> Last Login </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('last_login', $row['last_login'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('created_at', $row['created_at'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('updated_at', $row['updated_at'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Reminder" class=" control-label col-md-4 text-left"> Reminder </label>
										<div class="col-md-6">
										  <input  type='text' name='reminder' id='reminder' value='{{ $row['reminder'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Activation" class=" control-label col-md-4 text-left"> Activation </label>
										<div class="col-md-6">
										  <input  type='text' name='activation' id='activation' value='{{ $row['activation'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Remember Token" class=" control-label col-md-4 text-left"> Remember Token </label>
										<div class="col-md-6">
										  <input  type='text' name='remember_token' id='remember_token' value='{{ $row['remember_token'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Last Activity" class=" control-label col-md-4 text-left"> Last Activity </label>
										<div class="col-md-6">
										  <input  type='text' name='last_activity' id='last_activity' value='{{ $row['last_activity'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Phone Verified" class=" control-label col-md-4 text-left"> Phone Verified </label>
										<div class="col-md-6">
										  <input  type='text' name='phone_verified' id='phone_verified' value='{{ $row['phone_verified'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Phone Code" class=" control-label col-md-4 text-left"> Phone Code </label>
										<div class="col-md-6">
										  <input  type='text' name='phone_code' id='phone_code' value='{{ $row['phone_code'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Address" class=" control-label col-md-4 text-left"> Address </label>
										<div class="col-md-6">
										  <input  type='text' name='address' id='address' value='{{ $row['address'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Id Type" class=" control-label col-md-4 text-left"> Id Type </label>
										<div class="col-md-6">
										  <input  type='text' name='id_type' id='id_type' value='{{ $row['id_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Nric Number" class=" control-label col-md-4 text-left"> Nric Number </label>
										<div class="col-md-6">
										  <input  type='text' name='nric_number' id='nric_number' value='{{ $row['nric_number'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Business Addr" class=" control-label col-md-4 text-left"> Business Addr </label>
										<div class="col-md-6">
										  <input  type='text' name='business_addr' id='business_addr' value='{{ $row['business_addr'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Business Name" class=" control-label col-md-4 text-left"> Business Name </label>
										<div class="col-md-6">
										  <input  type='text' name='business_name' id='business_name' value='{{ $row['business_name'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cuisine Type" class=" control-label col-md-4 text-left"> Cuisine Type </label>
										<div class="col-md-6">
										  <input  type='text' name='cuisine_type' id='cuisine_type' value='{{ $row['cuisine_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Res Type" class=" control-label col-md-4 text-left"> Res Type </label>
										<div class="col-md-6">
										  <input  type='text' name='res_type' id='res_type' value='{{ $row['res_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Lat" class=" control-label col-md-4 text-left"> Lat </label>
										<div class="col-md-6">
										  <input  type='text' name='lat' id='lat' value='{{ $row['lat'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Lang" class=" control-label col-md-4 text-left"> Lang </label>
										<div class="col-md-6">
										  <input  type='text' name='lang' id='lang' value='{{ $row['lang'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="City" class=" control-label col-md-4 text-left"> City </label>
										<div class="col-md-6">
										  <input  type='text' name='city' id='city' value='{{ $row['city'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="State" class=" control-label col-md-4 text-left"> State </label>
										<div class="col-md-6">
										  <input  type='text' name='state' id='state' value='{{ $row['state'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Zip Code" class=" control-label col-md-4 text-left"> Zip Code </label>
										<div class="col-md-6">
										  <input  type='text' name='zip_code' id='zip_code' value='{{ $row['zip_code'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Country" class=" control-label col-md-4 text-left"> Country </label>
										<div class="col-md-6">
										  <input  type='text' name='country' id='country' value='{{ $row['country'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Mobile Token" class=" control-label col-md-4 text-left"> Mobile Token </label>
										<div class="col-md-6">
										  <input  type='text' name='mobile_token' id='mobile_token' value='{{ $row['mobile_token'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Commission" class=" control-label col-md-4 text-left"> Commission </label>
										<div class="col-md-6">
										  <input  type='text' name='commission' id='commission' value='{{ $row['commission'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Device" class=" control-label col-md-4 text-left"> Device </label>
										<div class="col-md-6">
										  <input  type='text' name='device' id='device' value='{{ $row['device'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Ext Acc Id" class=" control-label col-md-4 text-left"> Ext Acc Id </label>
										<div class="col-md-6">
										  <input  type='text' name='ext_acc_id' id='ext_acc_id' value='{{ $row['ext_acc_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Online Sts" class=" control-label col-md-4 text-left"> Online Sts </label>
										<div class="col-md-6">
										  <input  type='text' name='online_sts' id='online_sts' value='{{ $row['online_sts'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Email Verified" class=" control-label col-md-4 text-left"> Email Verified </label>
										<div class="col-md-6">
										  <input  type='text' name='email_verified' id='email_verified' value='{{ $row['email_verified'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Social Id" class=" control-label col-md-4 text-left"> Social Id </label>
										<div class="col-md-6">
										  <textarea name='social_id' rows='5' id='social_id' class='form-control form-control-sm '  
				           >{{ $row['social_id'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Social Type" class=" control-label col-md-4 text-left"> Social Type </label>
										<div class="col-md-6">
										  <input  type='text' name='social_type' id='social_type' value='{{ $row['social_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Fb Id" class=" control-label col-md-4 text-left"> Fb Id </label>
										<div class="col-md-6">
										  <textarea name='fb_id' rows='5' id='fb_id' class='form-control form-control-sm '  
				           >{{ $row['fb_id'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Apple Id" class=" control-label col-md-4 text-left"> Apple Id </label>
										<div class="col-md-6">
										  <textarea name='apple_id' rows='5' id='apple_id' class='form-control form-control-sm '  
				           >{{ $row['apple_id'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Customer Wallet" class=" control-label col-md-4 text-left"> Customer Wallet </label>
										<div class="col-md-6">
										  <input  type='text' name='customer_wallet' id='customer_wallet' value='{{ $row['customer_wallet'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Offer Wallet" class=" control-label col-md-4 text-left"> Offer Wallet </label>
										<div class="col-md-6">
										  <input  type='text' name='offer_wallet' id='offer_wallet' value='{{ $row['offer_wallet'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Offer Id" class=" control-label col-md-4 text-left"> Offer Id </label>
										<div class="col-md-6">
										  <input  type='text' name='offer_id' id='offer_id' value='{{ $row['offer_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Services" class=" control-label col-md-4 text-left"> Services </label>
										<div class="col-md-6">
										  <input  type='text' name='services' id='services' value='{{ $row['services'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset></div>

			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-default btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-default btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
				  </div>	  
			
		</div> 
		 <input type="hidden" name="action_task" value="public" />
		 {!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
