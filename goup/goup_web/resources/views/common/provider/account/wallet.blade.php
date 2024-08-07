@extends('common.provider.layout.base')
{{ App::setLocale(   isset($_COOKIE['provider_language']) ? $_COOKIE['provider_language'] : 'en'  ) }}
@section('styles')
@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}" />
@stop
@php

$paymentConfig = json_decode( json_encode( Helper::getSettings()->payment ) , true);
$cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'card'; }));
//print_r($cardObject);exit;
$card = 0;

$stripe_publishable_key = "";

if(count($cardObject) > 0) {
$card = $cardObject[0]['status'];

$stripePublishableObject = array_values(array_filter( $cardObject[0]['credentials'], function ($e) { return $e['name'] == 'stripe_publishable_key'; }));


if(count($stripePublishableObject) > 0) {
$stripe_publishable_key = $stripePublishableObject[0]['value'];
}
}

@endphp
@section('content')
<section class="wallet-grid content-box">
    <div class="clearfix ">
        <div id="toaster" class="toaster">
        </div>
        <h4><strong class="title-bor">@lang('provider.transaction_details')</strong></h4>
        <div class="col-md-12 p-0">

            <div class="col-md-6 col-xl-3 col-xs-12 top pull-left">
                <div class="col-md-12 top small-box green pull-left">
                    <div class="left">
                        <h2>@lang('provider.balance')</h2>
                        <h4><i class="material-icons">account_balance_wallet</i></h4>
                        <span class="currency"></span>
                        <h1 class="wallet_balance"></h1>
                    </div>
                </div>
                <div class="col-md-12 top pull-left">
                    <div class="left" style="width:118%;margin-left:-12%">
                        <select class="form-control earnings">
                            <option value="today">Today Earnings</option>
                            <option value="week">This Week Earnings</option>
                            <option value="month">This Month Earnings</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 top small-box green pull-left">
                    <div class="left">
                        <h2>@lang('provider.balance')</h2>
                        <h4><i class="material-icons">account_balance_wallet</i></h4>
                        <span class="currency"></span>
                        <h1 class="earnings_amount"></h1>
                    </div>
                </div>
            </div>

            @if($card==1)
            <!--Add card and amount details!-->
            <div class="col-md-4 col-lg-4 col-sm-12 p-0 pull-right">
                <button id="userAddMoney" class="btn btn-secondary mt-3">@lang('user.add_money')</button>
                <button id="userSendMoney" class="btn btn-secondary mt-3">@lang('user.send_money')</button>
                <button id="userReceiveMoney" class="btn btn-secondary mt-3">@lang('user.receive_money')</button>
                <br><br>
                <div id="addMony" >
                    <form class="validateCardForm" style="color:red;">
                        <!-- <input type="hidden" name="payment_mode" value="CARD"> -->
                        <input type="hidden" name="user_type" value="provider">
                        <h5 class=""><strong>@lang('user.enter_amount')</strong></h5>
                        <input type="text" class="form-control price" name="amount" placeholder="@lang('user.enter_amount')">
                        <h5 class=""><strong>@lang('user.select_payment')</strong></h5>
                                <select name="payment_mode" id="payment_mode" class="custom-select">
                                    <option value="">Select</option>
                                    <option value="CARD">CARD</option>
                                    <option value="PAYPAL">PAYPAL</option>                         
                                    <option value="NOWPAYMENT">NOWPAYMENT</option>
                                    <option value="REVOLUT">REVOLUT</option>
                                </select>
                        <br>
                        <div class="card-block" style="display: none;">
                        <h5 class=""><strong>@lang('user.select_card')</strong></h5>
                        <select name="card_id" id="card_id" class="form-control">
                            <option value="">Select</option>
                        </select>
                        <br>
                        </div>
                         <div class="revoult_hide">
                            <button id="submit-button" class="btn btn-primary mt-3">@lang('user.add_money')</button>
                        </div>
                    </form>
                     <div class="revoult_show" style="display:none;">
                                <button id="pay-button" class="btn btn-secondary mt-3" >@lang('user.Click_Revolut_Pay')</button>
                     </div>
                </div>
                <div id="sendMoney" style="display: none;">
                    <form class="sendMoney"  style= "color:red;" >
                        <h5 class=""><strong class="">@lang('user.profile.mobile')</strong></h5>
                        <input type="text" id ="mobile" class="form-control numbers" name="mobile" placeholder="@lang('user.profile.mobile')" >
                        <h5 class=""><strong class="enter_amount">@lang('user.enter_amount')</strong></h5>
                        <input type="text" id ="amount" class="form-control price" name="amount" placeholder="@lang('user.enter_amount')" >
                        <br>
                        <button id="submit-button"  class="btn btn-secondary mt-3">@lang('user.send_money')</button>
                    </form>
                </div>
                <div id="receiveMoney" style="display: none;">
                         
                </div>
                <!-- <input class="form-control" type="number" name="" placeholder="Enter Amount" required>
                <a  class="btn btn-primary mt-3" data-toggle="modal" data-target="#addMoney">Add Money</a> -->
            </div>
            @endif
        </div>
        <div class="row wallet-details m-0 pull-left" style="width: 100%;">
            <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm mt-5">
                <table id="payment_grid" class="table  table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>@lang('provider.sno')</th>
                            <th>@lang('provider.transaction_ref')</th>
                            <!-- <th>@lang('provider.transaction_desc')</th> -->
                            <th>@lang('provider.datetime')</th>
                            <th>@lang('provider.amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@stop
@section('scripts')
@parent
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(document).on('click','#userAddMoney', function() { 
        $('#receiveMoney').hide();
        $('#sendMoney').hide();
        $('#addMony').show();   
    });
    $(document).on('click','#userSendMoney', function() {     
        $('#receiveMoney').hide();
        $('#sendMoney').show();
        $('#addMony').hide();
    });
    $(document).on('click','#userReceiveMoney', function() {     
        $('#sendMoney').hide();
        $('#addMony').hide();
        $('#receiveMoney').show();
    });  
    $(document).on('change','#payment_mode', function() {     
        var select=$('#payment_mode :selected').val()
        if(select=='CARD'){
            $('.card-block').show();
        }
        else if(select=='PAYPAL'){
            $('.card-block').hide();
        }
    });
 

    var payment_table = $('#payment_grid');
    $(document).ready(function() {
        var payment_table = $('#payment_grid').DataTable();
        $(payment_table.table().container()).removeClass('form-inline');
        $('.dataTables_length select').addClass('custom-select');
        $('.dataTables_paginate li').addClass('page-item');
        $('.dataTables_paginate li a').addClass('page-link');
    });

    function openNav() {
        document.getElementById("mySidenav").style.width = "50%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function add_money(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    $.ajax({
        type: "GET",
        url: getBaseUrl() + "/provider/card",
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        success: function(data) {
            var html = ``;
            var result = data.responseData;
            $.each(result, function(key, item) {
                $("#card_id").empty()
                .append('<option value="">Select</option>');
                $.each(data.responseData, function(key, item) {
                    $("#card_id").append('<option value="' + item.card_id + '"> **** **** **** ' + item.last_four + '</option>');
                });
            });
        }
    });
    var earnings=[];   
    var provider_id=getProviderDetails().id;
    $.ajax({
        type: "GET",
        url: getBaseUrl() + "/provider/earnings/"+provider_id,
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        success: function(data) {
            var result=earnings= data.responseData;
            $('.earnings_amount').text(getProviderDetails().currency_symbol+result.today);

        }
    });

    $('.earnings').change(function(){
        var date=$(this).val();
        if(date=="today"){
            $('.earnings_amount').text(getProviderDetails().currency_symbol+earnings.today);
        }else if(date=="week"){
            $('.earnings_amount').text(getProviderDetails().currency_symbol+earnings.week);

        }else{
            $('.earnings_amount').text(getProviderDetails().currency_symbol+earnings.month);

        }
    })


    //List the provider wallet  details
    $.ajax({
        type: "GET",
        url: getBaseUrl() + "/provider/list",
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        success: function(data) {
            var result = data.responseData;

            $('.wallet_balance').text((result.currency_symbol) + (result.wallet_balance).toFixed(2));
            $('#receiveMoney').prepend('<img id="theImg" src='+ result.qrcode_url +' height="230px" width="230px" />');
        }
    });
    //List the  userwallet details
    payment_table = payment_table.DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": getBaseUrl() + "/provider/wallet",
            "type": "GET",
            "headers": {
                "Authorization": "Bearer " + getToken("provider")
            },
            data: function(data) {

                var info = $('#payment_grid').DataTable().page.info();
                delete data.columns;
                data.page = info.page + 1;
                data.search_text = data.search['value'];
                data.order_by = $('#payment_grid tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];
            },
            dataFilter: function(data) {
                var json = parseData(data);
                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
                json.data = json.responseData.data;
                return JSON.stringify(json); // return JSON string
            }
            },
            "columns": [{
                "data": "id",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "transaction_alias",
                "data": "id",
                render: function(data, type, row) {
                    var result = row.transactions;
                    var alias = row.transaction_alias;
                    var transacts = ``;
                    $.each(result, function(key, item) {
                        type = item.type;
                        if (type == "C") {
                            typename = "Credit";
                        } else {
                            typename = "Debit";
                        }
                        transacts = transacts + `<tr><td>` + item.transaction_desc + `</td><td>` + typename + `</td><td>` + item.amount + `</td></tr>`;
                    });
                    var result = ` <div class="d-flex align-items-center"><div class="btn btn-xs btn-info collapsed" data-toggle="collapse" data-target="#modal` + alias + `" data-id = ` + data + ` data-toggle="tooltip" title="View" style="padding:5px !important; margin-right:10px !important; width:auto;"><i class="fa fa-eye"></i></div> ` + row.transaction_alias;
                    result += `</div><div id="modal` + alias + `" class="collapse">
                    <table class="table table-responsive">
                    <thead>
                    <tr>
                    <th>Description</th><th>Type</th><th>Amount</th>
                    </tr>
                    <tbody>` +
                    transacts +
                    `</tbody>
                    </table>
                    </div>`;
                    return result;
                }
            },

            // { "data": "transaction_alias" },
            {
                "data": "created_time"
            },
            {
                "data": "amount",
                render: function(data, type, row, meta) {
                    var amt = row.provider.currency_symbol + parseFloat(data).toFixed(2);
                    return amt;
                }
            },

            ],
            "drawCallback": function() {
                $('.dataTables_length select').addClass('custom-select');
                $('.dataTables_paginate li').addClass('page-item');
                $('.dataTables_paginate li a').addClass('page-link');
                var info = $(this).DataTable().page.info();
                if (info.pages <= 1) {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_info').hide();
                } else {
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                }
            }
        });
    function revoult_success(id,merchant_order_ext_ref){
       
         $.ajax({
                type:'GET',
                // url: getBaseUrl() + "/provider/wallet/revoult_success/"+id+"/"+merchant_order_ext_ref,
                url: getBaseUrl() + "/provider/wallet/revoult_success?id="+id+"&merchant_order_ext_ref="+merchant_order_ext_ref,
                data: id,
                processData: false,
                contentType: false,
                headers: {
                   Authorization: "Bearer " + getToken("provider")
                },
                success:function(data){
                    var data = parseData(data);
                    alertMessage("Success", data.message, "success");
                    location.reload();
                }, 
                error: function(jqXHR, textStatus, errorThrown) {
                        
                        if (jqXHR.status == 401 && getToken(guard) != null) {
                           refreshToken(guard);
                        } else if (jqXHR.status == 401) {
                           window.location.replace("/provider/login");
                        }

                        if (jqXHR.responseJSON) {
                           
                           alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                        }
                        hideInlineLoader();
                  } 
            });
    }
    //Add the money details
    $('.validateCardForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            card_id: {
                required: true
            },
            amount: {
                required: true,
                min: 1
            },
        },
        messages: {
            card_id: {
                required: "Card is required."
            },
            amount: {
                required: "Amount is required."
            },
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        success: function(label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        submitHandler: function(form) {
            var formGroup = $(".validateCardForm").serialize().split("&");
            var data = new FormData();

            for (var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append(decodeURIComponent(params[0]), decodeURIComponent(params[1]));
            }

            $.ajax({
                type: 'POST',
                url: getBaseUrl() + "/provider/add/money",
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    Authorization: "Bearer " + getToken("provider")
                },
                beforeSend: function (request) {
                        showInlineLoader();
                },
                success: function(data) {
                     if(data.responseData.payment_mode == 'REVOLUT'){
                         hideInlineLoader();
                        $('.revoult_show').show();
                        $('.revoult_hide').hide();

                            RevolutCheckout(data.responseData.data.public_id,'sandbox').then(function (RC) {
                            var payButton = document.getElementById("pay-button");
                            // On click open payment pop-up
                            payButton.addEventListener("click", function () {
                              RC.payWithPopup({
                                // (mandatory!) name of the cardholder
                               // name: "First Last",
                               
                                // Callback called when payment finished successfully
                                onSuccess() {
                                    revoult_success(data.responseData.data.id,data.responseData.data.merchant_order_ext_ref);
                                 // window.alert("Thank you!");

                                },
                                // Callback in case some error happened
                                onError(message) {
                                  window.alert("Oh no :(");
                                },
                                // (optional) Callback in case user cancelled a transaction
                                onCancel() {
                                  window.alert("Payment cancelled!");
                                },
                              });
                            });
                          });

                    }
                    else if(data.payment_mode == 'paypal'){
                        if(data.url != null) {
                            location.assign(data.url);
                        } else {
                            hideLoader();
                            alertMessage('Error', data.message, "danger");
                        }
                    }else if(data.responseData.payment_mode == 'NOWPAYMENT'){
                        if(data.responseData.url != null) {
                            location.assign(data.responseData.url);
                        } else {
                            hideLoader();
                            alertMessage('Error', data.message, "danger");
                        }
                    }else{
                        var data = parseData(data);
                        alertMessage("Success", data.message, "success");
                        var userdata = localStorage.getItem('user');
                        userdata = JSON.parse(decodeHTMLEntities(userdata));
                        userdata.wallet_balance = data.responseData.wallet_balance;
                        setProviderDetails(userdata);
                        hideInlineLoader();
                        location.reload();
                        // hideInlineLoader();
                    }
                },
                 error: function(jqXHR, textStatus, errorThrown) {
                        
                        if (jqXHR.status == 401 && getToken(guard) != null) {
                           refreshToken(guard);
                        } else if (jqXHR.status == 401) {
                           window.location.replace("/provider/login");
                        }

                        if (jqXHR.responseJSON) {
                           alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                        }
                        hideInlineLoader();
                  } 
            });
        }
    });
     //Send the money details
    $('.sendMoney').validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-block', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    rules: {
            mobile: { required: true },
            amount: { required: true,min:1 },
    },
    messages: {
         mobile: { required: "{{__('user.mobile_required')}}" },
         amount: { required: "{{__('user.amount_required')}}" },
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
      var formGroup = $(".sendMoney").serialize().split("&");
            var data = new FormData();
      for(var i in formGroup) {
        var params = formGroup[i].split("=");
                data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }
         
            $.ajax({
                type:'POST',
                url: getBaseUrl() + "/provider/wallet/transfer",
                data: data,
                processData: false,
                contentType: false,
                headers: {
                   Authorization: "Bearer " + getToken("provider")
                },
                success:function(data){
                    var data = parseData(data);
                    alertMessage("Success", data.message, "success");
                    var userdata = localStorage.getItem('user');
                    userdata = JSON.parse(decodeHTMLEntities(userdata));
                    userdata.wallet_balance = data.responseData.wallet_balance;
                    setUserDetails(userdata);
                    location.reload();
                }, 
                error: function(jqXHR, textStatus, errorThrown) {
                        
                        if (jqXHR.status == 401 && getToken(guard) != null) {
                           refreshToken(guard);
                        } else if (jqXHR.status == 401) {
                           window.location.replace("/provider/login");
                        }

                        if (jqXHR.responseJSON) {
                           
                           alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                        }
                        hideInlineLoader();
                  } 
            });
    }
    });
</script>
@stop