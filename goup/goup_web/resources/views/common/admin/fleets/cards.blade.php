@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Cards') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Cards') }}</span>
            <h3 class="page-title">{{ __('Cards') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('Cards') }}</h6>
                    <a href="#" style="margin-left: 1em;" class="btn btn-success pull-right" data-toggle="modal" data-target="#add-card-modal"><i class="fa fa-plus"></i> @lang('provider.card.add_debit_card')</a>
                </div>

                <div class="col-md-12">
                    <div class="note_txt">
                        @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif
                    </div>
                </div>

                <table id="data-table" class="table table-hover table_width display">
                <thead>
                    <tr>
                        <th width= "25px">@lang('admin.id')</th>
                        <th width= "25px">@lang('provider.card.type')</th>
                        <th width= "25px">@lang('provider.card.four')</th>
                    </tr>
                 </thead>
                </table>
            </div>
        </div>
    </div>
</div>
 <!-- Add Card Modal -->
 <div id="add-card-modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" >
            <div style ="margin-bottom:20px;margin-left:20px;">
                <h4 class="modal-title pull-left">@lang('provider.card.add_debit_card')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form id="payment-form"  class="w-100 validatepaymentForm">
                <input type="hidden" data-stripe="currency" value="usd">
                <div class="modal-body">
                    <div class ="payment-errors" style= "color:red;"></div>
                    <div class="row no-margin" id="card-payment">
                        <div class="form-group col-md-12 col-sm-12">
                            <label>@lang('provider.card.fullname')</label>
                            <input data-stripe="name" autocomplete="off" required class="form-control" type="text" placeholder="@lang('user.card.fullname')">
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                            <label>@lang('provider.card.card_no')</label>
                            <input class="form-control numbers" type="text"  data-stripe="number" required autocomplete="off" maxlength="16" placeholder="@lang('user.card.card_no')" >
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label>@lang('provider.card.month')</label>
                            <input class="form-control numbers" type="text" maxlength="2" required autocomplete="off" data-stripe="exp-month" class="form-control" placeholder="MM">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label>@lang('provider.card.year')</label>
                            <input class="form-control numbers" type="text"  maxlength="2" required autocomplete="off" data-stripe="exp-year" class="form-control"  placeholder="YY">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label>@lang('provider.card.cvv')</label>
                            <input class="form-control numbers" type="text" data-stripe="cvc"  required autocomplete="off" maxlength="4"  placeholder="@lang('user.card.cvv')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="submit"  class="btn btn-accent  btn-block change-pswrd payment-method" >{{ __('Save') }}</button>
                </div>
            </form>

        </div>

      </div>
    </div> 
</div>

@stop
@section('scripts')
@parent
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="{{ asset('assets/plugins/data-tables/js/buttons.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/buttons.html5.min.js')}}"></script>
<script type="text/javascript">
    var tableName = '#data-table';
    var table = $(tableName)
    //For Stripe Details
    @php
    $paymentConfig = json_decode( json_encode( Helper::getSettings()->payment ) , true);
    $cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'card'; }));
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
    Stripe.setPublishableKey("{{ @$stripe_publishable_key }}");
    var stripeResponseHandler = function (status, response) {
        var $form = $('#payment-form');         
        if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').text(response.message);
            $form.find('button').prop('disabled', false);
        } else {
            $form.find('.payment-errors').text(response.message); 
            // token contains id, last4, and card type

            var data = new FormData();

            data.append('stripe_token', response.id);

            $.ajax({
                type:'POST',
                url: getBaseUrl() + "/admin/card",
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                },
                success:function(data){
                    $('#add-card-modal').modal('hide');
                }, error: (jqXHR, textStatus, errorThrown) => {
                    $form.find('.payment-errors').text(jqXHR.responseJSON.message);
                }
            });
        }
    };
    //Payment Details
    $('#payment-form').submit(function (e) {
        e.preventDefault();
        if ($('#stripeToken').length == 0)
        {
            var $form = $(this);
            $form.find('button').prop('disabled', true);               
            Stripe.card.createToken($form, stripeResponseHandler);
            return false;
        }
    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    //For card listing details
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": getBaseUrl() + "/admin/card",
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            data: function(data){
                var info = $(tableName).DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value']; 
                data.order_by = $(tableName+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];
                
            },
            dataFilter: function(data){

                var json = parseData( data );

                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
                json.data = json.responseData.data;
                hideLoader();
                return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "brand" },
            { "data": "last_four" },
        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            dom: 'Bfrtip',
            buttons: [{
               extend: "copy",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "csv",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "excel",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "pdf",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }],"drawCallback": function () {
    
                var info = $(this).DataTable().page.info();
                if (info.pages<=1) {
                   $('.dataTables_paginate').hide();
                   $('.dataTables_info').hide();
                }else{
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                }
            }
    } );
</script> 
@stop
