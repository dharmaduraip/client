@extends('layouts.app')

@section('content')

<section class="page-header row">
	<h3> Sximo5 NET server <small> Connection to Main Sximo NET </small></h3>
	<ol class="breadcrumb">
		<li><a href="{{ url('') }}"> Dashboard </a></li>
		<li class="active"> Sximo </li>	
		<li class="active"> Server </li>		
	</ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">
		<div class="sbox bg-gray"  >
			<div class="sbox-title"><h4>Browse Plugins , Themes Etc </h4></div>
			<div class="sbox-content">
				<div class="ajaxLoading"></div>

				<div style="min-height: 450px;" id="items">

				
			
			</div> 				

		  </div>
	  </div>

    </div>
</div>
<script type="text/javascript">
function page( page ) {
	$('.ajaxLoading').show();
	$.get('{{ url("sximo/server/load?page=" ) }}'+page,function( callback ) {
		$('#items').html(callback)
		$('.ajaxLoading').hide();
	})	
}
$(function(){
	
	page();
	

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

 @stop 
 	    