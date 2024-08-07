/* Sximo builder & Sximo 5 Inc 
	copyright 2014 . sximo builder com  & Sximo5.net
*/
$(window).on('load', function() {
  $('#preloader').delay(100).fadeOut('slow',function(){$(this).remove();});
});


jQuery(document).ready(function($){
	var body = $('body');
	body.addClass($.cookie("minimize"));
	body.addClass($.cookie("sx-theme"));
	$('.toggleMenu').click(function () {
		var body = $('body');
		// alert(screen.width);
		// debugger;
		if(body.width() > 768) {
			if(body.hasClass('minimize')) {
				body.removeClass('minimize');
				$('.page-wrapper .sidebar').css('left','0px');
				$.cookie("minimize",' ', {expires: 365, path: '/'});
			} else {
				body.addClass('minimize');
				$('.page-wrapper .sidebar').css('left','-320px');
				$.cookie("minimize",'minimize', {expires: 365, path: '/'});
			}
		} 
		else {
			console.log('success');
			body.addClass('minimize');
			$('.page-wrapper .sidebar').css('left','0px');
			$('.sidebar-compact').css('left','0');
			$('.overlay').show();
		}	
		var w = $("#app");
	});

	// jan2022
	$('.page-content').scroll(function(){
		if(this.scrollTop > 10){
			$(this).addClass('active');
		}
		else{
			$(this).removeClass('active');	
		}
	});

	$(window).resize(function(){
		if(screen.width > 768) {
				body.removeClass('minimize');
			// if(body.hasClass('minimize')) {
			// 	body.removeClass('minimize');
			// 	$('.page-wrapper .sidebar').css('left','0px');
			// 	$.cookie("minimize",' ', {expires: 365, path: '/'});
			// } else {
			// 	body.addClass('minimize');
			// 	$('.page-wrapper .sidebar').css('left','-320px');
			// 	$.cookie("minimize",'minimize', {expires: 365, path: '/'});
			// }
		} 
		else {
			$('.page-wrapper .sidebar').css('left','-320px');
			$('.sidebar-compact').css('left','0');
			if(body.hasClass('minimize')) {
				$('.overlay').show();
			}
			else{
				$('.overlay').hide();
			}
		}	
	});
	// jan2022


	$('.overlay').click(function(){
		body.removeClass('minimize');
		$('.page-wrapper .sidebar').css('left','-320px');
		$('.sidebar-compact').css('left','-70px');
		$(this).hide()
	});

    // $('.navigation').mouseover(function(){
    // 	// var body = $('body');
    // 	// if(body.hasClass('minimize')) {
    // 	// 	$('.page-wrapper .sidebar').css('left','0');
    // 	// } else {
    // 	// 	//$('.page-wrapper .sidebar').css('left','-320px');
    // 	// }
    // }).mouseleave(function() {
    // 	var body = $('body');
    // 	if(body.hasClass('minimize')) {
    // 		 $('.page-wrapper .sidebar').css('left','-320px');
    // 	} else {
    // 		 $('.page-wrapper .sidebar').css('left','0');
    // 	}
    // });
    if(screen.width > 768) {
    	$('.overlay').hide();
    }

	$('.sidebar-compact ul li a').hover(function(){
		var w = $("#app");
		if( w.hasClass('toggled')) {
			w.removeClass('toggled');
		} 			
	})

	$('ul.themeable li a').click(function() {
		var color =  $(this).attr('code');
		$('body').addClass(color)
		$.cookie("sx-theme", color, {expires: 365, path: '/'});
		window.location.reload()
	})

	$(window).bind("load resize",function(){
		var w = $("body");
		if(screen.width > 768) {
			if(body.hasClass('minimize')) {
				$('.page-wrapper .sidebar').css('left','-320px');
				$('.sidebar-compact').css('left','0px');
			} else {
				$('.page-wrapper .sidebar').css('left','0');
				$('.sidebar-compact').css('left','0');
			}
			$('.overlay').hide();
		} else {
			$('.page-wrapper .sidebar').css('left','-320px');
				$('.sidebar-compact').css('left','-70px');
		}
	})

    $('.editor').summernote({ height: 250});	
    window.prettyPrint && prettyPrint();
	$('.date').datepicker({format:'yyyy-mm-dd',autoClose:true})
	$('.datetime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss',autoClose:true});
  	$(".select2").select2({ width:"100%"});	    
	$('.popup').click(function (e) {
		e.stopPropagation();
	});    
	$('.clearCache').click(function(){
		$('.ajaxLoading').show();
		var url = $(this).attr('href');
		$.get( url  , function( data ) {
		 $('.ajaxLoading').hide();
		 notyMessage(data.message); 
		     
		});
		return false;
	}); 
	$('.confirm_logout').on('click',function(){
		if(confirm('Logout from application ?'))
		{
			return true;
		}
		return false;
	})

	$(".checkall").click(function() {
		var cblist = $(".ids");
		if($(this).is(":checked"))
		{				
			cblist.prop("checked", !cblist.is(":checked"));
		} else {	
			cblist.removeAttr("checked");
		}	
	});

	$('.checkall').on('ifChecked', function(event) {
	    $('.ids').iCheck('check');
	});
	$('.checkall').on('ifUnchecked', function(event) {
	    $('.ids').iCheck('uncheck');
	});

    $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    }); 	
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green'
    }); 

    $('.validated').parsley();

    $('.onsearch').keyup(function( e ){
		if (e.keyCode === 13) {
	      val = $(this).val();
	      target =  $(this).data('target');
	      window.location.href = target + '?s='+val ;	     
	    }
	})	
	$('.upload').change(function() {

		var id = $(this).attr('name');

		var files = $(this).prop('files');
		$(this).parent().closest('.fileUpload .title').html(files[0].name)
		console.log(files[0].name)
		const fr = new FileReader()
		fr.readAsDataURL(files[0])
		fr.addEventListener('load', () => {
		 	$('.'+id+'-preview').html('<img src="'+fr.result+'" width="120" />')
		}) 
 		
	  	
	})
	$('.form-tab a').on('click', function (e) {
	  	e.preventDefault()
	  	$(this).tab('show')
	})

})

function previewUpload( e , id ) {
	console.log(e)
		const files = e.target.files
		let imageName = files[0].name
    	let imageType = files[0].type
		const fr = new FileReader()
		fr.readAsDataURL(files[0])
		fr.addEventListener('load', () => {
		 	$('#'+id+'-preview').html('<img src="'+fr.result+'" width="80" />')
		}) 

}
function SximoConfirmDelete( url )
{

	Swal.fire({
        title: 'Confirm ?',
        text: ' Are u sure deleting this record ? ',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, please',
        cancelButtonText: 'cancel'
      }).then((result) => {
        if (result.value) {
          window.location.href = url;
          
        }
      })

	return false;
}
function SximoDelete(  )
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if (!$(".icheckbox_flat-blue").hasClass("checked")) {
		alert("Please check any textbox item");
		return false;
	}
	
	Swal.fire({
        title: 'Confirm ?',
        text: ' Are u sure deleting this record ? ',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, please',
        cancelButtonText: 'cancel'
      }).then((result) => {
        if (result.value) {
         	$('input[name="action_task"]').val('delete');
			$('#SximoTable').submit();// do the rest here
          
        }
      })
}
function SximoCopy(  )
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(confirm('are u sure removing selected rows ?'))
	{
		$('#SximoTable').submit();// do the rest here	
	}	
}	
function SximoModal( url , title)
{
	
	$('#sximo-modal-content').html(' ....Loading content , please wait ...');
	$('.modal-title').html(title);
	$('#sximo-modal-content').load(url,function(){
	});
	$('#sximo-modal').modal('show');	
}

function notyMessage(message)
{
	 $.toast({
	    heading: 'success',
	    text: message,
	    position: 'top-right',		           
	   	icon: 'success',
	    hideAfter: 3000,
	    stack: 6
	});	
}
function notyMessageError(message)
{
	 $.toast({
	    heading: 'error',
	    text: message,
	    position: 'top-right',		           
	    icon: 'error',
	    hideAfter: 3000,
	    stack: 6
	});	
}

function reloadData( id,url   )
{
	$('.ajaxLoading').show()
	$.get( url ,function( data ) {
		$( id +'Grid' ).html( data );
		$('.ajaxLoading').hide()
	});
}
function ajaxViewClose( id )
{
	$( id +'View' ).html('');	
	$( id +'Grid' ).show();	
	$('#sximo-modal').modal('hide');
}
function ajaxViewDetail( id , url )
{
	if(url !='#')
	 {
		$('.ajaxLoading').show();
		$.get( url ,function( data ) {
			$( id +'View').html( data );
			$( id +'Grid').hide( );
			var w = $(window); 
			var duration = 300;
			$('html, body').animate({scrollTop: 0}, duration);
			$('.ajaxLoading').hide();
		});		
	} else {
		alert('No Link with' + url);
	}	
}
function ajaxFilter( id ,url )
{
	var attr = '';
	$( id +'Filter :input').each(function() {
		if(this.value !='') { attr += this.name+'='+this.value+'&'; }
	});	

	reloadData(id, url+"?"+attr);
}
function ajaxCopy(  id , url )
{	
	if(confirm('Areu sure Copy selected row(s)'))
	{
		var datas = $( id +'Table :input').serialize();
			$.post( url ,datas,function( data ) {
				if(data.status =='success')
				{
					notyMessage(data.message );
					ajaxFilter( id ,url+'/data' );
				} else {
					notyMessage(data.message );
				}				
			});			
	} else {
		return false;
	}
}
function loadNestedLookup(url , id )
{
	if($(id).is(':empty'))
	{
		$(id).html('<p class"text-center" style="line-height:100px; text-align:center;"> Loading Content .... Please wait </p>');
		$.get(url,function(data)
		{
			$(id).load(url);	
		})		
	}	
}
function addMoreFiles(id){

	var html = '<div class="fileUpload btn" ><span><i class="fa fa-copy"></i></span><div class="title"> Browse File </div><input type="file" name="'+id+'" class="upload"></div>';

   $("."+id+"Upl").append(html)
}
;(function ($, window, document, undefined) {

    $.fn.Sdtable = function( options ) {

    	var settings = $.extend({
            tableId     : 'datatable',
            table   	: 'table',
            action      : 'action'	
     
        }, options);

        return this.each( function() {
			var gridData 	= settings.tableId+'Table';
			var gridTbl 	= settings.tableId+'Grid';
			var gridView 	= settings.tableId+'View';
        	$( gridData +' tbody').on('click', 'tr.odd', function () { $(this).toggleClass('selected'); });
        	$( gridData +' tbody ').on('click', 'tr.even', function () { $(this).toggleClass('selected'); });
			$('.Action_Row').click(function () {
				var code = $(this).attr('code');
				if( code =='reload') { settings.table.ajax.reload();}
				if( code =='add') {
			       		var url = settings.action + '/create';			       		
			       		var mode = $(this).attr('mode');
						var title = $(this).attr('data-original-title');
						if(mode =='native')
						{
							Sdt_ViewDetail( settings.tableId , url  );
						} else {
							SximoModal(  url  , title  );
						}					
				}

				var rows = settings.table.rows('.selected').data().length ;
		        if(rows)
		        {
		        	var id = settings.table.row('.selected').data().rowId;
					
					if(code =='view')
					{
						var url =  settings.action + '/show/'+id;
						var mode = $(this).attr('mode');
						var title = $(this).attr('data-original-title');
						if(mode =='native')
						{
							Sdt_ViewDetail( settings.tableId , url  );
						} else {
							SximoModal(  url  , title  );
						}
						
						

					}  else if(code =='copy') {

						var rows = settings.table.rows('.selected').data();
						var ss = [];
			        	for(var i=0; i<rows.length; i++){
			        		var ids = rows[i].rowId;
		                    ss.push(ids) ;
			        	}
			        	if(confirm('Are sure Clone/Copy selected row(s) ?'))
			        	{
			        		var url =  settings.action ;
			        		$('.ajaxLoading').show()
							$.post( url  ,{ids:ss,action_task:'copy'},function( data ) {
								if(data.status =='success')
								{
									notyMessage(data.message);	

									 settings.table.ajax.reload();
									 $('.ajaxLoading').hide()
								} else {
									notyMessageError(data.message);	
								}				
							});	
			        	}	

					} else if(code =='edit') {
			       		var url = settings.action + '/update/'+id;			       		
			       		var mode = $(this).attr('mode');
						var title = $(this).attr('data-original-title');
						if(mode =='native')
						{
							Sdt_ViewDetail( settings.tableId , url  );
						} else {
							SximoModal(  url  , title  );
						}					

					} else if(code =='remove'){

						var rows = settings.table.rows('.selected').data();
						var ss = [];
			        	for(var i=0; i<rows.length; i++){
			        		var ids = rows[i].rowId;
		                    ss.push(ids) ;
			        	}
			        	if(confirm('Are sure Remove selected row(s) ?'))
			        	{
			        		var url =   settings.action;
							$.post( url ,{ids:ss,action_task:'delete'},function( data ) {
								if(data.status =='success')
								{
									notyMessage(data.message);	
									settings.table.ajax.reload();
								} else {
									notyMessageError(data.message);	
								}				
							});		
			        	}					

					} else {

					}
				}	
		    });	



        });

    }

}(jQuery));

