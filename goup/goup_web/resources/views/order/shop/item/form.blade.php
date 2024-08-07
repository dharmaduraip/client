{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Item') }}</h6>
        </div>
        <div class="form_pad">
        <form class="validateForm" files="true"> 
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
                <input type="hidden" name="store_id" value="{{$store_id}}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="item_name">{{ __('store.admin.item.name') }}</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="{{ __('store.admin.item.name') }}" maxlength="50" value="">
                    </div>
                    <div class="form-group col-md-6">
                     <label for="picture">{{ __('admin.picture') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="picture" class="upload-btn picture_upload">
                        </div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="item_description">@lang('store.admin.item.description')</label>
                        <textarea class="form-control" placeholder="{{ __('store.admin.item.description') }}" id="item_description" maxlength="100" name="item_description"></textarea>
                        <small>(Maximum characters: 100)</small>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="item_discount_type">@lang('store.admin.item.discount_type')</label>
                      <select class="form-control" name="item_discount_type">
                      <option value="PERCENTAGE"> PERCENTAGE </option>
                      <option value="AMOUNT"> AMOUNT </option>
                      </select>
                    </div>
                </div>  
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="store_category_description">@lang('store.admin.item.category')</label>
                      <select class="form-control" name="store_category_id" id="store_category_id">
                      <option value="">Select</option>
                      </select>
                    </div>
                    <div id="is_veg" class="form-group col-md-6 d-none">
                    <label class="mr-2"><input type="radio"  class="is_veg" value = "Pure Veg" name="is_veg"> {{ __('store.admin.shops.veg') }}</label>
                      <label><input type="radio" class="is_veg"value = "Non Veg" name="is_veg"> {{ __('store.admin.shops.nonveg') }}</label>
                    </div>
                </div> 

                <div class="form-row" id="quantitylist">
                    <div class="form-group col-md-6">
                    <label for="quantity">{{ __('store.admin.item.quantity') }}</label>
                        <input type="text" class="form-control numbers" id="quantity" name="quantity" placeholder="{{ __('store.admin.item.quantity') }}" value="">
                    </div>
                    <div class="form-group col-md-6">
                     <label for="low_stock">{{ __('store.admin.item.low_stock') }}</label>
                        <input type="text" class="form-control numbers" id="low_stock" name="low_stock" placeholder="{{ __('store.admin.item.low_stock') }}" value="">
                    </div>
                   

                </div> 

                 <div class="form-row">
                <div class="form-group col-md-6">
                       
                        <label for="item_discount">{{ __('store.admin.item.discount') }}</label>
                        <input type="number" class="form-control decimal" id="item_discount" name="item_discount" placeholder="{{ __('store.admin.item.discount') }}" value="">
                        
                    </div>
                    <div class="form-group col-md-6">
                    <label for="item_price">{{ __('store.admin.item.price') }}</label>
                        <input type="number" class="form-control decimal" id="item_price" name="item_price" placeholder="{{ __('store.admin.item.price') }}" value="">
                    </div>
                   

				</div> 
             <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('store.admin.cuisine.status')</label>
						<select name="status" id="status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
                    <div class="form-group col-md-6" >
                        <label for="unit" class="col-xs-2 col-form-label">{{ __('store.admin.item.unit') }}</label>
                        <select class="form-control" name="unit" id="unit">
                            <option value="">Select</option>
                        </select>
                    </div>
				</div>
                
                <div id="addon_list">
                    <label for="addon_list"><h4>@lang('store.admin.item.addon_list')</h4></label>
                    <div class="form-row addon_list" >
                    </div>

                </div>

                <br>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Item') }}</button>                
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>



<script>
$(document).ready(function()
{
    basicFunctions();
    var id = "";

    var blobImage = '';
    var blobName = '';  

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
      var obj = $(this);
      if (files && files.length > 0) {
        blobName = files[0].name;
         cropImage(obj, files[0], obj.closest('.image-placeholder').find('img'), function(data) {
            blobImage = data;
         });
      }
    });
    var item_id = ( $("input[name=id]").length ) ? "/"+ $("input[name=id]").val() : '';
    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/shop/addonslist/"+{{$store_id}} + item_id,
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
            $('.addon_list').html("");

                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                      
                  $(".addon_list").append('<div class="form-group col-md-6"><p><input type="checkbox" class="addon'+item.id+'" name="addon[]" value='+item.id+'>'+item.addon_name+'</p>Price<input type="number" class="form-control decimal addonprice'+item.id+'" name="addon_price['+item.id+']" value="0"></div>');
                  }else{
                    $(".addon_list").append('<p>No Addon List For This Store</p>');  
                  }
                });               
                
                hideInlineLoader();
        }
            
       });


    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/shop/units",
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
            $('select[name=unit]').html('<option value="">Select</option>');

                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                    $("select[name=unit]").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                  }
                });               
                
                hideInlineLoader();
        }
            
       });

       
    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/shop/categorylist/"+{{$store_id}},
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
                $("#store_category_id").empty();
                $("#store_category_id").append('<option value="">Select</option>');
                if(data.responseData.length != 0){
                    $.each(data.responseData,function(key,item){
                    $("#store_category_id").append('<option value="'+item.id+'">'+item.store_category_name+'</option>');
                    
                    });
                    if(data.responseData[0].store.storetype.category =="FOOD"){
                        $('#is_veg').removeClass('d-none');
                        $('#addon_list').show();
                        $('#quantitylist').hide();
                     }else{
                        $('#addon_list').hide();
                        $('#quantitylist').show();
                        $("#is_veg").rules('remove', 'required'); 
                    }
                }
                hideInlineLoader();
             }
            
    });

   if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/shop/items"+id;
        setTimeout(function(){  
            $.ajax({
            type:"GET",
            url: url,
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            'beforeSend': function (request) {
                    showInlineLoader();
                },
            success:function(response){
                var data = parseData(response).responseData;
                console.log(data);
                for (var i in Object.keys(data)) {
                $('#'+Object.keys(data)[i]).val( Object.values(data)[i]);
                }
                $("select[name=unit] option[value='" +data.unit_id+ "']" ).attr("selected",true);
                $("input[name='is_veg'][value='"+data.is_veg+"']").prop('checked', true);
                if(data.picture){ 
                    $('.image-placeholder img').attr('src', data.picture);
                }
                //$( "#status" ).prop( "selected", true );
                if(data.itemsaddon.length !=0){
                    $.each(data.itemsaddon,function(key,val){
                        $('.addon'+val.store_addon_id).val(val.store_addon_id).attr('checked',true);
                        $('.addonprice'+val.store_addon_id).val(val.price);
                    });
                }
                hideInlineLoader();
             }
             });
           }, 800);

     }



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            item_name: { required: true },
            store_category_id: { required: true },
            is_veg: { required: true },
            item_price: { required: true },
          
		},

		messages: {
			item_name: { required: "Item Name is required." },
			store_category_id: { required: "Category is required." },
			is_veg: { required: "Veg is required." },
			item_price: { required: " Price is required." },
           

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form) {

            var data = new FormData();

            var formGroup = $(".validateForm").serialize().split("&");

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append(decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            var url = getBaseUrl() + "/shop/items"+id;

            saveRow( url, table, data,'shop');

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
  

});
</script>
