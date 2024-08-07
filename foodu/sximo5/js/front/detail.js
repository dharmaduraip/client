function removeCartItem(iItemId){
    $.ajax({
        url: base_url+'removecartitem',
        type: "GET",
        data: {'iItemId':iItemId},
        success: function(data){
            cart_data=$.parseJSON(data);
            if(jQuery.isEmptyObject(cart_data)){
                cart_res_id=0;
            }
            setCartHtml();
        }
    });
}

function setCartItems(iItemId,iItemCount) {
    var res_id = $("#res_id").val();
    if(cart_res_id==0 || cart_res_id==res_id) {
        add_to_cart(iItemId,iItemCount);
    } else {
        $.confirm({
            title: 'Items already in cart',
            content: 'Your cart contains items from other shop. Would you like to reset your cart for adding items from this shop?',
            buttons: {
                no:{
                    text: 'No',
                    btnClass: 'btn-no',
                    keys: ['esc'],
                    action: function(){
                    }
                },
                confirm: {
                    text: 'Yes, start afresh',
                    btnClass: 'btn-yes',
                    keys: ['enter'],
                    action: function(){ 
                        add_to_cart(iItemId,iItemCount,true);
                    }
                }
            }
        });
    }
}

function setItemLists(){  
    if($('#check'). is(":checked")){
        $('.cat_content').each(function(){
            var iItemCnt=0;
            $(this).find('.veg_item').each(function(){
                iItemCnt++;
            })            
            $(this).find('.itemss').html(iItemCnt+' ITEMS')
            if(iItemCnt==0) {
                $(this).hide()
            } else {
                $(this).show()
            }
        });
        $('.cat_content .non_veg_item').hide();
    } else {
        $('.cat_content').each(function(){
            var iItemCnt=0;
            $(this).find('.veg_item').each(function(){
                iItemCnt++;
            })
            $(this).find('.non_veg_item').each(function(){
                iItemCnt++;
            })
            $(this).find('.itemss').html(iItemCnt+' ITEMS')
            if(iItemCnt==0) {
                $(this).hide()
            } else {
                $(this).show()
            }
        });
        $('.cat_content .non_veg_item').show();
    }
}

function getSearchfilterValues(arr,part){
    var returnData=[];
    var returnValue={};
    var vegstatus='';
    part=part.toLowerCase();
    if(part=='non' || part=='non-' || part=='non ' || part=='non-v' || part=='non v' || part=='non-ve' || part=='non ve' || part=='non-veg' || part=='non veg'|| part=='nonv'|| part=='nonve'|| part=='nonveg')
        vegstatus='nonveg';

    $.each(arr,function(index,value){
        var status=false;
        if(value.item_name.toLowerCase().indexOf(part)!== -1) {
            status=true;
        } else if(value.description.toLowerCase().indexOf(part)!== -1) {
            status=true;
        } else if(value.Main_cat.toLowerCase().indexOf(part)!== -1) {
            status=true;
        } else if(value.Sub_cat.toLowerCase().indexOf(part)!== -1) {
            status=true;
        } else if(value.status.toLowerCase()== vegstatus) {
            status=true;
        }
        if(status==true){
            var str=value.item_name;
            value.item_name=str.replace('``', '"');
            str=value.description;
            value.description=str.replace('``', '"');
            str=value.Sub_cat;
            value.Sub_cat=str.replace('``', '"');
            str=value.Main_cat;
            value.Main_cat=str.replace('``', '"');
            if(returnValue[value.main_cat]==undefined)
                returnValue[value.main_cat]={};
            if(returnValue[value.main_cat][value.sub_cat]==undefined)
                returnValue[value.main_cat][value.sub_cat]=[];

            returnValue[value.main_cat][value.sub_cat].push(value);
            returnData.push(value);
        }
    })
    return returnValue;
}

function add_to_cart(item,qty,unit,ad_id='',ad_type=''){
    var res_id = $("#res_id").val();
    $.ajax({
        url: base_url+'checkcart',
        type: "GET",
        data: {'res_id':res_id},
        success: function(data){
            $(".cartsection").removeClass("cartsectionclas");
            $(".orderitem").removeClass("cartsectioncla");
            $("#btn-checkout").attr("disabled","");
            var res_id = $("#res_id").val();
            if(data == 0  ){
                $.ajax({
                    url: base_url+'addtotcart',
                    type: "post",
                    data: {'item':item,'res_id':res_id,'qty':qty,'unit':unit,'ad_id':ad_id,'ad_type':ad_type},
                    success: function(data){
                        $(".menu_cart").html(data.html);
                    $(".header_menu_cart").html(data.searchhtml);
                    $(".cart_head_count").text(data.headCartCount);
                }
            });
            }else{
                $("#switch_cart").find('#cart_res').val(res_id);
                $("#switch_cart").find('#cart_item').val(item);
                $("#switch_cart").find('#cart_qty').val(qty);
                $("#switch_cart").find('#ad_id').val(ad_id);
                $("#switch_cart").find('#ad_type').val(ad_type);
                $("#switch_cart").modal("show");
            }

        }
    });
}

function setCartHtml(){
    var html='';
    $.each(cart_data,function(iIndex,oValue){
        html+= getCartItemHtml(oValue);
    })
    $('.side_cart_content').html(html);
    if(jQuery.isEmptyObject(cart_data)){
        $('.rightsidecontent').show();
    } else {
        $('.rightsidecontent').hide();
        $('.righthidecontent').show();
    }
}

function getCartItemHtml(oData){
    var html='';
    var qprice=0;
    html+='<div class="flexdis">';
    html+='<div class="greensymbol"><span class="glyphicon glyphicon-search symbolgreen"></span>';
    html+='</div>';
    html+='<div class="cheese">'+oData.food_item.replace('``','"')+'</div>';
    html+='<div class="">';
    html+='<div class="addbtn">';
    html+='<div class="addb addc cart_btn_content" data-item_id="'+oData.food_id+'">';
    html+='<div style="display:none;" class="addbd _1uN_a cart_btn add_to_cart add_text" ">ADD</div>';
    html+='<div style="display:block;" class="cart_count_content">';
    html+='<div class="cart_plus add_to_cart" >+</div>';
    html+='<div class="cart_count">'+oData.quantity+'</div>';
    html+='<div class="cart_minus add_to_cart">-</div>';
    html+='</div>';
    html+='</div>';
    html+='<div class="peighty">';
    html+='<span class="ii0"><i class="fas fa-rupee-sign inr3"></i>'+ oData.quantity*oData.price+'</span>';
    html+='</div>';
    html+='</div>';
    html+='</div>'; 
    html+='</div>';
    qprice = oData.quantity*oData.price;
    $('.linethrugh').html(qprice);
    $('.qprice').html(qprice);
    return html;
}

function remove_from_cart(item,unit,qty,adon_id='',adon_type=''){
    var res_id = $("#res_id_cart").val();
    $.ajax({
        url: base_url+'removefromcart',
        type: "POST",
        data: {'item':item,'res_id':res_id,'unit':unit,'qty':qty,'adon_id':adon_id,'adon_type':adon_type,},
        success: function(data){
            $(".cartsection").removeClass("cartsectionclas");
            $(".orderitem").removeClass("cartsectioncla");
            var result = data.html;
            var Cart = data.cart;
            $("#btn-checkout").attr("disabled","");
            $('.menu_cart').html(result);
            $(".header_menu_cart").html(data.searchhtml);
            $(".cart_head_count").text(data.headCartCount);
        }
    });
}

function productLoaderAjax(shop_id, category_id,callback) {
    // $('.loadData').append(loader);
    $.ajax({
        type    : 'POST',
        url     : base_url+'loadMore',
        dataType: "JSON",
        data    : {
            shop_id     : shop_id,
            category_id : category_id,
        },
        success : function(data) {
            // console.log($('#category_'+data.categoryid).length);
            if ($('#category_'+data.categoryid).length == 0 && data.products != '') {
                $('.fillData').append(data.products);
            }
            callback();
        },
        complete : function(data) {
            $('.loadData').html('');
        }
    });
}

$(window).scroll(function(){
    var cur_pos = $(this).scrollTop();
    $(".borderbotm").each(function () {
        // console.log('borderbotm');
        // if ($("a[href^='#']").hasClass("cart_menulink")) {
            // console.log($($('.cart_menulink').attr("href")).offset().top);
            var cart_menuposition_top   = $(this).offset().top - $(".pro-head").outerHeight();
            cart_menuposition = cart_menuposition_top + $(this).outerHeight();
            if (cur_pos >= cart_menuposition_top && cur_pos <= cart_menuposition) {
                var CatID   = $(this).attr('id').split('_')[1];
                if (CatID !== null && CatID !== undefined) {
                    var nxtCat  = $(".cart_menulink[data-catid='" + CatID + "']").next('.cart_menulink');
                    // console.log($('#category_'+nxtCat.data('catid')));
                    if($('#category_'+nxtCat.data('catid')).length == 0) {
                        $(".cart_menulink").removeClass("active");
                        productLoaderAjax($('#res_id').val(), nxtCat.data('catid'),function(){
                            // $(".cart_menulink[data-catid='" + nxtCat.data('catid') + "']").addClass('active');
                        });
                        // nxtCat.addClass('active');
                    }
                }
            }
            // Scroll to the top
            // $('.leftorangemnu').scrollTop($('.leftorangemnu').scrollTop() + $('.leftorangemnu .cart_menulink.active').offset().top);

            // Scroll to the center
            // $('.leftorangemnu').scrollTop($('.leftorangemnu').scrollTop() + $('.leftorangemnu .cart_menulink.active').offset().top - $('.leftorangemnu').height()/2 + $('.leftorangemnu .cart_menulink.active').height()/2);
        // }
    });
    scroll              = $(window).scrollTop();
    var bookit          = $('header').outerHeight();
    var bookitright     = ($('header').outerHeight() + $('.centercontent').outerHeight()) - $('.rightimagebox').outerHeight();
    var positionchange  = $('.centercontent').outerHeight() - $('.rightimagebox').outerHeight();
    var secondheader    = $('.pro-head').height();
    if ( $(window).width() > 769 ) {
        if (scroll >= bookit) {
            // console.log('if');
            $('.pro-head').addClass('change-position');
            // $('.orderitem').css({"margin-top" : secondheader});
            $('.inlineblock').css({"display" : "none"});
            $('.headerimg').addClass("headimgsize");
            $('.absolute').addClass("changetop");
        } else {
            // console.log('else');
            $('.orderitem').css({"margin-top" : "0px"});
            $('.pro-head').removeClass('change-position');
            $('.inlineblock').css({"display" : "block"});
            $('.headerimg').removeClass("headimgsize");
            $('.absolute').removeClass("changetop");
        }
        if (scroll >= bookit) {
            // $('.rightimagebox').addClass('fixe');
            // $('.leftorangemnu').addClass('fixe');
            if (scroll >= bookitright) {
                // console.log('if');
                $('.rightimagebox').removeClass('fixe');
                $('.leftorangemnu').removeClass('fixe');
                if (positionchange > 0){
                    $('.rightimagebox').css({"top": positionchange});$('.leftorangemnu').css({"top": positionchange});
                }
            } else {
                // console.log('else');
                $('.rightimagebox').removeAttr("style");
                $('.leftorangemnu').removeAttr("style");
            }
        } else  {
            // console.log('else if');
            $('.rightimagebox').removeClass('fixe');
            $('.leftorangemnu').removeClass('fixe');
        }
    } 
});

/*$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height()) {
        console.log('ajax call get data from server and append to the div');
    }
});*/

$(document).on('click', "a[href^='#']", function (e) {
    e.preventDefault();
    var curr    = this;
    var curCat  = $(curr).attr("href").split('_')[1];
    $(".cart_menulink").removeClass("active");
    productLoaderAjax($('#res_id').val(), curCat,function() {
        console.log($(".cart_menulink[data-catid='" + curCat + "']"));
        $(".cart_menulink[data-catid='" + curCat + "']").addClass('active');
        if ($(curr).hasClass("cart_menulink")) {
            var position = $($(curr).attr("href")).offset().top + 2 - $(".pro-head").outerHeight();
            $("body, html").animate({ scrollTop: position });
        } else {
            var position = $($(curr).attr("href")).offset().top;
            $("body, html").animate({ scrollTop: position });
        }
    });
});

$(document).ready(function() {
    var curCat  = $('.leftorangemnu .cart_menulink.active');
    var nextCat = curCat.next('.cart_menulink');
    if ($('#fCount').val() < 20) {
        if($('#category_'+nextCat.data('catid')).length == 0) {
            // $(".cart_menulink").removeClass("active");
            productLoaderAjax($('#res_id').val(), nextCat.data('catid'),function(){
                // $(".cart_menulink[data-catid='" + curCat + "']").addClass('active');
            });
        }
    }
});

$('.food_slider').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    nav:false,
    autoplay:true,
    dots:true,
    autoplayTimeout:6000,
    autoplaySpeed:2000,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1,
        },
        1000:{
            items:1,
        }
    }
})

$('.detailbanner-blj').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$(document).on('click','.more_details',function(){
    var id = $(this).attr('data-id');
    $.ajax({
        type : 'POST',
        url : base_url+'fooddetails',
        data : {id:id},
        success:function(data){
            $('#foodModal').modal('show');
            $('.order-content').html(data);
        }
    })
});

$(document).on('click','.cart_btn_content .add_to_cart',function(){
    var iItemId=$(this).parents('.cart_btn_content').attr('data-item_id');
    var iItemCount= parseInt($(this).parents('.cart_btn_content').find('.cart_count').html());
    if($(this).hasClass('cart_minus')){
        iItemCount--;
    } else {
        iItemCount++;
    }
    $('.item_id_'+iItemId).find('.cart_count').html(iItemCount);
    if(iItemCount>0) {
        setCartItems(iItemId,iItemCount);
        $('.item_id_'+iItemId).find('.cart_btn').hide();
        $('.item_id_'+iItemId).find('.cart_count_content').show();
    } else {
        removeCartItem(iItemId);
        $('.item_id_'+iItemId).find('.cart_btn').show();
        $('.item_id_'+iItemId).find('.cart_count_content').hide();
    }
})
$( document ).ready(function() {
$(document).on("click",'.add_item',function(){
    // $('.menu_cart').html(cartloader);
    var adon_type   = $(this).attr('data-type');
    var isad        = $(this).attr('data-isad');
    if(adon_type == 'more_details' && isad == 1){
        var id = $(this).attr('data-fid');
        var cou= $(this).prev('.item-count').text(1);
        $.ajax({
            type : 'POST',
            url : base_url+'details/fooddetails',
            data : {id:id},
            success:function(data){
                $('#foodModal').modal('show');
                $('.order-content').html(data);
            }
        });
    }
    else if(adon_type == 'unit_details') {
        $(".cartsection").addClass("cartsectionclas");
        $(".orderitem").addClass("cartsectioncla");
        $("#btn-checkout").attr("disabled","disabled");
        var count   = $(this).closest("div").find('.item-count').text();
        var item1   = $(this).attr("data-fid");
        var item='fnitem_'+item1;
        

        var item_array = item.split("_"); 
        var new_count = (parseInt(count) + 1);

        var qua   = $('.unit_'+item1).first("h5").text();
        
        var iItemId = item_array[1];

        
        var unit = $(".unit:checked").val();
      

        if (isad == '1') {
            var iAdonId =  item_array[2];
            add_to_cart(iItemId,parseInt(count) + 1,iAdonId,adon_type);
        } else {
            var iAdonId = '';
            add_to_cart(iItemId,qua,unit); 
        }
        $('#afid_'+iItemId).text(parseInt($('#afid_'+iItemId).text())+1);
        $(this).closest("div").find('.item-count').text(parseInt(count) + 1);

        if($('#afid_'+iItemId).text()==1){
            $('#fnitem_'+iItemId).html('<button class="add_dec_option remove_item" data-fid="'+iItemId+'" data-type="more_details" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'" id="afid_'+iItemId+'" data-id="'+iItemId+'">1</span><button data-fid="'+iItemId+'" class="add_dec_option add_item" data-isad="'+isad+'" data-id="'+iItemId+'" data-type="more_details">+</button>');
        }
        if(new_count == 1){
            if(adon_type!='' && adon_type=='more_details'){
                $(this).first("div").html('<button class="add_dec_option remove_item" data-type="'+adon_type+'" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'"  id="afid_'+iItemId+'_'+iAdonId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" data-aid="'+iAdonId+'" data-type="'+adon_type+'" class="add_dec_option add_item" data-isad="'+isad+'">+</button>');
            }else{
                // $(this).closest("div").html('<button class="add_dec_option remove_item" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'"  id="afid_'+iItemId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" class="add_dec_option add_item" data-isad="'+isad+'">+</button>');
            }
        }
        if ($('.searchitem_'+iItemId).length > 0) {
            if(new_count == 1){
                if(adon_type!=''){
                    $('.searchitem_'+iItemId).closest("div").html('<button class="remove_search_item add_dec_option" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'_'+iAdonId+'"  id="search_'+iItemId+'_'+iAdonId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" data-aid="'+iAdonId+'" data-type="'+adon_type+'" class="add_search_item add_dec_option" data-isad="'+isad+'">+</button>');
                }else{
                    $('.searchitem_'+iItemId).closest("div").html('<button class="remove_search_item add_dec_option" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'"  id="search_'+iItemId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" class="add_search_item add_dec_option" data-isad="'+isad+'">+</button>');  
                }
            } else {
                $('.searchitem_'+iItemId).parent().find('.searchfid_'+iItemId).text(new_count);
            }


        } 
    } 

    else {
        $(".cartsection").addClass("cartsectionclas");
        $(".orderitem").addClass("cartsectioncla");
        $("#btn-checkout").attr("disabled","disabled");
        var count   = $(this).closest("div").find('.item-count').text();
        var item    = $(this).closest("div").attr("id");

        var item_array = item.split("_"); 
        var new_count = (parseInt(count) + 1);
        var iItemId = item_array[1];
        //var price=0;
        if (isad == '1') {
            var iAdonId =  item_array[2];
            add_to_cart(iItemId,parseInt(count) + 1,iAdonId,adon_type);
        } else {
            var iAdonId = '';
            add_to_cart(iItemId,parseInt(count) + 1); 
        }
        $('#afid_'+iItemId).text(parseInt($('#afid_'+iItemId).text())+1);
        $(this).closest("div").find('.item-count').text(parseInt(count) + 1);

        if($('#afid_'+iItemId).text()==1){
            $('#fnitem_'+iItemId).html('<button class="add_dec_option remove_item" data-fid="'+iItemId+'" data-type="more_details" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'" id="afid_'+iItemId+'" data-id="'+iItemId+'">1</span><button data-fid="'+iItemId+'" class="add_dec_option add_item" data-isad="'+isad+'" data-id="'+iItemId+'" data-type="more_details">+</button>');
        }
        if(new_count == 1){
            if(adon_type!=''){
                $(this).closest("div").html('<button class="add_dec_option remove_item" data-type="'+adon_type+'" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'"  id="afid_'+iItemId+'_'+iAdonId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" data-aid="'+iAdonId+'" data-type="'+adon_type+'" class="add_dec_option add_item" data-isad="'+isad+'">+</button>');
            }else{
                $(this).closest("div").html('<button class="add_dec_option remove_item" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'"  id="afid_'+iItemId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" class="add_dec_option add_item" data-isad="'+isad+'">+</button>');
            }
        }
        if ($('.searchitem_'+iItemId).length > 0) {
            if(new_count == 1){
                if(adon_type!=''){
                    $('.searchitem_'+iItemId).closest("div").html('<button class="remove_search_item add_dec_option" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'_'+iAdonId+'"  id="search_'+iItemId+'_'+iAdonId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" data-aid="'+iAdonId+'" data-type="'+adon_type+'" class="add_search_item add_dec_option" data-isad="'+isad+'">+</button>');
                }else{
                    $('.searchitem_'+iItemId).closest("div").html('<button class="remove_search_item add_dec_option" data-isad="'+isad+'">-</button><span class="item-count afid_'+iItemId+'"  id="search_'+iItemId+'" >'+new_count+'</span><button data-fid="'+iItemId+'" class="add_search_item add_dec_option" data-isad="'+isad+'">+</button>');  
                }
            } else {
                $('.searchitem_'+iItemId).parent().find('.searchfid_'+iItemId).text(new_count);
            }


        } 
    }      
});
});
$(document).on("click",'.add_cart_item',function(){
    $(".cartsection").addClass("cartsectionclas");
    $(".orderitem").addClass("cartsectioncla");
    $("#btn-checkout").attr("disabled","disabled");
    var count = $(this).closest("div").find('.item-count').text();
    $(this).closest("div").find('.item-count').text(parseInt(count) + 1);
    var unit_id=$(this).closest("div").find('.item-count').attr("data-unit");
    if(unit_id>0){

        var unit=unit_id;
    }
    else{

        var unit=0;
    }
    var item = $(this).closest("div.menu-cart-items").attr("id");
    var adon_type=$(this).attr('data-type');
    var item_array = item.split("_");
    if(adon_type!=''){
        add_to_cart(item_array[1],parseInt(count) + 1,unit,item_array[2],adon_type); 
    }else{
        add_to_cart(item_array[1],parseInt(count) + 1,unit); 
    }
    var fid = $(this).data('faid');
    var new_count = (parseInt(count) + 1);
    $('#afid_'+item_array[1]).text(parseInt($('#afid_'+item_array[1]).text())+1);
    if ($('.searchitem_'+fid).length > 0) {
        if(new_count == 1){
            $('.searchitem_'+fid).closest("div").html('<button class="remove_search_item add_dec_option">-</button><span class="item-count searchfid_'+fid+'"  id="search_'+fid+'" >'+new_count+'</span><button data-fid="'+fid+'" data-aid="'+item_array[2]+'" data-type="'+adon_type+'" class="add_search_item add_dec_option">+</button>');
        } else {
            $('.searchitem_'+fid).parent().find('.searchfid_'+fid).text(new_count);
        }
    } 
});

$(document).on("click",'.add_search_item',function(){
    $(".cartsection").addClass("cartsectionclas");
    $(".orderitem").addClass("cartsectioncla");
    $("#btn-checkout").attr("disabled","disabled");
    var count = $(this).closest("div").find('.item-count').text();
    var item = $(this).closest("div").attr("id");
    var item_array = item.split("_"); 
    var new_count = (parseInt(count) + 1);
    add_to_cart(item_array[1],parseInt(count) + 1); 
    $(this).closest("div").find('.item-count').text(parseInt(count) + 1);
    if(new_count == 1){
        $('.searchitem_'+item_array[1]).closest("div").html('<button class="remove_search_item add_dec_option">-</button><span class="item-count searchfid_'+item_array[1]+'"  id="search_'+item_array[1]+'" >'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_search_item add_dec_option">+</button>');
        $('.fnitem_'+item_array[1]).html('<button class="remove_item add_dec_option">-</button><span class="item-count afid_'+item_array[1]+'"  id="afid_'+item_array[1]+'" >'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_item add_dec_option">+</button>');
    } else {
        $('.searchitem_'+item_array[1]).parent().find('.searchfid_'+item_array[1]).text(new_count);
        $('.fnitem_'+item_array[1]).parent().find('.afid_'+item_array[1]).text(new_count);
    }
});

$(document).on('click','.favoriteselection',function(){
    var authcheck = $(this).data('id');  
    var wishval;
    if(authcheck==0){
        $(".rightsignin").toggleClass('rightsign-active');
    }else{
        if($(this).hasClass('fav-active')){
            wishval = 0;
        }else{
            wishval = 1;
        }
        var currentuserid=  parseInt($(this).data('userid'));
        var resid = parseInt($(this).data('resid'));
        $.ajax({
            url: base_url+'addtofavorites',
            type: "POST",
            data: {'resid':resid,'userid':currentuserid, 'wishval' : wishval},
            success: function(data){
                if(data==1){
                    if(!$('.favoriteselection').hasClass('fav-active')){
                        $('.favoriteselection').addClass('fav-active');
                    }
                }else if(data==2){
                    if($('.favoriteselection').hasClass('fav-active')){
                        $('.favoriteselection').removeClass('fav-active');
                    }
                } else{

                }  
            }
        });

    }   
    return false;
}); 

$(document).on('keyup','.search_filter_input',function(){
    if($(this).val().length>2) {
        searchResults();
    } else if($(this).val().length==0){
        $('.search_filter_content').html('');
    }
})

$(document).on('click','.cart_btn_content_se .add_to_cart',function(){
    $('.addbd ._1uN_a .cart_btn .add_to_cart').hide();
    var iItemId=$(this).parents('.addbd ._1uN_acontent').attr('data-item_id');
    var iItemCount= parseInt($(this).parents('.addbd ._1uN_acontent').find('.cart_count').html());
    var iprice = parseInt($(this).parents('.addbd ._1uN_acontent').find('.cart_count').html());
    if($(this).hasClass('.cart_minus')){
        iItemCount--;
    } else {
        iItemCount++;
    }
    $('.item_id_'+iItemId).find('.cart_count').html(iItemCount);
    if(iItemCount>0) {
        setCartItems(iItemId,iItemCount);
        $('.item_id_'+iItemId).find('.cart_btn').hide();
        $('.item_id_'+iItemId).find('.addbd ._1uN_acontent').show();
    } else {
        removeCartItem(iItemId);
        $('.item_id_'+iItemId).find('.cart_btn').show();
        $('.item_id_'+iItemId).find('.addbd ._1uN_acontent').hide();
    }
})

$(document).on('change','#check',function(){
    setItemLists();
});

$(document).on("click",'.remove_item',function() {
    // $('.menu_cart').html(cartloader);
    var adon_type   = $(this).attr("data-type");
    var is_ad       = $(this).attr("data-isad");
    if (adon_type == 'more_details' && is_ad == '1') {
        var id  = $(this).attr('data-fid');
        $.ajax({
            type    : 'POST',
            url     : base_url+'details/fooddetails',
            data    : {id:id},
            success:function(data){
                $('#foodModal').modal('show');
                $('.order-content').html(data);
            }
        })
    } else {
        $(".cartsection").addClass("cartsectionclas");
        $(".orderitem").addClass("cartsectioncla");
        var count = $(this).closest("div").find('.item-count').text();
        var unit_id=$(this).closest("div").find('.item-count').attr("data-unit");
        if(unit_id>0){
            var unit=unit_id;
        }else{
            var unit=0;
        }
        if(count > 0){
            $("#btn-checkout").attr("disabled","disabled");

            var item = $(this).closest("div").attr("id");

            var item_array = item.split("_");
            var new_count = (parseInt(count) - 1);
            if(adon_type!=''){
                remove_from_cart(item_array[1],unit,new_count,item_array[2],adon_type); 
            }else{
                remove_from_cart(item_array[1],unit,new_count);
            }
            $('#afid_'+item_array[1]).text(parseInt($('#afid_'+item_array[1]).text())-1);
            if(new_count == 0){
                $(this).closest("div").html('<span class="item-count hide-text afid_'+item_array[1]+'" id="afid_'+item_array[1]+'">'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_item add_text" data-type="'+adon_type+'" data-isad="'+is_ad+'">ADD</button>');
            } else {
                $(this).closest("div").find('.item-count').text(new_count);
            }
            var foodTotalCount = 0;
            $( "#foodModal .fnitem_"+item_array[1]+" .item-count").each(function( index ) {
              foodTotalCount += parseInt($( this ).html());
          });
            if(foodTotalCount == 0 && is_ad == '1')
            {
                $('#fnitem_'+item_array[1]).html('<span class="item-count hide-text afid_'+item_array[1]+'" id="afid_'+item_array[1]+'">'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_item add_text" data-type="more_details" data-isad="'+is_ad+'">ADD</button>');
            }
            if ($('.searchitem_'+item_array[1]+'_'+item_array[2]).length > 0) {
                if(new_count == 0){
                    $('.searchitem_'+item_array[1]).closest("div").html('<span class="item-count hide-text searchfid_'+item_array[1]+'_'+item_array[2]+'" id="searchfid_'+item_array[1]+'_'+item_array[2]+'">'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_search_item add_text">ADD</button>');
                } else if(new_count >= 1) {
                    $('.searchitem_'+item_array[1]+'_'+item_array[2]).parent().find('.searchfid_'+item_array[1]+'_'+item_array[2]).text(new_count);
                }
            } 
        }
    }
});

$(document).on("click",'.remove_search_item',function(){
    $(".cartsection").addClass("cartsectionclas");
    $(".orderitem").addClass("cartsectioncla");
    var count = $(this).closest("div").find('.item-count').text();
    if(count > 0){
        $("#btn-checkout").attr("disabled","disabled");
        $(this).closest("div").find('.item-count').text(parseInt(count) - 1);
        var item = $(this).closest("div").attr("id");
        var item_array = item.split("_");
        var new_count = (parseInt(count) - 1);              
        remove_from_cart(item_array[1],parseInt(count) - 1);
        if(new_count == 0){
            $('.searchitem_'+item_array[1]).closest("div").html('<span class="item-count hide-text searchfid_'+item_array[1]+'" id="searchfid_'+item_array[1]+'">'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_search_item add_text">ADD</button>');
            $('.fnitem_'+item_array[1]).html('<span class="item-count hide-text afid_'+item_array[1]+'" id="afid_'+item_array[1]+'">'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_item add_text">ADD</button>');
        } else if(new_count >= 1) {
            $('.searchitem_'+item_array[1]).parent().find('.searchfid_'+item_array[1]).text(new_count);
            $('.fnitem_'+item_array[1]).parent().find('.afid_'+item_array[1]).text(new_count);
        }
    }
});

$(document).on("click",'.remove_cart_item',function(){
    $(".cartsection").addClass("cartsectionclas");
    $(".orderitem").addClass("cartsectioncla");
    var count = $(this).closest("div").find('.item-count').text();
    if(count > 0){
        $("#btn-checkout").attr("disabled","disabled");
        $(this).closest("div").find('.item-count').text(parseInt(count) - 1);
        var unit_id=$(this).closest("div").find('.item-count').attr("data-unit");
        if(unit_id>0){

            var unit=unit_id;
        }
        else{

            var unit=0;
        }

        var sp_count = parseInt(count)-1;
        var item = $(this).closest("div.menu-cart-items").attr("id");
        var adon_type = $(this).attr("data-type");
        
        var item_array = item.split("_");
        if(adon_type!=''){
            remove_from_cart(item_array[1],unit,sp_count,item_array[2],adon_type); 
        }else{
            remove_from_cart(item_array[1],unit,sp_count);
        }        
        var fid = $(this).data('faid');
        $('#afid_'+item_array[1]).text(parseInt($('#afid_'+item_array[1]).text())-1);
        var new_count = (parseInt(count) - 1);
        if(parseInt($('#afid_'+item_array[1]).text()) == 0){
            $("#fnitem_"+fid).html('<span class="item-count hide-text afid_'+fid+'" id="afid_'+fid+'">'+new_count+'</span><button data-fid="'+fid+'" class="add_item add_text" data-type="'+adon_type+'">ADD</button>');
        }
        if ($('.searchitem_'+item_array[1]).length > 0) {
            if(new_count == 0){
                $('.searchitem_'+item_array[1]).closest("div").html('<span class="item-count hide-text searchfid_'+item_array[1]+'" id="searchfid_'+item_array[1]+'">'+new_count+'</span><button data-fid="'+item_array[1]+'" class="add_search_item add_text">ADD</button>');
            } else if(new_count >= 1) {
                $('.searchitem_'+item_array[1]).parent().find('.searchfid_'+item_array[1]).text(new_count);
            }
        } 
    }
});

$(document).on('click', ".add_new_cart_item" ,function(){
    var res_id = $("#cart_res").val();
    var item = $("#cart_item").val();
    var qty = $("#cart_qty").val();
    var ad_id = $("#ad_id").val();
    var ad_type = $("#ad_type").val();
    $.ajax({
        url: base_url+'addtotcart',
        type: "post",
        data: {'item':item,'res_id':res_id,'qty':qty,'ad_id' : ad_id,'ad_type' : ad_type},
        cache: false,
        success: function(data){
            $("#switch_cart").modal("hide");
            $('.menu_cart').html(data.html);
            $(".header_menu_cart").html(data.searchhtml);
            $(".cart_head_count").text(data.headCartCount);
        }
    });
});

$(document).on('click','.delete_item',function(){
    var cartId = $(this).data('cart-id');
    var res_id = $("#res_id").val();
    if(cartId != ''){
        $("#btn-checkout").attr("disabled","disabled");
        $.ajax({
            url : base_url+'deletecartitem',
            type : 'post',
            data : {cartId : cartId, res_id : res_id, from : 'detail'},
            dataType : "JSON",
            success : function(res){
                $("#btn-checkout").attr("disabled","");
                $('.menu_cart').html(res.html);
                $(".header_menu_cart").html(res.searchhtml);
                $(".cart_head_count").text(res.headCartCount);
            }
        })
    }
})

$(document).on("click",'.category_list',function(){
    var catCount = $("#res_cat_count").val()
    var id = $(this).attr("id");
    var h = $(".header_top").height();
    var t = $(".top_details").height();
    var disco = $(".offers_food").height();
    var t_menu = $(".sub-header").height();
    if(catCount > 1){
        if(id == '0'){
            $('html,body').animate({
                scrollTop: $(".recomm_list").offset().top - t_menu - disco - t - h - 20},
                'slow');
        }else{
            $('html,body').animate({
                scrollTop: $("#cat_"+id).offset().top - t - h},
                'slow');
        }
        $(".cat_list li.category_list").removeClass('active');
        $(this).addClass("active");
    }
});

$(document).on('click','.login_checkout',function(){
    $(".rightsignin").addClass('rightsign-active');
    $(".overlay").show();
})


// get unit value
    $(document).on("click",'.unit',function() {
        var id = $(this).attr('data-id');
        var ids=".unit"+id;
        var radioValue = $(ids+":checked").val();
        var itcount=$('#afid_'+id).text();

        var totalPrice=0;
        $(".addon"+id+":checked").each(function () {
            totalPrice += parseInt($(this).attr('data-val'));
        });
        if(radioValue){
            $('#unit_item_'+id).val(radioValue);
            var radval=$(this).attr('data-val');
            $('#unitprice'+id).text((itcount*radval));
            //$('#total_price'+id).text((itcount*radval)+(totalPrice*itcount));
            $('#total_price'+id).text((itcount*radval)+(totalPrice));
        }
    });
    
    $(document).on('click','.ucart',function (e) {
        e.preventDefault();
        $this        = $(this);
        var curclass = $this.attr('class').split(' ')[1];
        var curdiv   = $this.closest("div").find(".cartQty");
        var Qty      = curdiv.attr('data-qty');
        if (curclass == 'add_item') {
            Qty = parseInt(Qty) + 1;
        } else {
            Qty = parseInt(Qty) - 1;
        }
        if(Qty >= 0) {
            curdiv.text(Qty).trigger('changed');
            curdiv.attr('data-qty',Qty);
        }
    });

    // unit default value set modal close 
    $(document).on("click",'.close',function() {
        var unit = $(this).attr('data-unit');
        var timee = $(this).attr('data-myval');
        var id = $(this).attr('data-id');
        $('#unit_item_'+id).val(unit);
        $('#time_slot_'+id).val(timee);
        $('#quantity_'+id).val(1);
    
        $('.item-count').text(1);
        $('#unitprice'+id).text($('.ids'+id).attr('data-pric'));
        $('#total_price'+id).text($('.ids'+id).attr('data-pric'));
        $('.resrt').trigger('reset');
       
    });

    $(document).on("click",'.add_dec_option',function() {
        
        var isad   = $(this).attr("data-isad");
        if(isad!='')
        {
        var curclass = $(this).attr('class').split(' ')[1];
        var div     = $(this).closest("div");
        var span    = div.find('.item-count');
        var item    = div.attr("id").split("_")[1];
        var spancnt = parseInt(span.text());
        spancnt = (curclass == 'adding_item') ? ((spancnt < 50) ? spancnt+= parseInt(1) : spancnt) : ((spancnt > 1) ? spancnt-= parseInt(1) : spancnt);
        span.text(spancnt);
        $('#quantity_'+item).val(spancnt);
        var price = ($('.unit'+item).length) ? $(".unit"+item+":checked").attr('data-val') : 1;
        price = (price == 1) ? span.attr('data-acprice') : price;

        var totalPrice=0;
        $(".addon"+item+":checked").each(function () {
            totalPrice += parseInt($(this).attr('data-val'));
        });
        $(this).parents().next().find('#unitprice'+item).text(price*spancnt);
        //$(this).parents().find('#total_price'+item).text( parseInt(price*spancnt) + parseInt(totalPrice*spancnt));
        $(this).parents().find('#total_price'+item).text( parseInt(price*spancnt) + parseInt(totalPrice));
    }
    });


/*$("#login-form").validate({
    rules:
    {
        email:
        {
            required: true,
            email: true
        },
        password:
        {
            required: true,
            minlength: 3,
            maxlength: 20
        }
    },
    messages:
    {
        email:
        {
            required: '{!! Lang::get("core.email_error") !!}',
            email: '{!! Lang::get("core.valid_email") !!}'
        },
        password:
        {
            required: '{!! Lang::get("core.password_error") !!}'
        }
    },
    submitHandler: function(form) {
        var purl = "{{ URL::to('/')}}/user/plogin";
        var cookie_id = $("#cur_cookie_id").val();

        $.ajax({
            url: purl,
            type: 'post',
            data:  $('#login-form').serialize(),
            success: function(data) {
                if(data != ''){
                    if(data == 2){
                        $("#login-modal").find('.alert_fn').html("<div class='alert alert-danger'><strong>{!! Lang::get('core.combination_error') !!} </strong></div>");
                    }else if(data == 3){
                        $("#login-modal").find('.alert_fn').html('<div class="alert alert-danger"><strong>{!! Lang::get("core.no_email") !!}</strong></div>');

                    }else if(data == 4){
                        $("#login-modal").find('.alert_fn').html('<div class="alert alert-danger"><strong>{!! Lang::get("core.block_error") !!}</strong></div>');

                    }else if(data == 5){
                        $("#login-modal").find('.alert_fn').html('<div class="alert alert-danger"><strong>{!! Lang::get("core.inactive_error") !!}</strong></div>');

                    }else if(data == 1){
                        $.ajax({
                            url : base_url+"setcartitmes",
                            type : "post",
                            data : {
                                cookieid : cookie_id,
                            },
                            dataType : "json",
                            success :function(){

                            }
                        })
                        $("#login-modal").find('.alert_fn').html('<div class="alert alert-success"><strong>{!! Lang::get("core.success_login") !!}..</strong></div>');
                        setTimeout(function(){ location.reload(); }, 3000);
                    }
                }
            }
        });
    },
    errorPlacement: function(error, element)
    {
        error.insertAfter(element.parent());
    }
});*/