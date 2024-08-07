<div class="modal fade" id="abserve-modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header bg-default">
		<h4 class="modal-title abserve-modal-title">Advance Search</h4>
		<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
	</div>
	<div class="modal-body" id="abserve-modal-content"><div>
<form id="ordersSearch">
	<table class="table search-table table-striped" id="advance-search">
<?php if(\Request::route()->getName()=="masterdata.index") {?>
			<tr id="id" class="fieldsearch">
			<td>Id </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="id" value=""></td>
			</tr>

			<tr id="username" class="fieldsearch">
				<td>Name </td>
				<td> 
					<select id="username_operate" class="form-control oper" name="operate" >
						<option value="equal"> = </option>
						<option value="like"> Like </option>	
					</select> 
				</td>
					<td id="field_name"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="name" value=""></td>
			</tr>

			<tr id="id" class="fieldsearch">
			<td>GST </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_gst"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="gst" value=""></td>
			</tr>

			<tr id="username" class="fieldsearch">
				<td>Category </td>
				<td> 
					<select id="username_operate" class="form-control oper" name="operate" >
						<option value="equal"> = </option>
					</select> 
				</td>
					<td id="field_category"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="category" value=""></td>
			</tr>

			<tr id="id" class="fieldsearch">
			<td>Brand </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="field_brand"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="brand" value=""></td>
			</tr>

			<tr id="status_type" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="status_type_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="status_payment_type">
				<select name="active" class="form-control search_pop" data-name="status">
					<option value=""> -- Select  -- </option>
					<option value="approved"> approved	 </option>
					<option value="not_approved"> not_approved </option> 
				</select>
			</td>
		</tr>

		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>

		</tr>

<?php }?>		
<?php if(\Request::route()->getName()=="admin.index") {?>
			<tr id="id" class="fieldsearch">
			<td>Id </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="id" value=""></td>
			</tr>

			<tr id="username" class="fieldsearch">
			<td>User Name </td>
			<td> 
			<select id="username_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_username">				
				<select name="username" data-name="id" class="form-control search_pop usernameDatas">
					<option value="">Select</option>
				</select>
			</td>
			</tr>

			<tr id="email" class="fieldsearch">
				<td>Email Id </td>
				<td>
					<select id="email_operate" class="form-control oper" name="operate">
						<option value="equal"> = </option>
					</select>
				</td>
				<td id="field_email_total">
					<input type="text" name="email" data-name="email" class="form-control input-sm search_pop" value=""> </td>
			</tr>

			<tr id="status_type" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="status_type_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="status_payment_type">
				<select name="active" class="form-control search_pop" data-name="active">
					<option value=""> -- Select  -- </option>
					<option value="1"> Active	 </option>
					<option value="0"> Inactive </option> 
				</select>
			</td>
		</tr>

		<tr id="admin_phone" class="fieldsearch">
			<td>Phone number </td>
			<td>
				<select id="admin_number_operate" class="form-control oper" name="operate">
					<option value="equal" selected=""> = </option>
				</select>
			</td>
			<td id="field_admin_number">
				<input type="text" name="phone_number" data-name="phone_number" class="form-control input-sm search_pop" value="">
			</td>
		</tr>

		<tr id="login_date" class="fieldsearch">
			<td> Last Login </td>
			<td> 
				<select id="date_operate" class="form-control oper" name="operate">
					<option value="between" selected=""> Between </option>	
				</select> 
			</td>
			<td id="field_date_search">
				<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="last_login" value="" class="form-control search_pop" placeholder="Search Date">
			</td>
		</tr>

		<tr id="created_date" class="fieldsearch">
			<td> Created At </td>
			<td> 
				<select id="date_operate" class="form-control oper" name="operate">
					<option value="between" selected=""> Between </option>	
				</select> 
			</td>
			<td id="created_date_search">
				<input type="text" autocomplete="off" name="createdDate" id="createdDate" data-name="created_at" value="" class="form-control search_pop" placeholder="Search Date">
			</td>
		</tr>

		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>

		</tr>

<?php }?>

<?php if(\Request::route()->getName()=="foodcategories.index"){?>
			<tr id="id" class="fieldsearch">
			<td>Id </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="id" value=""></td>
			</tr>

			<tr id="cat_name" class="fieldsearch">
			<td>Cat Name </td>
			<td> 

			<select id="cat_name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'cat_name')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_cat_name"><input type="text" name="cat_name" class="form-control input-sm search_pop"  data-name="cat_name" data-parsley-required="true" value=""></td>
			</tr>

			<tr>
				<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>

			</tr>
<?php }?>

<?php if (\Request::route()->getName()=='cuisineimg.index') { ?> 

	<tr id="id" class="fieldsearch">
			<!-- <td>Id </td> -->
			<!-- <td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
			</select> 
			</td> -->
			<!-- <td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="id" value=""></td> -->
			</tr>

			<tr id="cat_name" class="fieldsearch">
			<td>Cuisine Name </td>
			<td> 

			<select id="cat_name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'cat_name')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_cat_name"><input type="text" name="cat_name" class="form-control input-sm search_pop"  data-name="name" data-parsley-required="true" value=""></td>
			</tr>

			<tr id="cat_name" class="fieldsearch">
			<td>Title </td>
			<td> 

			<select id="cat_name_operate" class="form-control oper" name="operate">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_cat_name"><input type="text" name="cat_name" class="form-control input-sm search_pop"  data-name="title" data-parsley-required="true" value=""></td>
			</tr>

			<tr>
				<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>

			</tr>
			
<?php } ?>

<?php if (\Request::route()->getName()=='restaurantrating.index') {?>
			<tr id="id" class="fieldsearch">
			<td>Id </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="id" value=""></td>
			</tr>

			<tr id="username" class="fieldsearch">
			<td>Customer Name </td>
			<td> 
			<select id="username_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_username">				
				<select name="username" data-name="cust_id" class="form-control search_pop">
					<option value="">Select</option>
					@if(count($tb_users)>0)
					@foreach($tb_users as $Uky=>$Uval)
					<option value="{!!$Uval->id!!}">{!!$Uval->username!!}</option>
					@endforeach
					@endif
				</select>
			</td>
			</tr>

			<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="id" data-name="res_id" class="form-control input-sm search_pop">
					<option value="">Select Shop name</option>
				@if(count($restaurants)>0)
					@foreach($restaurants as $Rky=>$Rval)
					<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
					@endforeach
				@endif
				</select>
			</td>
			</tr>

			<tr id="id" class="fieldsearch">
			<td>Orderid </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate">
				<option value="equal"> = </option>
			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="orderid" value=""></td>
			</tr>

			<tr id="id" class="fieldsearch">
				<td>Rating </td>
				<td> 
					<select id="id_operate" class="form-control oper" name="operate">
						<option value="equal"> = </option>
						<option value="bigger_equal"> &gt;= </option>
						<option value="smaller_equal"> &lt;= </option>
						<option value="smaller"> &lt; </option>
						<option value="bigger"> &gt; </option>
						<option value="not_null"> ! Null  </option>
						<option value="is_null"> Null </option>
						<option value="between"> Between </option>
						<option value="like"> Like </option>
					</select> 
				</td>
				<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="rating" value=""></td>
			</tr>

			<tr id="id" class="fieldsearch">
				<td>Comments </td>
				<td> 
					<select id="id_operate" class="form-control oper" name="operate">
						<option value="equal"> = </option>
						<option value="not_null"> ! Null  </option>
						<option value="is_null"> Null </option>
						<option value="like"> Like </option>
					</select> 
				</td>
				<td id="field_id"><input type="textarea" name="id" class="form-control input-sm  search_pop"  data-name="comments" value=""></td>
			</tr>

			<tr>
				<td class="text-right" colspan="3"><button type="button" name="search" class="variation_btn btn btn-sm btn-primary"> Search </button></td>

			</tr>

<?php }?>

<?php if (\Request::route()->getName()=='variationunit.index' || \Request::route()->getName()=='foodunit.index') { ?> 
			<tr id="id" class="fieldsearch">
			<td>Id </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm search_pop"  data-name="id"  value=""></td>
		
		</tr>
	
				<tr id="name" class="fieldsearch">
			<td>Name </td>
			<td> 
			<select id="name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'name')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_name"><input type="text" name="name" class="form-control input-sm  search_pop"  data-name="name" value=""></td>
		
		</tr>
	
			<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="variation_btn btn btn-sm btn-primary"> Search </button></td>
		
		</tr>
<?php } ?>

<?php if (\Request::route()->getName()=='variationcolor.index') { ?> 
			<tr id="id" class="fieldsearch">
			<td>Id </td>
			<td> 
			<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_id"><input type="text" name="id" class="form-control input-sm  search_pop"  data-name="id" value=""></td>
		
		</tr>
	
				<tr id="name" class="fieldsearch">
			<td>Name </td>
			<td> 
			<select id="name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'name')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_name"><input type="text" name="name" class="form-control input-sm search_pop"  data-name="name" value="" ></td>
		
		</tr>
	
			<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="variation_btn btn btn-sm btn-primary"> Search </button></td>
		
		</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='brands.index') { ?> 
			<tr id="cat_name" class="fieldsearch">
			<td>Brand Name </td>
			<td> 

			<select id="cat_name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'cat_name')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_cat_name"><input type="text" name="cat_name" class="form-control input-sm search_pop"  data-name="cat_name" data-parsley-required="true" value=""></td>
		
		</tr>
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>
		
		</tr>
<?php } ?>

<?php if (\Request::route()->getName()=='location.index') { ?> 
			 <tr id="name" class="fieldsearch">
			<td>Name </td>
			<td> 
			<select id="name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'name')">
				<option value="equal"> = </option>
				<!-- <option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	 -->

			</select> 
			</td>
			<td id="field_name"><input type="text" name="name" class="form-control input-sm search_pop" data-name="name" value=""></td>
		
		</tr>
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="doSearch btn btn-sm btn-primary"> Search </button></td>
		
		</tr>
<?php } ?>

<?php if (\Request::route()->getName()=='blog.index') { ?> 
			 <tr id="title" class="fieldsearch">
			<td>Title </td>
			<td> 
			<select id="name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'title')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_name"><input type="text" name="title" class="form-control input-sm search_pop" data-name="title" value=""></td>
		
		</tr>

		<tr id="description" class="fieldsearch">
			<td>Description </td>
			<td> 
				<select id="name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'description')">
					<option value="equal"> = </option>
					<option value="bigger_equal"> &gt;= </option>
					<option value="smaller_equal"> &lt;= </option>
					<option value="smaller"> &lt; </option>
					<option value="bigger"> &gt; </option>
					<option value="not_null"> ! Null  </option>
					<option value="is_null"> Null </option>
					<option value="between"> Between </option>
					<option value="like"> Like </option>	

				</select> 
			</td>
			<td id="field_name"><input type="text" name="description" class="form-control input-sm search_pop" data-name="description" value=""></td>

		</tr>

		<tr id="status" class="fieldsearch">
			<td>Status </td>
			<td> 
				<select id="name_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'status')">
					<option value="equal"> = </option>
					<option value="bigger_equal"> &gt;= </option>
					<option value="smaller_equal"> &lt;= </option>
					<option value="smaller"> &lt; </option>
					<option value="bigger"> &gt; </option>
					<option value="not_null"> ! Null  </option>
					<option value="is_null"> Null </option>
					<option value="between"> Between </option>
					<option value="like"> Like </option>	

				</select> 
			</td>
			<td id="field_name"><input type="text" name="status" class="form-control input-sm search_pop" data-name="status" value=""></td>

		</tr>

		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="doSearch btn btn-sm btn-primary"> Search </button></td>
		
		</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='fooditems.index') { ?> 
		@if(\Auth::user()->group_id=='1' || \Auth::user()->group_id == '2')
												
		<tr id="order_id" class="fieldsearch">
			<td>Partner Name </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	
			</select> 
			</td>
			<td id="field_order_id">
				<select name="partner_id" data-name="partner_id" class="form-control input-sm search_pop">
					<option value="">Select partner name</option>
				@if(count($tb_users)>0)
					@foreach($tb_users as $Uky=>$Uval)
					<option value="{!!$Uval->id!!}">{!!$Uval->username!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="id" data-name="id" class="form-control input-sm search_pop">
					<option value="">Select Shop name</option>
				@if(count($restaurants)>0)
					@foreach($restaurants as $Rky=>$Rval)
					<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>
		<tr id="resraurant_name" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="admin_status" data-name="admin_status" class="form-control input-sm search_pop">
					<option value="">Select status</option>
				<option value="waiting">Waiting</option>
				<option value="approved">Approved</option>
				<option value="rejected">Rejected</option>
				</select>
			</td>
		
		</tr>
		<tr id="resraurant_name" class="fieldsearch">
			<td>Mode </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="mode" data-name="mode" class="form-control input-sm search_pop">
					<option value="">Select mode</option>
				<option value="open">Open</option>
				<option value="close">Close</option>
				</select>
			</td>
		
		</tr>
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary res_search_btn order_search_btn"> Search </button></td>		
		</tr>
		@endif
<?php } ?>
<?php if (\Request::route()->getName()=='deliverychargesettings.index') {?>
							<tr id="id" class="fieldsearch">
								<td>Charge type </td>
								<td> 
									<select id="id_operate" class="form-control oper" name="operate" >
										<option value="equal"> = </option>
										<option value="like"> Like </option>	
									</select> 
								</td>
								<td id="field_id"><input type="text" name="id" data-name='charge_type' class="form-control input-sm search_pop" value=""></td>
							</tr>
							<tr id="charge_value" class="fieldsearch">
								<td>Charge Value </td>
								<td> 
									<select id="host_amount_operate" class="form-control oper" name="operate">
										<option value="equal"> = </option>
										<option value="bigger_equal"> &gt;= </option>
										<option value="smaller_equal"> &lt;= </option>
										<option value="smaller"> &lt; </option>
										<option value="bigger"> &gt; </option>
										<option value="not_null"> ! Null  </option>
										<option value="is_null"> Null </option>
										<option value="between"> Between </option>
										<option value="like"> Like </option>	

									</select> 
								</td>
								<td id="field_host_amount"><input type="text" name="del_charge" data-name='charge_value' class="form-control input-sm search_pop" value=""></td>

							</tr>
							{{-- <tr id="del_charge" class="fieldsearch">
								<td>Order Value </td>
								<td> 
									<select id="host_amount_operate" class="form-control oper" name="operate" >
										<option value="equal"> = </option>
										<option value="bigger_equal"> &gt;= </option>
										<option value="smaller_equal"> &lt;= </option>
										<option value="smaller"> &lt; </option>
										<option value="bigger"> &gt; </option>
										<option value="not_null"> ! Null  </option>
										<option value="is_null"> Null </option>
										<option value="between"> Between </option>
										<option value="like"> Like </option>	

									</select> 
								</td>
								<td id="field_host_amount"><input type="text" name="del_charge" data-name='order_value' class="form-control input-sm search_pop" value=""></td>
							</tr>
								<tr id="del_charge" class="fieldsearch">
								<td>Distance </td>
								<td> 
									<select id="host_amount_operate" class="form-control oper" name="operate">
										<option value="equal"> = </option>
										<option value="bigger_equal"> &gt;= </option>
										<option value="smaller_equal"> &lt;= </option>
										<option value="smaller"> &lt; </option>
										<option value="bigger"> &gt; </option>
										<option value="not_null"> ! Null  </option>
										<option value="is_null"> Null </option>
										<option value="between"> Between </option>
										<option value="like"> Like </option>	

									</select> 
								</td>
								<td id="field_host_amount"><input type="text" name="del_charge" data-name='distance' class="form-control input-sm search_pop" value=""></td>
							</tr> --}}
							<tr id="del_charge" class="fieldsearch">
								<td>Tax </td>
								<td> 
									<select id="host_amount_operate" class="form-control oper" name="operate">
										<option value="equal"> = </option>
										<option value="bigger_equal"> &gt;= </option>
										<option value="smaller_equal"> &lt;= </option>
										<option value="smaller"> &lt; </option>
										<option value="bigger"> &gt; </option>
										<option value="not_null"> ! Null  </option>
										<option value="is_null"> Null </option>
										<option value="between"> Between </option>
										<option value="like"> Like </option>	

									</select> 
								</td>
								<td id="field_host_amount"><input type="text" name="del_charge" data-name='tax' class="form-control input-sm search_pop" value=""></td>
							</tr>
							<tr id="del_charge" class="fieldsearch">
								<td>Status </td>
								<td> 
									<select id="host_amount_operate" class="form-control oper" name="operate">
										<option value="equal"> = </option>
									</select> 
								</td>
								<td>
									<select id="host_amount_operate" class="form-control oper search_pop" data-name='status' name="operate">
										<option value=""> Select </option>
										<option value="active"> Active </option>
										<option value="inactive"> Inactive </option>	
									</select> 
								</td>	
							</tr>

							<tr>
								<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>

							</tr>


<?php }?>

<?php if (\Request::route()->getName()=='deliveryboyreport.index') { ?>
<tr id="resraurant_name" class="fieldsearch">
	<td>Delivery Boy</td>
	<td> 
		<select id="boy_name_operate" class="form-control oper" name="operate" ><option value="equal"> = </option>	
		</select> 
	</td>
	<td id="field_boy_name">
		<select name="boy_id" data-name="boy_id" class="form-control input-sm search_pop">
			<option value="">Select boy name</option>
			@if(count($boydetail)>0)
			@foreach($boydetail as $Bky=>$Bval)
			<option value="{!!$Bval->id!!}">{!!$Bval->username!!}</option>
			@endforeach
			@endif
		</select>
	</td>
</tr>
<tr id="id" class="fieldsearch">
	<td>Order Id </td>
	<td> 
		<select id="id_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'id')">
			<option value="equal"> = </option>
			<option value="bigger_equal"> &gt;= </option>
			<option value="smaller_equal"> &lt;= </option>
			<option value="smaller"> &lt; </option>
			<option value="bigger"> &gt; </option>
			<option value="not_null"> ! Null  </option>
			<option value="is_null"> Null </option>
			<option value="between"> Between </option>
			<option value="like"> Like </option>	

		</select> 
	</td>
	<td id="field_id"><input type="text" name="id" data-name='id' class="form-control input-sm search_pop" value=""></td>

</tr>
<tr id="date" class="fieldsearch">
	<td> Date </td>
	<td> 
		<select id="date_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'date')">
			<option value="between" selected=""> Between </option>
		</select> 
	</td>
	<td id="field_date">
		<input type="text" name="date" data-name='date' class="form-control input-sm search_pop" id="searchDate" data-parsley-required="true" > 
		{{-- <input type="hidden" name="sdate" id="sdate" value="">
		<input type="hidden" name="edate" id="edate" value=""> --}}
	</td>
	</tr>
	<tr id="resraurant_name" class="fieldsearch">
		<td>Shop</td>
		<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
			</select> 
		</td>
		<td id="field_resraurant_name">
			<select name="res_id" data-name="res_id" class="form-control input-sm search_pop">
				<option value="">Select shop name</option>
				@if(count($restaurants)>0)
				@foreach($restaurants as $Rky=>$Rval)
				<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
				@endforeach
				@endif
			</select>
		</td>
	</tr>
	<tr id="del_charge" class="fieldsearch">
		<td>Order Value </td>
		<td> 
			<select id="host_amount_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'del_charge')">
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<option value="between"> Between </option>
				<option value="like"> Like </option>
			</select> 
		</td>
		<td id="field_host_amount">
			<input type="text" name="del_charge" data-name='del_charge' class="form-control input-sm oper search_pop" value="">
		</td>
	</tr>
	<tr>
		<td class="text-right" colspan="3">
			<button type="button" name="search" class="order_search_btn advanced_search_btn btn btn-sm btn-primary"> Search </button>
		</td>
	</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='restaurantreport.index') { ?>
	<tr id="id" class="fieldsearch">
													<td>Order No </td>
													<td> 
														<select id="id_operate" class="form-control oper" name="operate">
															<option value="equal"> = </option>
															<option value="bigger_equal"> &gt;= </option>
															<option value="smaller_equal"> &lt;= </option>
															<option value="smaller"> &lt; </option>
															<option value="bigger"> &gt; </option>
															<option value="not_null"> ! Null  </option>
															<option value="is_null"> Null </option>
															<option value="between"> Between </option>
															<option value="like"> Like </option>	

														</select> 
													</td>
													<td id="field_id"><input type="text" name="id" data-name='id' class="form-control input-sm search_pop" value=""></td>

												</tr>
											<tr  id="serach" class="fieldsearch">
												<td>Search Date </td>
												<td>
													<select id="date_search_operate" class="form-control oper" name="operate">
														<option value="between"> Between </option>
													</select>
												</td>
												<td id="field_date_search">
													<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
												</td>
											</tr>
											<tr id="resraurant_name" class="fieldsearch">
												<td>Shop Name </td>
												<td>
													<select id="resraurant_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_resraurant_name">
													<select name="res_id" data-name="res_id" class="form-control input-sm search_pop" > 
													<option value="" selected=""> All </option>
													@if(count($restaurants)>0)
														@foreach($restaurants as $Rky=>$Rval)
														<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
														@endforeach
													@endif
												</select>
											</td>
										</tr>
										{{-- <tr id="partner_email" class="fieldsearch">
											<td>Grand Total </td>
											<td>
												<select id="partner_email_operate" class="form-control oper" name="operate">
													<option value="equal"> = </option>
													<option value="bigger_equal"> &gt;= </option>
													<option value="smaller_equal"> &lt;= </option>
													<option value="smaller"> &lt; </option>
													<option value="bigger"> &gt; </option>
												</select>
											</td>
											<td id="field_partner_email">
												<input type="text" name="grand_total" data-name="grand_total" class="form-control input-sm search_pop" value=""> </td>
											</tr> --}}
											<tr id="cmsn_id" class="fieldsearch">
												<td>Commission Percentage</td>
												<td> 
												<select id="cmsn_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
														<option value="not_null"> ! Null  </option>
														<option value="is_null"> Null </option>
														<option value="between"> Between </option>
														<option value="like"> Like </option>	

													</select> 
												</td>
												<td id="field_id"><input type="text" name="comsn_percentage" data-name='comsn_percentage' class="form-control input-sm search_pop" value=""></td>

											</tr>
											{{-- <tr id="host_amount" class="fieldsearch">
												<td>Net Payable </td>
												<td> 
													<select id="host_amount_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , 'host_amount')">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
														<option value="not_null"> ! Null  </option>
														<option value="is_null"> Null </option>
														<option value="between"> Between </option>
														<option value="like"> Like </option>	

													</select> 
												</td>
												<td id="field_host_amount"><input type="text" name="host_amount" data-name='host_amount' class="form-control input-sm" value=""></td>

											</tr>
 --}}
											<tr>
												<td class="text-right" colspan="3">
													<button type="button" name="search" class="btn btn-sm btn-primary advanced_search_btn order_search_btn"> Search </button>
												</td>
											</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='dailyreport.index') { ?>
	<tr  id="orderid" class="fieldsearch">
												<td>Order Id</td>
												<td>
													<select id="order_id_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="order_id_search">
													<input type="text" autocomplete="off" name="id" id="id" data-name="id" value="" class="form-control search_pop">
												</td>
											</tr>
											<tr  id="serach" class="fieldsearch">
												<td> Date </td>
												<td>
													<select id="date_search_operate" class="form-control oper" name="operate">
														<option value="between"> Between </option>
													</select>
												</td>
												<td id="field_date_search">
													<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
												</td>
											</tr>
											<tr id="partner_name" class="fieldsearch">
												<td>Customer </td>
												<td>
													<select id="partner_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_partner_name">
													<select name="cust_id" data-name="cust_id" class="form-control input-sm search_pop usernameDatas" >
													<option value="" selected=""> All </option>
													</select>
												</td>
											</tr>
											<tr id="resraurant_name" class="fieldsearch">
												<td>Shop </td>
												<td>
													<select id="resraurant_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_resraurant_name">
													<select name="res_id" data-name="res_id" class="form-control input-sm search_pop" > 
													<option value="" selected=""> All </option>
													@if(count($restaurants)>0)
														@foreach($restaurants as $Rky=>$Rval)
														<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
														@endforeach
													@endif
													</select>
												</td>
											</tr>
											<tr id="grand_total" class="fieldsearch">
												<td>Grand Total </td>
												<td>
													<select id="grand_total_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="field_grand_total">
													<input type="text" name="grand_total" data-name="grand_total" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr id="fix_cmsn" class="fieldsearch">
												<td>Fixed Commission</td>
												<td>
													<select id="fix_cmsn_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="field_fix_cmsn">
													<input type="text" name="comsn_percentage" data-name="comsn_percentage" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr id="hike_price" class="fieldsearch" style="display:none;">
												<td>Hiking Price</td>
												<td>
													<select id="hike_price_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="field_hike_price">
													<input type="text" name="hiking" data-name="hiking" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr id="del_chrg" class="fieldsearch">
												<td>Delivery Charge</td>
												<td>
													<select id="del_chrg_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="field_del_chrg">
													<input type="text" name="del_charge" data-name="del_charge" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr id="payment_mode" class="fieldsearch">
												<td>Mode Of Payment </td>
												<td>
													<select id="resraurant_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_payment_mode">
													<select name="delivery_type" data-name="delivery_type" class="form-control input-sm search_pop" > 
													<option value="" selected=""> All </option>
														<option value="cashondelivery">Cashondelivery</option>
														<option value="razorpay">Razorpay</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="text-right" colspan="3">
													<button type="button" name="search" class="btn btn-sm btn-primary order_search_btn advanced_search_btn"> Search </button>
												</td>
											</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='weeklypaymentfordeliveryboy.index') { ?>
	<tr  id="boyid" class="fieldsearch">
												<td> Id</td>
												<td>
													<select id="boy_id_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="boy_id_search">
													<input type="text" autocomplete="off" name="id" id="id" data-name="id" value="" class="form-control search_pop">
												</td>
											</tr>
											<tr  id="serach" class="fieldsearch">
												<td> Date </td>
												<td>
													<select id="date_search_operate" class="form-control oper" name="operate">
														<option value="between"> Between </option>
													</select>
												</td>
												<td id="field_date_search">
													<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
												</td>
											</tr>
											<tr id="boy_name" class="fieldsearch">
												<td>Name </td>
												<td>
													<select id="boy_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_boy_name">
													<select name="id" data-name="id" class="form-control input-sm search_pop" >
													<option value="" selected=""> All </option>
													@if(count($rowData)>0)
														@foreach($rowData as $Uky=>$Uval)
														<option value="{!!$Uval->id!!}">{!!$Uval->username!!}</option>
														@endforeach
													@endif
													</select>
												</td>
											</tr>
											<tr id="resraurant_name" class="fieldsearch">
												<td>Phone number </td>
												<td>
													<select id="resraurant_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_resraurant_name">
													<input type="text" name="phone_number" data-name="phone_number" class="form-control input-sm search_pop" value="">
												</td>
											</tr>
											<tr id="email" class="fieldsearch">
												<td>Email Id </td>
												<td>
													<select id="email_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
													</select>
												</td>
												<td id="field_email_total">
													<input type="text" name="email" data-name="email" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr>
												<td class="text-right" colspan="3">
													<button type="button" name="search" class="btn btn-sm btn-primary order_search_btn advanced_search_btn"> Search </button>
												</td>
											</tr>
<?php } ?>

<?php if (\Request::route()->getName()=='weeklypaymentforhost.index') { ?>
	<tr  id="serach" class="fieldsearch">
												<td> Date </td>
												<td>
													<select id="date_search_operate" class="form-control oper" name="operate">
														<option value="between"> Between </option>
													</select>
												</td>
												<td id="field_date_search">
													<input type="text" autocomplete="off" name="searchDate" id="searchDate"  value="" data-name="date" class="form-control search_pop" placeholder="Search Date">
												</td>
											</tr>
											<tr  id="orderid" class="fieldsearch">
												<td>Id</td>
												<td>
													<select id="order_id_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
														<option value="bigger_equal"> &gt;= </option>
														<option value="smaller_equal"> &lt;= </option>
														<option value="smaller"> &lt; </option>
														<option value="bigger"> &gt; </option>
													</select>
												</td>
												<td id="order_id_search">
													<input type="text" autocomplete="off" name="id" id="id" data-name="id" value="" class="form-control search_pop">
												</td>
											</tr>
											<tr id="partner_name" class="fieldsearch">
												<td>Vendor Name </td>
												<td>
													<select id="partner_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												<td id="field_partner_name">
													<select name="cust_id" data-name="id" class="form-control input-sm search_pop" >
													<option value="" selected=""> All </option>
													@if(count($tb_users)>0)
														@foreach($tb_users as $Uky=>$Uval)
														<option value="{!!$Uval->id!!}">{!!$Uval->username!!}</option>
														@endforeach
													@endif
													</select>
												</td>
											</tr>
											<tr id="resraurant_name" class="fieldsearch">
												<td>Shop Name </td>
												<td>
													<select id="resraurant_name_operate" class="form-control oper" name="operate" readonly>
														<option value="equal" selected=""> = </option>
													</select>
												</td>
												 
												<td id="field_resraurant_name">
													<select name="res_id" data-name="id" class="form-control input-sm search_pop" > 
													<option value="" selected=""> All </option>
													@if(count($restaurants)>0)
														@foreach($restaurants as $Rky=>$Rval)
														<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
														@endforeach
													@endif
													</select>
												</td>
											</tr>
											<tr id="email" class="fieldsearch">
												<td>Email Id</td>
												<td>
													<select id="email_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
													</select>
												</td>
												<td id="field_email">
													<input type="text" name="email" data-name="email" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr id="phone_number" class="fieldsearch">
												<td>Phone number</td>
												<td>
													<select id="phone_number_operate" class="form-control oper" name="operate">
														<option value="equal"> = </option>
													</select>
												</td>
												<td id="field_phone_number">
													<input type="text" name="phone_number" data-name="phone_number" class="form-control input-sm search_pop" value=""> </td>
											</tr>
											<tr>
												<td class="text-right" colspan="3">
													<button type="button" name="search" class="btn btn-sm btn-primary order_search_btn advanced_search_btn"> Search </button>
												</td>
											</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='refundinfo.index') { ?>
	<tr  id="orderid" class="fieldsearch">
				<td>Order Id</td>
				<td>
					<select id="order_id_operate" class="form-control oper" name="operate">
						<option value="equal"> = </option>
						<option value="bigger_equal"> &gt;= </option>
						<option value="smaller_equal"> &lt;= </option>
						<option value="smaller"> &lt; </option>
						<option value="bigger"> &gt; </option>
					</select>
				</td>
				<td id="order_id_search">
					<input type="text" autocomplete="off" name="id" id="id" data-name="id" value="" class="form-control search_pop">
				</td>
			</tr>
			<tr  id="serach" class="fieldsearch">
				<td> Date </td>
				<td>
					<select id="date_search_operate" class="form-control oper" name="operate">
						<option value="between"> Between </option>
					</select>
				</td>
				<td id="field_date_search">
					<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
				</td>
			</tr>
			<tr>
				<td class="text-right" colspan="3">
					<button type="button" name="search" class="btn btn-sm btn-primary order_search_btn advanced_search_btn"> Search </button>
				</td>
			</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='cashondeliveryorder.index') { ?>
	<tr id="order_id" class="fieldsearch">
			<td>Order ID </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_id"><input type="text" name="id" data-name="id" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="partner_name" class="fieldsearch">
			<td>Customer Name </td>
			<td> 
			<select id="partner_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_name"><!-- <input type="text" name="cust_id" data-name="cust_id" class="form-control input-sm search_pop" value=""></td> -->

				<select name="username" data-name="cust_id" class="form-control search_pop">
					<option value="">Select</option>
					@if(count($tb_users)>0)
					@foreach($tb_users as $Uky=>$Uval)
					<option value="{!!$Uval->id!!}">{!!$Uval->username!!}</option>
					@endforeach
					@endif
				</select>
			
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="id" data-name="res_id" class="form-control input-sm search_pop">
					<option value="">Select shop name</option>
					@if(count($restaurants)>0)
					@foreach($restaurants as $Rky=>$Rval)
					<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>		

		<tr id="partner_email" class="fieldsearch">
			<td>Grand Total </td>
			<td> 
			<select id="partner_email_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_email"><input type="text" name="grand_total" data-name="grand_total" class="form-control input-sm search_pop" value=""></td>
		
		</tr>				

		<tr id="payment_type" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="payment_type_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_payment_type">
				<select name="payment_type" class="form-control search_pop" data-name="status">
					<option value=""> -- Select  -- </option>
					<option value="1"> Accepted	 </option>
					<option value="2"> Accept By Boy	 </option>
					<option value="3"> Order Dispatch </option> 
					<option value="4"> Order Finished </option> 
					<option value="5"> Rejected </option> 
					<option value="6"> Pending </option> 					
				</select>
			</td>		
		</tr>
		
		<tr  id="serach" class="fieldsearch">
		<td> Date </td>
		<td>
			<select id="date_search_operate" class="form-control oper" name="operate">
				<option value="between"> Between </option>
			</select>
		</td>
		<td id="field_date_search">
			<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
		</td>
	</tr>

		<tr id="time" class="fieldsearch">
			<td>Payment status </td>
			<td> 
			<select id="time_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_payment_type">
				<select name="payment_type" class="form-control search_pop" data-name="delivery">
					<option value=""> -- Select  -- </option>
					<option value="paid"> Paid	 </option>
					<option value="unpaid"> Unpaid </option> 					
				</select>
			</td>	
		
		</tr>							
		
		<tr id="order_details" class="fieldsearch">
			<td>Order Details </td>
			<td> 
			<select id="order_details_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_details"><input type="text" name="order_details" data-name="order_details" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary order_search_btn"> Search </button></td>		
		</tr>
<?php } ?>

<?php if (\Request::route()->getName()=='paymentorders.index') { ?>
	<tr id="order_id" class="fieldsearch">
			<td>Order ID </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_id"><input type="text" name="id" data-name="id" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="partner_name" class="fieldsearch">
			<td>Customer Name </td>
			<td> 
			<select id="partner_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_name">
				<!-- <input type="text" name="cust_id" data-name="cust_id" class="form-control input-sm search_pop" value=""> -->
				<select name="cust_id" data-name="cust_id" class="form-control search_pop select2">
				<option value="">Select</option>
				@if(count($tb_users)>0)
				@foreach($tb_users as $Uky=>$Uval)
				<option value="{!!$Uval->id!!}">{!!$Uval->username!!} - {!!$Uval->phone_number!!}</option>
				@endforeach
				@endif
			</select>
			</td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_resraurant_name"><input type="text" name="res_id" data-name="res_id" class="form-control input-sm search_pop" value=""></td>
		
		</tr>		

		<tr id="partner_email" class="fieldsearch">
			<td>Grand Total </td>
			<td> 
			<select id="partner_email_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_email"><input type="text" name="grand_total" data-name="grand_total" class="form-control input-sm search_pop" value=""></td>
		
		</tr>				

		<tr id="payment_type" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="payment_type_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
		</td>
		<td id="field_payment_type">
			<select name="payment_type" class="form-control search_pop" data-name="status">
				<option value=""> -- Select  -- </option>
				<option value="1"> Accepted	 </option>
				<option value="2"> Accept By Boy	 </option>
				<option value="3"> Order Dispatch </option> 
				<option value="4"> Order Finished </option> 
				<option value="5"> Rejected </option> 
				<option value="6"> Pending </option> 					
			</select>
		</td>		
	</tr>

	<tr  id="serach" class="fieldsearch">
		<td> Date </td>
		<td>
			<select id="date_search_operate" class="form-control oper" name="operate">
				<option value="between"> Between </option>
			</select>
		</td>
		<td id="field_date_search">
			<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
		</td>
	</tr>

	<tr id="time" class="fieldsearch">
		<td>Payment status </td>
		<td> 
			<select id="time_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_payment_type">
				<select name="payment_type" class="form-control search_pop" data-name="delivery">
					<option value=""> -- Select  -- </option>
					<option value="paid"> Paid	 </option>
					<option value="unpaid"> Unpaid </option> 					
				</select>
			</td>	
		
		</tr>							
		
		<tr id="order_details" class="fieldsearch">
			<td>Order Details </td>
			<td> 
			<select id="order_details_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_details"><input type="text" name="order_details" data-name="order_details" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary order_search_btn"> Search </button></td>		
		</tr>
<?php } ?>


<?php if (\Request::route()->getName()=='orderdetails.index') { ?>
	<tr id="time" class="fieldsearch">
			<td>Date </td>
			<td> 
			<select id="time_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_time"><input type="text" name="time" data-name="date" class="date_search form-control input-sm search_pop" value=""> </td>
		
		</tr>												
		
		<tr id="order_id" class="fieldsearch">
			<td>Order ID </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_id"><input type="text" name="order_id" data-name="id" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_resraurant_name"><input type="text" name="resraurant_name" data-name="name" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="partner_name" class="fieldsearch">
			<td>Partner Name </td>
			<td> 
			<select id="partner_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_name"><input type="text" name="partner_name" data-name="username" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="partner_email" class="fieldsearch">
			<td>Partner Email </td>
			<td> 
			<select id="partner_email_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_email"><input type="text" name="partner_email" data-name="email" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="cus_name" class="fieldsearch">
			<td>Customer Name </td>
			<td> 
			<select id="cus_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_cus_name"><input type="text" name="cus_name" data-name="cus_name" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="cus_email" class="fieldsearch">
			<td>Customer Email </td>
			<td> 
			<select id="cus_email_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_cus_email"><input type="text" name="cus_email" data-name="cus_email" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="order_details" class="fieldsearch">
			<td>Order Details </td>
			<td> 
			<select id="order_details_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_details"><input type="text" name="order_details" data-name="order_details" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="payment_type" class="fieldsearch">
			<td>Payment Type </td>
			<td> 
			<select id="payment_type_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_payment_type">
				<select name="payment_type" class="form-control search_pop" data-name="delivery_type">
					<option value=""> -- Select  -- </option>
					<option value="1"> Cash on delivery	 </option>
					<option value="0"> Ccavenue </option> 
				</select>
			</td>
		
		</tr>
						
	
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary order_search_btn"> Search </button></td>		
		</tr>
<?php } ?>



<?php if (\Request::route()->getName()=='restaurant.index') { ?> 
		@if(\Auth::user()->group_id=='1' || \Auth::user()->group_id == '2')
				
		<tr id="order_id" class="fieldsearch">
			<td>Partner Name </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_order_id">
				<select name="partner_id" data-name="partner_id" class="form-control input-sm search_pop">
					<option value="">Select partner name</option>
				@if(count($tb_users)>0)
					@foreach($tb_users as $Uky=>$Uval)
					<option value="{!!$Uval->id!!}">{!!$Uval->username!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="id" data-name="id" class="form-control input-sm search_pop">
					<option value="">Select shop name</option>
				@if(count($restaurants)>0)
					@foreach($restaurants as $Rky=>$Rval)
					<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>
		@endif
		<tr id="resraurant_name" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="admin_status" data-name="admin_status" class="form-control input-sm search_pop">
					<option value="">Select status</option>
				<option value="waiting">Waiting</option>
				<option value="approved">Approved</option>
				<option value="rejected">Rejected</option>
				</select>
			</td>
		
		</tr>
		<tr id="resraurant_name" class="fieldsearch">
			<td>Mode </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="mode" data-name="mode" class="form-control input-sm search_pop">
					<option value="">Select mode</option>
				<option value="open">Open</option>
				<option value="close">Close</option>
				</select>
			</td>
		
		</tr>
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary res_search_btn"> Search </button></td>		
		</tr>
<?php }?>

<?php if (\Request::route()->getName()=='customer.index') { ?> 
		<tbody>	
			<tr id="time" class="fieldsearch">
				<td>Customer ID </td>
				<td> 
					<select id="time_operate" class="form-control oper" name="operate" >
						<option value="equal"> = </option>
						<option value="bigger_equal"> &gt;= </option>
						<option value="smaller_equal"> &lt;= </option>
						<option value="smaller"> &lt; </option>
						<option value="bigger"> &gt; </option>
						<option value="not_null"> ! Null  </option>
						<option value="is_null"> Null </option>
						<option value="like"> Like </option>	
					</select> 
				</td>
				<td id="field_time"><input type="text" name="id" data-name="id" class="date_search form-control input-sm search_pop" value=""> </td>
			</tr>	
			<tr id="order_id" class="fieldsearch">
				<td>User Name </td>
				<td> 
					<select id="order_id_operate" class="form-control oper" name="operate" >
						<option value="equal"> = </option>
						<option value="bigger_equal"> &gt;= </option>
						<option value="smaller_equal"> &lt;= </option>
						<option value="smaller"> &lt; </option>
						<option value="bigger"> &gt; </option>
						<option value="not_null"> ! Null  </option>
						<option value="is_null"> Null </option>
						<option value="like"> Like </option>
					</select> 
				</td>
				<td id="field_order_id">
					<select name="username" data-name="id" class="form-control search_pop usernameDatas">
						<option value=" ">Select</option>
					</select>
				</td>
			</tr>

			<tr id="resraurant_name" class="fieldsearch">
				<td>Email </td>
				<td> 
					<select id="resraurant_name_operate" class="form-control oper" name="operate" >
						<option value="equal"> = </option>
						<option value="bigger_equal"> &gt;= </option>
						<option value="smaller_equal"> &lt;= </option>
						<option value="smaller"> &lt; </option>
						<option value="bigger"> &gt; </option>
						<option value="not_null"> ! Null  </option>
						<option value="is_null"> Null </option>
						<option value="like"> Like </option>
					</select> 
				</td>
				<td id="field_resraurant_name"><input type="text" name="email" data-name="email" class="form-control input-sm search_pop" value=""></td>
			</tr>
			<tr id="partner_name" class="fieldsearch">
				<td>Phone Number </td>
				<td> 
					<select id="partner_name_operate" class="form-control oper" name="operate" >
						<option value="equal"> = </option>
						<option value="bigger_equal"> &gt;= </option>
						<option value="smaller_equal"> &lt;= </option>
						<option value="smaller"> &lt; </option>
						<option value="bigger"> &gt; </option>
						<option value="not_null"> ! Null  </option>
						<option value="is_null"> Null </option>
						<option value="like"> Like </option>
					</select> 
				</td>
				<td id="field_partner_name"><input type="text" name="phone_number" data-name="phone_number" class="form-control input-sm search_pop" value=""></td>
			</tr>	
			<tr id="address" class="fieldsearch">
				<td>Address </td>
				<td> 
					<select id="partner_name_operate" class="form-control oper" name="operate" >
						<option value="like"> Like </option>	
					</select> 
				</td>
				<td id="field_address"><input type="text" name="address" data-name="address" class="form-control input-sm search_pop" value=""></td>
			</tr>	
			<tr  id="serach" class="fieldsearch">
				<td> Date </td>
				<td>
					<select id="date_search_operate" class="form-control oper" name="operate">
						<option value="between"> Between </option>
					</select>
				</td>
				<td id="field_date_search">
					<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="created_at" value="" class="form-control search_pop" placeholder="Search Date">
				</td>
			</tr>	
			<tr>
				<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary order_search_btn"> Search </button></td>		
			</tr>
		</tbody>  
<?php }?>


<?php if (\Request::route()->getName()=='partners.index') { ?> 
		<tbody>			
	
		<tr id="time" class="fieldsearch">
			<td>Partner ID </td>
			<td> 
			<select id="time_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_time"><input type="text" name="id" data-name="id" class="date_search form-control input-sm search_pop" value=""> </td>
		
		</tr>	
		<tr id="order_id" class="fieldsearch">
			<td>User Name </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_id">
				<select name="username" data-name="id" class="form-control search_pop usernameDatas">
					<option value="">Select</option>
				</select>
			</td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Email </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_resraurant_name"><input type="text" name="email" data-name="email" class="form-control input-sm search_pop" value=""></td>
		
		</tr>
		<tr id="partner_name" class="fieldsearch">
			<td>Phone Number </td>
			<td> 
			<select id="partner_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_name"><input type="text" name="phone_number" data-name="phone_number" class="form-control input-sm search_pop" value=""></td>		
		</tr>		
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary order_search_btn"> Search </button></td>		
		</tr>
	</tbody> 
<?php }?>

<?php if (\Request::route()->getName()=='deliveryboy.index') { ?> 
		<tbody>			
	
		<tr id="time" class="fieldsearch">
			<td>Boy ID </td>
			<td> 
			<select id="time_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	
			</select> 
			</td>
			<td id="field_time"><input type="text" name="id" data-name="id" class="date_search form-control input-sm search_pop" value=""> </td>
		
		</tr>														
		<tr id="order_id" class="fieldsearch">
			<td>User Name </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_order_id">				
				<select name="username" data-name="id" class="form-control search_pop usernameDatas">
					<option value="">Select</option>
				</select>
			</td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Email </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_resraurant_name"><input type="text" name="email" data-name="email" class="form-control input-sm search_pop" value=""></td>
		
		</tr>

		<tr id="partner_name" class="fieldsearch">
			<td>Phone Number </td>
			<td> 
			<select id="partner_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_partner_name"><input type="text" name="phone_number" data-name="phone_number" class="form-control input-sm search_pop" value=""></td>
		
		</tr>		

		<tr id="payment_type" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="payment_type_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>
				<option value="bigger_equal"> &gt;= </option>
				<option value="smaller_equal"> &lt;= </option>
				<option value="smaller"> &lt; </option>
				<option value="bigger"> &gt; </option>
				<option value="not_null"> ! Null  </option>
				<option value="is_null"> Null </option>
				<!-- <option value="between"> Between </option> -->
				<option value="like"> Like </option>	

			</select> 
			</td>
			<td id="field_payment_type">
				<select name="active" class="form-control search_pop" data-name="active">
					<option value=""> -- Select  -- </option>
					<option value="1"> Active	 </option>
					<option value="0"> Inactive </option> 
				</select>
			</td>
		
		</tr>
		<tr id="payment_type" class="fieldsearch">
			<td>Mode status </td>
			<td> 
			<select id="payment_type_operate" class="form-control oper" name="operate" >
				<option value="equal" selected=""> = </option>

			</select> 
			</td>
			<td id="field_payment_type">
				<select name="online_sts" class="form-control search_pop" data-name="online_sts">
					<option value=""> -- Select  -- </option>
					<option value="1"> Online	 </option>
					<option value="0"> Offline </option> 
				</select>
			</td>
		
		</tr>
						
	
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary order_search_btn"> Search </button></td>		
		</tr>
	</tbody>
<?php }?>

<?php if(\Request::route()->getName()=="rejectedorders.index") {?>
			
		<tr id="created_date" class="fieldsearch">
			<td> Created At </td>
			<td> 
				<select id="date_operate" class="form-control oper" name="operate">
					<option value="between" selected=""> Between </option>	
				</select> 
			</td>
			<td id="created_date_search">
				<input type="text" autocomplete="off" name="createdDate" id="createdDate" data-name="created_at" value="" class="form-control search_pop" placeholder="Search Date">
			</td>
		</tr>

		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search" class="order_search_btn btn btn-sm btn-primary"> Search </button></td>

		</tr>

<?php }?>

	</table>
</form>	
</div>
</div>
  </div>
</div>
</div>


<script type="text/javascript" src="{{ asset('sximo5/js/front/abserve.js') }}"></script>
<link rel="stylesheet" type="text/css" media="all" href="{{url('sximo5/css/admin/daterangepicker/daterangepicker.css') }}" />
<script type="text/javascript" src="{{url('sximo5/js/admin/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{url('sximo5/js/admin/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">

$(document).ready(function(){
	$('#searchDate,#createdDate').daterangepicker({
		"ranges": {
	        "Today": [
	            new Date(),
	            new Date()
	        ],
	        "Yesterday": [
	            new Date().setDate(new Date().getDate() - 1),
	            new Date().setDate(new Date().getDate() - 1)
	        ],
	        "Last Week": [
	            new Date().setDate(new Date().getDate() - 6),
	            new Date()
	        ],	        	        
	        "Last Month": [
	            new Date(new Date().getFullYear(), new Date().getMonth()-1, 1),
	            new Date(new Date().getFullYear(), new Date().getMonth(), 0)
	        ],
	        "This Month": [
	            new Date(new Date().getFullYear(), new Date().getMonth(), 1),
	            new Date()
	        ]
	    },	    
	    "autoApply": true,	    
	    "showCustomRangeLabel": true,	    	    
	    "maxDate": new Date(),
	    "locale": {
	      "format": 'Y-MM-DD',
	      "separator":':'
	    }
	}, function(start, end, label) {	  
	  var start_date = $.datepicker.formatDate('yy-mm-dd', start._d);  	  
	  var end_date = $.datepicker.formatDate('yy-mm-dd', end._d);  	  	  	  	  
	  $('#sdate').val(start_date);
	  $('#edate').val(end_date);     
	});	

	var sDate = $('#sdate').val();
	var eDate = $('#edate').val();     

	if(sDate != undefined && eDate != undefined ){		
		$('#searchDate').data('daterangepicker').setStartDate(sDate);
		$('#searchDate').data('daterangepicker').setEndDate(eDate);
	}else{
		$('#searchDate').val('');
		$('#createdDate').val('');
	}	

});
$(".search_pop_btn").on('click', function(){ 
		$('.loaderOverlay').show();  
		var page = $(this).attr('page');
		var type = (page == 'deliveryboy') ? 'deliveryboy' : 'users';
		var group_id = (page == 'deliveryboy') ? 5 : (page == 'partner') ? 3 : (page == 'subadmin') ? 2 : 4; 
    	$.ajax({
			url: 'user/userdatas',
			type: 'post',
			dataType : 'json',
			data: { group_id : group_id, type : type },
			success:function(res){
				var count = res.datas.length;
				$('.usernameDatas').html('<option value="">Select</option>');
				$.each(res.datas, function(key,value){
					$('.usernameDatas').append('<option value="'+value.id+'">'+value.username+'</option>');
					if(!--count){
						$('.loaderOverlay').hide();
						$('#abserve-modal').modal('show');
					}
				});
				if(count == 0){
					$('.loaderOverlay').hide();
					$('#abserve-modal').modal('show');
				}
			}
		});
	});
$(document).on('click','.order_search_btn,.variation_btn',function(){
	var search_val,oper,name,search = '';
	var url = window.location.origin + window.location.pathname;
	$('.fieldsearch').each(function(){
		search_val = $(this).find('.search_pop').val();
		oper = $(this).find('.oper').val();
		name = $(this).find('.search_pop').data('name');
		console.log(name);
		if(search_val != ''){
			search +=  name+':'+oper+':'+search_val+'|';
		}
	});
	window.location.href = url+'?search='+search;
});

</script>	