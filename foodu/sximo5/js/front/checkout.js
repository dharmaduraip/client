
;(function ($, window, document, undefined) {
  var pluginName = "countdown360",
    defaults = {
      radius: 15.5,                    // radius of arc
      strokeStyle: "#bb0d18",          // the color of the stroke
      strokeWidth: undefined,          // the stroke width, dynamically calulated if omitted in options
      fillStyle: "#f3182d",            // the fill color
      fontColor: "#477050",            // the font color
      fontFamily: "sans-serif",        // the font family
      fontSize: undefined,             // the font size, dynamically calulated if omitted in options
      fontWeight: 700,                 // the font weight
      autostart: true,                 // start the countdown automatically
      seconds: 10,                     // the number of seconds to count down
      label: ["second", "seconds"],    // the label to use or false if none
      startOverAfterAdding: true,      // Start the timer over after time is added with addSeconds
      smooth: false,                   // should the timer be smooth or stepping
      onComplete: function () {}
    };

  function Plugin(element, options) {
    this.element = element;
    this.settings = $.extend({}, defaults, options);
    if (!this.settings.fontSize) { this.settings.fontSize = this.settings.radius/1.2; }
    if (!this.settings.strokeWidth) { this.settings.strokeWidth = this.settings.radius/4; }
    this._defaults = defaults;
    this._name = pluginName;
    this._init();
  }

  Plugin.prototype = {
    getTimeRemaining: function()
    {
    
      var timeRemaining = this._secondsLeft(this.getElapsedTime());
      return timeRemaining;
    },
    getElapsedTime: function()
    {
      return  Math.round((new Date().getTime() - this.startedAt.getTime())/1000);
    },
    extendTimer: function (value) {
      var seconds = parseInt(value),
          secondsElapsed = Math.round((new Date().getTime() - this.startedAt.getTime())/1000);
      if ((this._secondsLeft(secondsElapsed) + seconds) <= this.settings.seconds) {
        this.startedAt.setSeconds(this.startedAt.getSeconds() + parseInt(value));
      }
    },

    addSeconds: function (value) {
      var secondsElapsed = Math.round((new Date().getTime() - this.startedAt.getTime())/1000);
      if (this.settings.startOverAfterAdding) {
          this.settings.seconds = this._secondsLeft(secondsElapsed) + parseInt(value);
          this.start();
        } else {
          this.settings.seconds += parseInt(value);
        }
    },

    start: function () {
      this.startedAt = new Date();
      this._drawCountdownShape(Math.PI*3.5, true);
      this._drawCountdownLabel(0);
      var timerInterval = 1000;
      if (this.settings.smooth) {
        timerInterval = 16;
      }
      this.interval = setInterval(jQuery.proxy(this._draw, this), timerInterval);
    },

    stop: function (cb) {
      clearInterval(this.interval);
      if (cb) { cb(); }
    },

    _init: function () {
      this.settings.width = (this.settings.radius * 2) + (this.settings.strokeWidth * 2);
      this.settings.height = this.settings.width;
      this.settings.arcX = this.settings.radius + this.settings.strokeWidth;
      this.settings.arcY = this.settings.arcX;
      this._initPen(this._getCanvas());
      if (this.settings.autostart) { this.start(); }
    },

    _getCanvas: function () {
      var $canvas = $("<canvas id=\"countdown360_" + $(this.element).attr("id") + "\" width=\"" +
                      this.settings.width + "\" height=\"" +
                      this.settings.height + "\">" +
                      "<span id=\"countdown-text\" role=\"status\" aria-live=\"assertive\"></span></canvas>");
      $(this.element).prepend($canvas[0]);
      return $canvas[0];
    },

    _initPen: function (canvas) {
      this.pen              = canvas.getContext("2d");
      this.pen.lineWidth    = this.settings.strokeWidth;
      this.pen.strokeStyle  = this.settings.strokeStyle;
      this.pen.fillStyle    = this.settings.fillStyle;
      this.pen.textAlign    = "center";
      this.pen.textBaseline = "middle";
      this.ariaText = $(canvas).children("#countdown-text");
      this._clearRect();
    },

    _clearRect: function () {
      this.pen.clearRect(0, 0, this.settings.width, this.settings.height);
    },

    _secondsLeft: function(secondsElapsed) {
      return this.settings.seconds - secondsElapsed;
    },

    _drawCountdownLabel: function (secondsElapsed) {
      this.ariaText.text(secondsLeft);
      this.pen.font         = this.settings.fontWeight + " " + this.settings.fontSize + "px " + this.settings.fontFamily;
      var secondsLeft = this._secondsLeft(secondsElapsed),
          label = secondsLeft === 1 ? this.settings.label[0] : this.settings.label[1],
          drawLabel = this.settings.label && this.settings.label.length === 2,
          x = this.settings.width/2;
      if (drawLabel) {
        y = this.settings.height/2 - (this.settings.fontSize/6.2);
      } else {
        y = this.settings.height/2;
      }
      this.pen.fillStyle = this.settings.fillStyle;
      this.pen.fillText(secondsLeft + 1, x, y);
      this.pen.fillStyle  = this.settings.fontColor;
      this.pen.fillText(secondsLeft, x, y);
      if (drawLabel) {
        this.pen.font = "normal small-caps " + (this.settings.fontSize/3) + "px " + this.settings.fontFamily;
        this.pen.fillText(label, this.settings.width/2, this.settings.height/2 + (this.settings.fontSize/2.2));
      }
    },

    _drawCountdownShape: function (endAngle, drawStroke) {
      this.pen.fillStyle = this.settings.fillStyle;
      this.pen.beginPath();
      this.pen.arc(this.settings.arcX, this.settings.arcY, this.settings.radius, Math.PI*1.5, endAngle, false);
      this.pen.fill();
      if (drawStroke) { this.pen.stroke(); }
    },

    _draw: function () {
      var millisElapsed, secondsElapsed;
      millisElapsed = new Date().getTime() - this.startedAt.getTime();
      secondsElapsed = Math.floor((millisElapsed)/1000);
        endAngle = (Math.PI*3.5) - (((Math.PI*2)/(this.settings.seconds * 1000)) * millisElapsed);
      this._clearRect();
      this._drawCountdownShape(Math.PI*3.5, false);
      if (secondsElapsed < this.settings.seconds) {
        this._drawCountdownShape(endAngle, true);
        this._drawCountdownLabel(secondsElapsed);
      } else {
        this._drawCountdownLabel(this.settings.seconds);
        this.stop();
        this.settings.onComplete();
      }
    }

  };

  $.fn[pluginName] = function (options) {
    var plugin;
    this.each(function() {
      plugin = $.data(this, "plugin_" + pluginName);
      if (!plugin) {
        plugin = new Plugin(this, options);
        $.data(this, "plugin_" + pluginName, plugin);
      }
    });
    return plugin;
  };

})(jQuery, window, document);

function start_timer()
{
    if(seconds <= '10')
    {
        var nowseconds = seconds;
    }
    // $('#timer').modal('show')
    // $('.overlay-timer').show();
    var countdown =  $("#countdown").countdown360({
    radius      : 60,
    seconds     : nowseconds,
    fontColor   : '#FFFFFF',
    autostart   : false,
    background  : '#000',
    onComplete  : function () { 
      // $('.backk').html(''); 
      // $('.backk').removeAttr('style'); 
      $('#countdown').fadeOut(1000);
      $('.timer').css('display', 'none');
      // $('.timer p').html('100% Cancellation Fee will be levied.');
    }
    });
    countdown.start();

}
$(document).on('click',".mol_submit",function(){
    var res_id            = $("#res_id").val();
    var mol_address_id    = $("#mol_address_id").val();
    var mol_order_note    = $("#mol_order_note").val();
    var type              = "mol";
    var otp               = $('#delivrP').val();
    var l_date            = $("#deliver_date").val();
    var l_time            = $("#later_deliver_time").val();
    var walletAmount      = $("#walletAmount").val();
    var dType             = $('#delivrT').val();
    if(otp == 'otpd') {
        ordertype = 'deliver';
    } else if (otp == 'otpp') {
        ordertype = 'pickup';
    } else if (otp == 'otpdp'){
        ordertype = 'delivery_by_partner';
    } else {
        ordertype = 'deliver';
    }

    $(".mol_overlay").show();
    $.ajax({
        url     : base_url+"timevaliditycheck",
        type    : 'post',
        data    : {res_id : res_id,mol_address_id : mol_address_id,mol_order_note : mol_order_note,type : type,deliver_status : ordertype,l_date:l_date,l_time:l_time,wallet_amount:walletAmount,type:dType},
        dataType: 'json',
        success : function(res){
          
            restimevalid    = parseInt(res.restimevalid);
            itemtimevalid   = parseInt(res.itemtimevalid);
            if(restimevalid != 1 || itemtimevalid != 1) {
                location.reload();
            } else if(res.message != 'success' && res.message != 'Order inserted successfully'){
                alert($.parseHTML(res.message));
            } else if(restimevalid == 1 && itemtimevalid == 1){
                /*$('#orderid_key').val(res.orderId);
                $(".mol_overlay").hide();
                $('.overlay-timer').show();
                $('#timer .modal-body').html(res.modalContent);*/
                //start_timer();
                // window.location.href=base_url+'/payment/thankyouorder';  
                var url = base_url+'trackorder/'+btoa(res.orderId);
                window.history.pushState("", "", url);
                //start_timer();
                location.reload();              
            }
        }
    })
});

$(document).on('keyup','textarea',function() {
    textarearestrict($(this));
});
$(document).on('click','#timer-cancellation-btn',function(){
    bootbox.confirm({size: "small",message: "Are you sure you want to cancel the order?",
        buttons: { confirm: { label: 'Cancel Order', className: 'btn-danger' }, cancel: { label: 'No', } },
        callback: function(result){ 
            if(result)
            { 
                $('.loader_event').show();
                var orderId = $('#orderid_key').val();
                var partnerid = $('#partner_id').val();
                var access_token    = $('#access_token').val();
                $.ajax({
                    url: base_url+'api/order/orderStatusChange',
                    beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer '+access_token);},      
                    type: "POST",
                    data: {'type':'user','user_type':'user','partner_id':partnerid,'group_id':'4','order_id':orderId,'status':5 },
                    success: function(data){ 
                        window.location.href=base_url+'orders';
                    }
                });
            }
        }
    });
});
$(document).on("click",'.add_cart_item',function(){
    $('.cart-loader').show();
    $(".cart_items").addClass("cartsectionclas");
    var count = $(this).closest("div").find('.item-count').text();
    $(this).closest("div").find('.item-count').text(parseInt(count) + 1);
    var item = $(this).closest("div.menu-cart-items").attr("id");
    var item_array = item.split("_");
    var item_type = $(this).attr('data-type');
    add_to_cart(item_array[1],item_array[2],item_type,(parseInt(count) + 1));
});
$(document).on("click",'.remove_cart_item',function(){
    $('.cart-loader').show();
    $(".cart_items").addClass("cartsectionclas");
    var count = $(this).closest("div").find('.item-count').text();
    if(count > 0){
        $(this).closest("div").find('.item-count').text(parseInt(count) - 1);
        var item = $(this).closest("div.menu-cart-items").attr("id");
        var item_array = item.split("_");
        var item_type = $(this).attr('data-type');
        remove_from_cart(item_array[1],item_array[2],item_type,(parseInt(count) - 1));
    }
});
$(document).on("click",'#removepromo',function(){
    var total_hid       = $('#total_hidden').val();
    var subtotal_hid    = $('#subtotal_hidden').val();
    $.ajax({
        url:base_url+'updatepromo',
        type:'GET',
        success:function(result){
            $('.cart_items').html(result.html);
        }
    });
});
$(document).on("click",'#submitpromo',function(){
    var promo   = $('#getpromo').val();
    var res_id  = $(this).data('id');
    var discid  = $(this).data('discid');
    var promoid = $(this).data('promoid'); 
    var method  = $(this).data('method');
    var total_hid       = $('#total_hidden').val();
    var subtotal_hid    = $('#subtotal_hidden').val(); 
    $.ajax({
        url: base_url+'promochecks',      
        type: "POST",
        data: {'promo':promo,'res_id':res_id,'discid':discid,'promoid':promoid,'total_hid':total_hid,'subtotal_hid':subtotal_hid,'method':method },
        success: function(data){   
            $('.cart_items').html(data.html);
        }
    });
});
$(document).on('click',"#checkout_cart_empty_btn",function(){
    var res_id = $("#res_id").val();
    window.location.href = base_url+"details/"+res_id;
});
$(document).on('keydown',"#order_note",function(){
    if(this.value.length > 0){
        $('.order_note,#mol_order_note').val(this.value);
    } else {
        $('.order_note,#mol_order_note').val('');
    }
})
$(document).on("click",'.btn_show_payment',function(){
    var address = document.getElementById('address');
    if(address === null) {
        alert('{!! Lang::get("core.address_first") !!}');
        return false;
    } else {
        var address_id = $("input[name='address']:checked").val();  
        if(address_id==undefined){
            $(this).next().show();
            return false;
        } else {
            $(".mol_overlay").show();
            var res_id = $('#restaurant_id').val(); 
            var check = $('.checkout_payment').html();
            var add_finder = false;
            $.ajax({
                url: base_url+'checkneareraddress',
                type: "POST",
                async:false,
                dataType:"json",
                data: {'address_id':address_id,'res_id':res_id},
                success: function(data){
                    $(".mol_overlay").hide();
                    if(data.msg == 'unauthorized'){
                        $(".rightsignin").addClass('rightsign-active');
                        $(".overlay").show();
                    } else if(data.msg == 'success') {
                        add_finder=true;
                    }
                }
            });
            if(add_finder==true) {
                $(".checkout-page .checkout-item-block .block-unit .content").slideToggle(500);
                $(".checkout-page .checkout-item-block .block-summary").addClass('block-error');
                $(".edit_delivery").show();
                $(this).next().hide();
                $('#hidden_paypal_order_price').val(check);
                $('#checkout_amount').val(check);
                $('#checkout_total_price').val(check);
                $('.payment_option').slideToggle(500);
                $('.address_id').val(address_id);
            } else {
                alert("Destination address is far away from Restaurant, please choose Nearby address");
            }
        }
    }
});
$(document).on('click','.edit_delivery',function(e){
    $(this).hide();
    $(".checkout-page .checkout-item-block .block-unit .content").slideToggle(500);
    $('.payment_option').slideToggle(500);
})
$(document).on('submit','#frm_credit',function(e){
    var address_id =$('.address_id').val();
    var ret = false;
    $.ajax({
        url: base_url+'twocheckout',
        type: "POST",
        async:false,
        data: {'address_id':address_id},
        dataType:'json',
        success: function(data){
            $('#checkout_amount').val(data.total);
            $('#checkout_total_price').val(data.total);
            ret =true;
        }
    });
    return ret;    
});
$(document).on('change','.deliverTime',function(e){
    $('#l_time').val($(this).val());
    CallCart(e);
});
$(document).on('click','#ordertime_asap',function(e){
  $('#delivrT').val('asap');
  $('#deliver_date').val('');
  $('#later_deliver_time').val('');
    CallCart(e);
});

$(document).on('click','.ordertime_stat',function(e){
    dstat       = $(this).attr('id');
    var dType = dstat.split("_")[1];
    if(dType != '' && dType != undefined){
        $('#'+dType).attr("checked", "checked");
        $('#delivrT').val(dType);
        if(dType == 'asap') {
            $('#later').removeAttr("checked");
            $(".deliverDateTime").hide();
            $("#l_date,#l_time").val('');
        } else {
            $('#asap').removeAttr("checked");
            $('.deliverDateTime').show();
            var d           = $("#deliver_date").datepicker('setDate',new Date());
            var cur_date    = $("#deliver_date").val();
            show_later_time(cur_date,d,e);
        }
    } else {
        $('#delivrT').val('asap');
        $('#asap').attr("checked", "checked");
    }
});
$(document).on('click','.otpstat',function(e){
    dstat = $(this).data('id');
    if(dstat != '' && dstat != undefined){
        $('#'+dstat).attr("checked", "checked");
        $('#delivrP').val(dstat);
        var res_id      = $('#restaurant_id').val(); 
        var mol_orderid = $("#mol_orderid").val();
        if(dstat != 'otpp') {
            if(dstat == 'otpdp') {
                $('#otpp','#otpd').removeAttr('checked');
                var ordertype   =  'delivery_by_partner';
            } else if (dstat == 'otpd') {
                $('#otpp','#otpdp').removeAttr('checked');
                var ordertype   =  'delivery';
            }
            $('#orderType').val(ordertype);
            showhide();
            var address_id  = $("#mol_address_id").val();
            update_cart(address_id,mol_orderid,res_id,e,ordertype);
            $(".delivery_address").show();
            $(".delivery_add").hide();
            $("#delivery_add_block").show();
        } else {
            $('#otpd','#otpdp').removeAttr('checked');
            $("#delivery_add_block").hide();
            $('.payment_unselect').hide();
            $('.choose_payment').show();
            var address_id  = 0;
            var ordertype   = 'pickup';
            $('#orderType').val(ordertype);
            update_cart(address_id,mol_orderid,res_id,e,ordertype);
        }
    } else {
        $('#delivrP').val('otpd');
        $('#otpd').attr("checked", "checked");
    }
});
$(document).on('click','.plain_border',function(e){ 
    var pickOption  = $("#pickOption").val();
    var order_note  = $("#order_note").val();
    var address_id  = $(this).data('id');
    var res_id      = $('#restaurant_id').val(); 
    var check       = $('.checkout_payment').html();
    var totAmnt     = "PAY "+$(".show_tot_amount").text();
    var mol_orderid = $("#mol_orderid").val();
    var dstat       = $('.otpstat.active').data('id');
    if(pickOption == 'enable' && (dstat == undefined || dstat == '')) {
        alert('Please choose your Preference first');
    } else {
        if(dstat == 'otpdp') {
            var ordertype   = 'delivery_by_partner';
        } else if (dstat == 'otpd') {
            var ordertype   = 'delivery';
        } else if (dstat == 'otpp') {
            var ordertype   = 'pickup';
        } else {
            var ordertype   = 'delivery';
        }
        update_cart(address_id,mol_orderid,res_id,e,ordertype);
    }
});
$(document).on('click','.delivery_added',function(){
    $(this).removeClass('delivery_added');
    $(".delivery_address").show();
    $(".delivery_add").hide();
    $('.payment_unselect').show();
    $('.choose_payment').hide();
    $('.payment_check').removeClass('active');
});
$(document).on('click','.know_more',function(){
    $(this).hide();
    $(this).closest('.available_border').find('.more_coupn').show();
});
$(document).on('click','.delivery_added',function(){
    $(this).removeClass('delivery_added');
    $(".delivery_address").show();
    $(".delivery_add").hide();
    $('.payment_unselect').show();
    $('.choose_payment').hide();
    $('.payment_check').removeClass('active');
});
$(document).on('click','.apply_coupn',function(){
    $(".small_loader").show();
    $(".coupon_input").val('');
    $(".apply_coupn_code").data('coupon-id','');
    $(".right-popup").addClass('rightsignup-active');
    $(".overlay").show();
    var res_id=$(this).attr('data-res');
    $.ajax({
        url : base_url+"couponlist",
        type : 'get',
        data:{res_id:res_id},
        dataType : 'json',
        success : function(result){  
            $(".small_loader").hide();   
            if(result.msg == 'success'){
                $(".available_coupn").html(result.html);
            } else if(result.msg == 'success') {
                $(".rightsignin").addClass('rightsign-active');
                $(".overlay").show(); 
            }
        }
    })
});
$(document).on('click',".select_coupon",function(){
    var promouser = $(this).data('users');
    var promoid = $(this).data('coupon-id');
    var res_id = $("#res_id").val();
    if((promouser != '' || promouser == 0) && promoid != ''){
        apply_coupon(promoid,'',promouser);
    }
});
$(document).on('click',".apply_coupn_code",function(){
    $(".coupon-id").val($(this).data('coupon-id'));
    var couponid = $(this).data('coupon-id');
    var couponcode = $(".coupon_input").val();
    apply_coupon(couponid,couponcode)
    if(couponcode != '' && (couponid == '' || couponid == undefined)){
        
    } else if(couponid != ''){
        
    } else{
        $(".coupon_response").html('<font color="red">Please enter coupon</font>');
        setTimeout(function(){$(".coupon_response").html('');},3000);
    }
});

function apply_coupon(couponid='',couponcode='',promouser='')
{
    var res_id = $("#res_id").val();
    $('.cart_overlay').show();
    $.ajax({
        url         : base_url+"promocheck",
        type        :"get",
        data        : {couponcode : couponcode, res_id : res_id, couponid:couponid, promouser : promouser},
        dataType    : 'json',
        success     : function(res){
            $('.cart_overlay').hide();
            if(res.msg == 'unauthorized'){
                $(".coupon_error").hide();
                $(".rightsignin").addClass('rightsign-active');
                $(".overlay").show(); 
            } else if(res.msg == 'notsufficient') {
                $(".coupon_error").show();
            } else if(res.msg == 'success') {
                $(".coupon_error").hide();
                $(".apply_coupn_code").data('coupon-id',res.promoId);
                $(".apply_coupn_code").removeAttr('disabled');
                if(res.promouser == 'all'){
                    $(".apply_coupn_code").data('user','all');
                    $(".right-popup").removeClass('rightsignup-active');
                    $(".overlay").hide();
                } else {
                    $(".coupon_response").html('<font color="green">Enter coupon code which we have sent to your email');
                    setTimeout(function(){$(".coupon_response").html('');},3000);
                }
                if(res.html != ''){
                    $('.cart_items').html(res.html);
                    var totamount = "PAY "+$(".show_tot_amount").text();
                    $(".pay_amount").val(totamount);
                    $(".right-popup").removeClass('rightsignup-active');
                    $(".overlay").hide();
                }
            }else if(res.msg == 'invalid'){
                $(".coupon_response").html('<font color="red">Enter valid coupon code');
                setTimeout(function(){$(".coupon_response").html('');},3000);
            }
        }
    });
}
$(document).on('click',".remove_coupon",function(){
    var res_id = $("#res_id").val();
    $('.cart_overlay').show();
    $.ajax({
        url : base_url+"removecoupon",
        type : "get",
        data : { res_id : res_id },
        dataType : "json",
        success : function(res){
            $('.cart_overlay').hide();
            if(res.msg == 'success') {
                $('.cart_items').html(res.html);
                var totamount = "PAY "+$(".show_tot_amount").text();
                $(".pay_amount").val(totamount);
            }
        }
    })
});

$(document).on('click','.delete_item',function(){
    var cartId = $(this).data('cart-id');
    var res_id = $("#res_id").val();
    if(cartId != ''){
        $('.cart_overlay').show();
        $.ajax({
            url : base_url+'deletecartitem',
            type : 'post',
            data : {cartId : cartId, res_id : res_id, from : 'checkout'},
            dataType : "JSON",
            success : function(res){
                $('.cart_overlay').hide();
                $('.cart_items').html(res.html); 
                var restimevalid = parseInt(res.restimevalid);
                var itemtimevalid = parseInt(res.itemtimevalid);
                if(restimevalid != 1 || itemtimevalid != 1){
                    location.reload();
                }
            }
        })
    }
})
$(document).ready(function (e) {
    datePicker(e);
    var otp   = $('.otpstat.active').data('id');
    if(otp == 'otpd') {
        $('#delivrP').val('otpd');
    } else if (otp == 'otpp') {
        $('#delivrP').val('otpp');
    } else if (otp == 'otpdp'){
        $('#delivrP').val('otpdp');
    }
});

/* functions */
function CallCart(e) {
    var res_id      = $('#restaurant_id').val(); 
    var mol_orderid = $("#mol_orderid").val();
    var address_id  = $("#mol_address_id").val();
    var ordertype   = $('#delivrP').val();
    var orderType   = '';
    if(ordertype == 'otpp') {
        orderType   = 'pickup';
    } else if(ordertype == 'otpd') {
        orderType   = 'delivery';
    } else if(ordertype == 'otpdp') {
        orderType   = 'delivery_by_partner';
    }
    update_cart(address_id,mol_orderid,res_id,e,orderType);
}
function datePicker(e) {
    $("#deliver_date").datepicker({
        minDate: 0,
        maxDate: 6,
    });
    $("#deliver_date").datepicker("option","onSelect",function(datetext,obj,e){
        show_later_time(datetext,obj,e);
    });
}
function update_cart(address_id,mol_orderid,res_id,e,ordertype) {
    $('.cart_overlay').show();
    var add_finder = false;
    var dType   = $('#delivrT').val();
    var dDate   = $('#deliver_date').val();
    var dTime   = ($('#later_deliver_time').val() ==  '' || $('#later_deliver_time').val() == undefined) ? $(".deliver_time").val() : $('#later_deliver_time').val();
    var URL     = base_url+'checkneareraddress';
    $.ajax({
        url: URL,
        type: "POST",
        // async:false,
        dataType:"json",
        data: {'address_id':address_id,'res_id':res_id,'ordertype':ordertype,'mol_orderid':mol_orderid,'deliverType':dType,'deliverDate':dDate,'deliverTime':dTime},
        success: function(data){
            $('.cart_overlay').hide();
            if(data.msg == 'unauthorized'){
                window.location.href = base_url+"user/login";
            } else if(data.msg == 'success') {
                var order_note  = $("#order_note").val();
                add_finder=true;
                if(address_id != 0){
                    $('.delivery_add').show();
                    $('.delivery_address').hide();
                    $('.payment_unselect').show();
                    $('.choose_payment').hide();
                } else {
                    $('.delivery_add').hide();
                    $('.delivery_address').show();
                    $('.payment_unselect').hide();
                    $('.choose_payment').show();
                }
                $('.delivery_add address').html($(this).find('address').html());
                $('#delivery_add_block').addClass('delivery_added');
                $('.checkout_icon').addClass('active');
                if(ordertype != 'pickup') {
                    $('.address_id').val(address_id);
                }
                $('.orer_notes').val(order_note);
                $('#mol_amount').val(data.mol_amount);
                $('#mol_vcode').val(data.mol_vcode);
                if(data.selhtml != 'blank'){
                    $(".selected_address").html(data.selhtml);
                }
                $(".cart_items").html(data.cart);
                $('#order_note').val(order_note);
                showhide();
                e.preventDefault();
            } else {
                // var msg="{!! Lang::get('core.far_address') !!}";
                // alert(data.msg);
            }
        }
    });
}
function getLocation_pos(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(geoSuccess_place, showError_place);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}
function showError_place(error){
    var innerHTML = '';
    switch(error.code) {
        case error.PERMISSION_DENIED:
        innerHTML = "You have blocked browser from tracking your location. To use this, change your location settings in browser."
        break;
        case error.POSITION_UNAVAILABLE:
        innerHTML = "Location information is unavailable."
        break;
        case error.TIMEOUT:
        innerHTML = "The request to get user location timed out."
        break;
        case error.UNKNOWN_ERROR:
        innerHTML = "An unknown error occurred."
        break;
    }
    $('#location').val(innerHTML);
}
function geoSuccess_place(position) {
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    if (geocoder) {
        geocoder.geocode({ 'latLng': latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var components = results[0].address_components;
                $('#a_addr').val(results[0].formatted_address);
                $('#a_lat').val(lat);
                $('#a_lang').val(lng);
                initialize();
                address_check();
            }
            else {
                $('#a_lat').val('');
                $('#a_lang').val('');
                $("#a_addr").val(''); 

            }
        });
    } 
}
function add_to_cart(item,ad_id,ad_type,qty){
    var res_id = $("#res_id").val();
    $.ajax({
        url: base_url+'addtotcart',
        type: "post",
        data: {'item':item,'ad_id':ad_id,'ad_type':ad_type,'res_id':res_id,qty:qty,key:"checkout"},
        success: function(data){
            $('.cart_items').html(data.html);
            $(".cart_items").removeClass("cartsectionclas");
            $('.cart-loader').hide();
            var totamount = "PAY "+$(".show_tot_amount").text();
            $(".pay_amount").val(totamount);
            var tamount = $(".grand_total").text();
            $('.avenue').val(parseFloat(tamount).toFixed(2));        
        }
    });
}
function remove_from_cart(item,ad_id,ad_type,qty){
    var res_id = $("#res_id").val();
    $.ajax({
        url: base_url+'removefromcart',
        type: "POST",
        data: {'item':item,'adon_id':ad_id,'adon_type':ad_type,'res_id':res_id,qty:qty,key:"checkout"},
        success: function(data){
            var result = data.html;
            var Cart = data.cart;
            $(".cart_items").removeClass("cartsectionclas");
            $('.cart-loader').hide();
            if(Cart == 'empty'){
                $(".btn_show_payment").attr("disabled","disabled");
                $(".checkout-page").html(data.emptyhtml);
            } else {
                $('.cart_items').html(result);
                var totamount = "PAY "+$(".show_tot_amount").text();
                $(".pay_amount").val(totamount);
                var tamount = $(".grand_total").text();
                $('.avenue').val(parseFloat(tamount).toFixed(2));
            }
        }
    });

}

function show_later_time(datetext,obj,e) {
    $('.cart_overlay').show();
    var date         = new Date(datetext);
    // var date         =$("#deliver_date").val();
    var current_date = new Date();
    var week_id      = date.getDay();
    var res_id       = $("#res_id").val();
    var current_time = "";
    $("#l_date").attr('value',datetext);
    if(date.getDate() == current_date.getDate()){
        current_time = current_date.getHours()*60 +current_date.getMinutes()+30;
    }
    if(week_id==0) week_id=7;
    $.ajax({
        url :base_url+'showavailabletime',
        type : "POST",
        data : {
            date            :date,
            res_id          : res_id,
            week_id         : week_id,
            current_time    : current_time,
        },
        dataType : "json",
        success : function(result) {
            if(result.msg == 'opened') {
                var disabledDates = result.datesunavail;
                $("#later_deliver_time").html(result.option_html);
                $('#deliver_date').datepicker("option",'minDate',0);
                $('#deliver_date').datepicker("option",'maxDate',6);
                $('#deliver_date').datepicker("option",'beforeShowDay', function(date){
                    var string = jQuery.datepicker.formatDate('mm/dd/yy', date);
                    return [ disabledDates.indexOf(string) == -1 ]
                });
                $('#deliver_date').datepicker( "refresh" );
                CallCart(e);
            }
        },
        complete : function(e) {
            $('.cart_overlay').hide();
        }
    })
}
function show_later_time_onload(e) {
    $('.cart_overlay').show();
    // var date         = new Date(datetext);
    var date         =$("#deliver_date").val();
    var current_date = new Date();
    var week_id      = '';
    var res_id       = $("#res_id").val();
    var current_time = "";
    $("#l_date").attr('value',date);   
    $.ajax({
        url :base_url+'showavailabletime',
        type : "POST",
        data : {
            date            :date,
            res_id          : res_id,
            week_id         : week_id,
            current_time    : current_time,
        },
        dataType : "json",
        success : function(result) {
            $('.cart_overlay').hide();
            if(result.msg == 'opened') {
                var disabledDates = result.datesunavail;
                $("#later_deliver_time").html(result.option_html);
                $('#deliver_date').datepicker("option",'minDate',0);
                $('#deliver_date').datepicker("option",'maxDate',6);
                $('#deliver_date').datepicker("option",'beforeShowDay', function(date){
                    var string = jQuery.datepicker.formatDate('mm/dd/yy', date);
                    return [ disabledDates.indexOf(string) == -1 ]
                });
                $('#deliver_date').datepicker( "refresh" );
                CallCart(e);
            }
            
        }
    })
}
function textarearestrict(arg) {
    var maxLength = 100;
    var tlength   = arg.val().length;
    if(tlength < maxLength){
        $('#char_note').text(tlength+'/'+maxLength+' Max').css("color","#D5473B;");
    } else {
        $('#char_note').text(tlength+'/'+maxLength+' Max').css("color","red");
    }
}

$(document).on("click",'button#applicableWallet',function(){
    $('.cart_overlay').show(200);
    var useAmount = $('#walletAmount').val();

    
    if (!isNaN(parseFloat(useAmount)) && isFinite(useAmount)) {
        $.ajax({
            url:base_url+'updatewallet',
            data    : {amount : useAmount},
            type:'post',
            success:function(result){

                if(result.status == 1 || result.status == '1'){
                    // Tam
                    // $('.cart_items').html(result.html);
                    $('#walletAmount').val(useAmount);
                    location.reload();

                }else{
                    $('.errorWallet').text(result.message);
                    $('.errorWallet').show(200,function(){
                        setTimeout(function() {
                            $('.errorWallet').hide(200,function(){
                                $('.errorWallet').text('');
                            });
                        }, 3000);
                    });

                }
                $('.cart_overlay').hide(200);
            },
            error:function(e){
                $('.cart_overlay').hide(200);
            }
        });
    }else{
        $('.errorWallet').text('Please Enter Valid Amount');
        $('.errorWallet').show(200,function(){
            setTimeout(function() {
                $('.errorWallet').hide(200,function(){
                    $('.errorWallet').text('');
                });
            }, 3000);
        });
    }
    $('.cart_overlay').slideToggle(200);
});

$(document).on('click','button#cancelWallet',function(){
    var old = $('#walletAmount').val();
    if(old != '' && old != 0){    
        $('#walletAmount').val('0');
        $('button#applicableWallet').trigger('click');
    }else{    
        $('.errorWallet').text("Apply Wallet First");
        $('.errorWallet').show(200,function(){
            setTimeout(function() {
                $('.errorWallet').hide(200,function(){
                    $('.errorWallet').text('');
                });
            }, 3000);
        });
    }
})

