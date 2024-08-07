<script type="text/javascript">
			@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)

			const unitString = '<td><input type="text" name="unit_hiking[]" class="form-control" placeholder="Hiking Percent" value="" style="width: 100px"></td> <td><input type="text" name="unit_sprice[]" class="sellPrice form-control" placeholder="Selling Price" style="width: 100px"></td>';
			const variString = '<td><input type="text" name="vari_hiking[]" class="form-control"placeholder="Hiking Percent" style="width: 100px"></td><td><input type="text" name="vari_sprice[]" class="sellPrice form-control" placeholder="Selling Price" style="width: 100px"></td>';
			@else
			const unitString = '';
			const variString = '';
			@endif
			$(document).on('ifChecked','.food_unit',function(){
				var fUnit=$(this).val();
				if(fUnit=='unit'){
					$("#unit_div").show();
					$("#variation_div").hide();
				}else if(fUnit=='variation'){
					$("#unit_div").hide();
					$("#variation_div").show();
				}else{
					$("#unit_div").hide();
					$("#variation_div").hide();
				}
			})
			// $(document).on('click','.unit_add',function(){
			// 	var unit_get=$("#unit_get").html();
			// 	$("#unit_div_body").append('<tr><td><input type="hidden" name="unit_id[]"><select class="form-control unit_class" name="unit[]" id="unit_get">'+unit_get+'</select></td><td><input type="text" name="price_unit[]" class="priceUV form-control req_class" placeholder="Price" style="width: 100px"></td><td><button class="btn-sm btn-danger unit_remove" type="button">-</button></td></tr>');
			// })
			$(document).on('click','.variation_add',function(){
				var color=$("#Fcolor_get").html();
				var unit=$("#Fvari_unit").html();
				$("#variation_div_body").append('<tr><td><input type="hidden" name="variation_id[]"><select class="form-control" name="Fcolor[]" >'+color+'</select></td><td><select class="form-control" name="vari_unit[]" >'+unit+'</select></td><td><input type="text" name="vari_price[]" class="priceUV form-control" placeholder="Price" style="width: 100px"></td>'+variString+'<td><button class="btn-sm btn-danger variation_remove" type="button">-</button></td></tr>');
			})
			$(document).on('click','.unit_remove',function(){
				$(this).closest('tr').remove();
			})
			$(document).on('click','.variation_remove',function(){
				$(this).closest('tr').remove();
			})
			$(document).on('click','.remove_Img',function(){
				var imageval = $(this).attr('data-img');
				var section = $(this).attr('data-val');
				if(section == 'variation'){
					var deletedImg = $(this).closest('tr').find('.variation_deleted_Image').val();
				} else {
					var deletedImg = $("#deletedImg").val();
				}
				var updateImage = '';
				if(deletedImg != ''){
					updateImage += ','+imageval;
				} else {
					updateImage = imageval;
				}
				if(section == 'variation'){
					$(this).closest('tr').find('.variation_deleted_Image').val(updateImage);
				} else {
					$("#deletedImg").val(updateImage);
				}
				$(this).closest('div').remove();
			})
			$('.changePrice').on('click',function(){
				if ($('.price').prop('readonly') == true) {
					$('.price').prop('readonly',false);
					$('.changePriceMsg').slideDown();
					$(this).html('Cancel');
				} else {
					$('.price').prop('readonly',true);
					$('.changePriceMsg').slideUp();
					$(this).html('Change Price');
				}				
			});

			$(document).on('change',".startTimeChange",function(){	
				var starttime = $(this).find('option:selected').attr('data-val');
				var startText = $(this).find('option:selected').text();
				var idVal = $(this).attr('id');
				var split = idVal.toString().split('_');
				var dayId = split[1];
				var timeId = split[2];
				timeAppend(starttime,'end',dayId,timeId,startText);
				if(timeId == 1) {
					$("#resTime_"+dayId+"_2").val('');
				}
			})
			function timeAppend(time,type='start',dayId,timeId,startText=''){
				var timeType = type;
				var stText = startText;
				$.ajax({
					url : base_url+"restaurant/endtimefood",
					type : "POST",
					data : {
						value 	: time,
						type 	: type,
						dayId 	: dayId,
						timeId 	: timeId,
					},
					dataType : "json",
					success : function(result){
						var html = result.html;
						$(".endTimeChange").select2("destroy");
						$(".endTimeChange").html(html);
						$(".endTimeChange").select2({width:"180px"});


					}
				})
			}

			$(document).on('change',".startTimeChange1",function(){	
				var starttime = $(this).find('option:selected').attr('data-val');
				var startText = $(this).find('option:selected').text();
				var idVal = $(this).attr('id');
				var split = idVal.toString().split('_');
				var dayId = split[1];
				var timeId = split[2];
				timeAppend1(starttime,'end',dayId,timeId,startText);
				if(timeId == 1) {
					$("#resTime_"+dayId+"_2").val('');
				}
			})
			function timeAppend1(time,type='start',dayId,timeId,startText=''){
				var timeType = type;
				var stText = startText;
				$.ajax({
					url : base_url+"restaurant/endtimefood",
					type : "POST",
					data : {
						value 	: time,
						type 	: type,
						dayId 	: dayId,
						timeId 	: timeId,
					},
					dataType : "json",
					success : function(result){
						var html = result.html;
						$(".endTimeChange1").select2("destroy");
						$(".endTimeChange1").html(html);
						$(".endTimeChange1").select2({width:"180px"});


					}
				})
			}

			$(document).on('change',".endTimeChange",function(){	
				var starttime = $(this).find('option:selected').attr('data-val');
				var startText = $(this).find('option:selected').text();
				var idVal = $(this).attr('id');
				var split = idVal.toString().split('_');
				var dayId = split[1];
				var timeId = split[2];
				timeAppend2(starttime,'secondstart',dayId,timeId,startText);
				if(timeId == 1) {
					$("#resTime_"+dayId+"_2").val('');
				}
			})
			function timeAppend2(time,type='start',dayId,timeId,startText=''){
				var timeType = type;
				var stText = startText;
				$.ajax({
					url : base_url+"restaurant/endtimefood",
					type : "POST",
					data : {
						value 	: time,
						type 	: type,
						dayId 	: dayId,
						timeId 	: timeId,
					},
					dataType : "json",
					success : function(result){
						var html = result.html;
						$(".startTimeChange1").select2("destroy");
						$(".startTimeChange1").html(html);
						$(".startTimeChange1").select2({width:"180px"});

						$(".endTimeChange1").select2("destroy");
						$(".endTimeChange1").html('<option value="" selected>End Time</option>');
						$(".endTimeChange1").select2({width:"180px"});


					}
				})
			}
			var base_url    = "<?php echo URL::to('/').'/'; ?>";
			$(document).ready(function() {
				$("input[name$='adon_type']").click(function() {
					$value=$(this).val();
					if($value=='unit'){
						$("#unit_div").show();
					}
					else{
						$("#unit_div").hide();
					}
				});
				var group_id = $('.group_id').val();

				if(group_id == 3){
					var user_id	= '{!! Auth::user()->id !!}';
					$("#restaurant_id").jCombo("{!! url('fooditems/comboselect?filter=abserve_restaurants:id:name:partner_id&limit=where:status:!=:3&limit=where:partner_id:=:"+user_id+"') !!}",
						{  selected_value : '{!! $row["restaurant_id"] !!}' });
				}  else {
					$("#restaurant_id").jCombo("{!! url('fooditems/comboselect?filter=abserve_restaurants:id:name&limit=where:status:!=:3') !!}",{
									"selected_value" : '{{ $row["restaurant_id"] }}',
								})
				}

				$('#restaurant_id').on('change', function() {
					var res_id	= this.value;
					if(res_id!='')
						bindAddons(res_id);
				});

				$("#main_cat").jCombo("{!! url('fooditems/comboselect?filter=abserve_food_categories:id:cat_name&limit=where:type:=:category') !!}",
					{  selected_value : '{!! $row["main_cat"] !!}' });
				$("#sub_cat").jCombo("{!! url('fooditems/comboselect?filter=abserve_food_categories:id:cat_name&limit=where:type:=:brand')!!}",
					{  selected_value : '{!! $row["sub_cat"] !!}' });
				$('.removeCurrentFiles').on('click',function(){
					var removeUrl = $(this).attr('href');
					$.get(removeUrl,function(response){});
					$(this).parent('div').empty();	
					return false;
				});
			});

			function bindAddons(res_id) {
				var addons = '{!! $row["addon"] !!}';
				addons = addons.split(',');
				$.ajax({
					url: base_url+'getpartner',
					type: 'get',
					data: { res_id : res_id },
					dataType:'json',
					success:function(res){
						var options = "";
						$("#addons").empty();
						$("#addons").append('<option>Select addons</option>');
						for (var i = 0; i < res.length; i++) {
							let select = jQuery.inArray(res[i].id.toString(), addons) !== -1 ? 'selected' : '';
							options += "<option "+select+" value='"+res[i].id+"'>" + res[i].name + "</option>";
						}
						$("#addons").append(options);

					}
				});
			}


			$("input[parsley-type='number']").on("keypress keyup blur",function (event) {    
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if(event.which == 8){

				} else if((event.which < 48 || event.which > 57 )) {
					event.preventDefault();
				}
			});
			$(".hike").on("keypress keyup blur",function (event) {    
				var val = $(this).val();
				if($(this).parent().get( 0 ).tagName == 'TD'){
					var price = $(this).parent().parent().find('.priceUV').val();
					var tax   =	parseFloat(price * ( val / 100 ));
					price  	  = parseFloat(tax) + parseFloat(price);
					$(this).parent().parent().find('.sellPrice').val(price);
				}else{
					var price = $('input[name="price"]').val();
					var tax   =	parseFloat(price * ( val / 100 ));
					price  	  = parseFloat(tax) + parseFloat(price);
					$('.selling_price').val(price);
				}
			});
			$(".strike_price").on('focusout',function(){
				var strikeprice  = $(this).val();
				var sellingprice = $('.selling_price').val();
				if (strikeprice > sellingprice) {
					$(this).val(strikeprice);
				}
				else {
					$(this).val(0);
				}
			});
			$('#datepairExample .time').timepicker({
				'showDuration': true,
				'timeFormat': 'g:i:sa'
			});
			$('#datepairExample').datepair();

			$(document).on('click','.unit_add',function(){
				var cnt=$(".unit_class").length;
        //console.log(cnt);  
        var rcnt=$(".req_class").length;
        //console.log(rcnt); 
        var valid = false;
        if(rcnt == 0) {
        	valid = true;
        } else {		
        	valid = true;
        	$('.req_class').each(function(){
        		if ($(this).val() == '' || $(this).val() == null) {
        			valid = false;
        		}
        	});
        }
        if (valid) {
        	variants(cnt);
        }
    });

			function variants(cnt) {
				var option=$("#unit_get").html();
				$("#unit_div_body").append(`
					<tr class="unitdiv0">
					<td class="unit_event"><input type="hidden" name="unit_id[]">
					<select name="unit[]" class="form-control unit_class req_class" id="unit_class`+(cnt)+`">
					`+option+`
					</select>
					</td>
					<td class="col-md-3 unit_event`+(cnt)+`">
					<input type="text" name="price_unit[]" class="form-control req_class priceUV" id="unit_price" placeholder="Price" style="width: 100px">
					</td>
					<td class="col-md-1">
					<button type="button" class="btn-sm btn-danger unit_minus" id="unit_minus`+(cnt)+`" data-id="`+(cnt)+`">-</button>
					</td>
					</tr>`);
				$(".unit_class").each(function(){
					$("#unit_class"+(cnt)+' option[value="'+$(this).val()+'"]').attr('disabled', true);
				})
        //$("#unit_minus"+(cnt-1)).hide();
        //$("#unit_class"+(cnt)).select2();
        $(".unit_event"+(cnt-1)).addClass('disabled_div');
        if ($(".unitdiv"+(cnt-1)).find('.unit_edit').length == 0) {
        	$(".unitdiv"+(cnt-1)).append(`  <td class="col-md-1">
        		<button type="button" class="btn btn-success btn-xs unit_edit" data-id="`+(cnt)+`"><i class="fa fa-edit"></i></button>
        		</td>`);
        }
    }

    $(document).on('click','.unit_minus',function(e){
    	e.preventDefault();
    	var id=$(this).attr('data-id');
    	$("#unit_minus"+(id-1)).show();
        //$(".unit_event"+(id-1)).removeClass('disabled_div');
        $(this).closest('.unitdiv'+(id)).remove();
    });

    $(document).on('click','.unit_edit',function(e){
    	e.preventDefault();
    	var id=$(this).attr('data-id');
    	console.log(id);
    	$(".unit_event"+(id-1)).removeClass('disabled_div');
        // $(".unit_event"+(id-1)).attr('disabled',false);
    });




	var $st1 = $('#startTime1').pickatime();
	var startT1 = $st1.pickatime('picker');

	var $et1 = $('#endTime1').pickatime();
	var endT1 = $et1.pickatime('picker');

	var $st2 = $('#startTime2').pickatime();
	var startT2 = $st2.pickatime('picker');

	var $et2 = $('#endTime2').pickatime();
	var endT2 = $et2.pickatime('picker');
	var time = $st1.pickatime('picker').get('select');
	$(document).ready(function() {
		var a1 = time.mins;
		var b1 = time.hour;
		endT1.set('disable', [{ from: [0,0], to: [b1,a1] }] );
		startT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
		endT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
	});
	
	$('#startTime1').on('change',function(){
		var time = $st1.pickatime('picker').get('select');
		var a1 = time.mins;
		var b1 = time.hour;
		endT1.set('disable', [{ from: [0,0], to: [b1,a1] }] );
		startT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
		endT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
	})
	$('#startTime2').on('change',function(){
		var time = $st2.pickatime('picker').get('select');
		var a2 = time.mins;
		var b2 = time.hour;
		endT2.set('disable', [{ from: [0,0], to: [b2,a2] }] );
	})
</script>	
