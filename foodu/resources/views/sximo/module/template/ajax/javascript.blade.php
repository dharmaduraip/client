<script>
$(document).ready(function() {
	$('.tips').tooltip();	
    $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    }); 
	$('.checkall').on('ifChecked', function(event) {
	    $('.ids').iCheck('check');
	});
	$('.checkall').on('ifUnchecked', function(event) {
	    $('.ids').iCheck('uncheck');
	});    
	$('#{{ $pageModule }}Paginate .pagination li a').click(function() {
		var url = $(this).attr('href');
		reloadData('#{{ $pageModule }}',url);		
		return false ;
	});
	$('.onsearch').keyup(function( e ){
		if (e.keyCode === 13) {
			val = $(this).val();
			target =  $(this).data('target');
			div =  $(this).data('div');
			href = target + '/data?s='+val ;
			reloadData('#'+div,href);	
		}
	})	
	$('.copy').click(function() {
		var total = $('input[class="ids"]:checkbox:checked').length;
		if(confirm('are u sure Copy selected rows ?'))
		{
			$('input[name="action_task"]').val('copy');
			var id = '#{{ $pageModule }}';
			var url = '{{ url($pageModule) }}' ;
			var datas = $( '#SximoTable :input').serialize();
			$.post( url ,datas,function( data ) {
				if(data.status =='success')
				{
					notyMessage(data.message );
					ajaxFilter( id ,url+'/data' );
				} else {
					notyMessage(data.message );
				}				
			});	


			
		}
	})			

	$('.delete').click(function() {
		$('input[name="action_task"]').val('delete');
		var datas = $( '#SximoTable :input').serialize();
		if(confirm('Are u sure deleting selected row(s)?')) {
			
			var url = '{{ url($pageModule) }}' ;
			$.post( url ,datas,function( data ) {
				notyMessage(data.message );		
				ajaxFilter('#{{ $pageModule }}',url+'/data');			
			});	
			
			
		}
	})
	


	$('.expandable').click(function(){

		var id = $(this).attr('rel');
		selector =  id +" .data";
		if($(selector).is(':empty'))
		{

			$(selector).html('<p class="text-center"> Loading Content ....</p>');
			$(id).show();
			$(this).removeClass('expandable'); $(this).addClass('collapseable'); 
			var url = $(this).attr('data-url');
			//$('.expanded').hide();
			$.get( url , function(data){
				$(selector).html(data);			
				
			})
			$(this).html('<i class="fa fa-minus"></i>');
			$(this).addClass('open');
		} else {
			if($(this).hasClass('open'))
			{
				$(this).html('<i class="fa fa-plus"></i>');
				$(this).removeClass('open');
				$(id).hide();
			} else {
				$(this).html('<i class="fa fa-minus"></i>');
				$(this).addClass('open');

				$(id).show();
			}
			
		}	
	});
});		
</script>	
	