<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title id="title">Tastyeats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        th{
            text-align: left;
        }
        ul li{
            list-style: none;
            margin-bottom: 5px;
        }

        ul.add li{
            margin-bottom: 12px;
        }
        table, th, td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        th, td {
            color: #444;
            padding: 3px 10px;
        }
        b{
            font-weight: bold;
            color: #212121;
        }
        table thead th {
            background: #EFEFEF !important;
            padding: 10px !important;
            color: #444;
            font-weight: bold;
        }
        table th {

            color: #444;
            font-weight: bold;
        }


        .label{
            background-color: #23c6c8;
            color: #fff;
            padding: 3px;
        }
        .label-war{
            background-color: #f8ac59;
            color: #fff;
            font-size: 12px;
            padding: 3px;
        }

        table.addgst {border-collapse: collapse;}
        .addgst td    {padding: 6px;}

        .addgst1 td    {padding: 5px;padding-right: 12px;}
        .addgst .bold{
            font-weight: 500;
        }

    </style>
</head>
<body style="background-color:#fff">
    <div style="width: 720px;margin: auto;height:auto;background-color:white">
        <div style="display: flex;justify-content: space-between;padding:10px">

            <ul style="padding:0">
                <li><b>Order ID:</b>#{!! $aOrder->id !!} - {!! $aOrder->restaurant_info->name !!}
                    <label class="label">Deliver {!! $aOrder->delivery_preference !!}</label></li>
                    <li><b>Order Date:</b> &nbsp;{!! $aOrder->created_at !!}</li>
                </ul>
                <ul style="float: right;">
                    <li><label class="label-war">{!! $aOrder->status_text !!}</label></li>

                    @if($aOrder->delivery_type != '')
                    <li>Payment Type: &nbsp;
                        @if($aOrder->refund_status == 1)Refunded @else
                        {!! ($aOrder->delivery_type =='cashondelivery' ? 'COD' : (($aOrder->delivery_type =='stripe') ? 'Stripe' : (($aOrder->delivery_type =='paypal') ? 'Paypal' : '')))  !!}
                    @endif</li>

                    <li>Payment Status:&nbsp;
                        @if($aOrder->refund_status == 1)Refunded @else
                        {!! ($aOrder->delivery =='paid' ? 'Paid' : 'Unpaid')  !!}
                    @endif</li>@endif
                </ul>
        </div>
        <div style="border-top: 1px solid #cec8c8;padding: 0 20px 0 20px;">
                <ul style="padding:7px;width: 500px;border: 1px solid #ddd" class="add">
                    <li><b>Customer</b></li>
                    <li><b>Name:</b>{!! $aOrder->user_info->username !!}</li>
                    <li><b>Address:</b> {!! $aOrder->address !!}</li>
                    @if(\Auth::user()->group_id!='3')
                    <li><b>Email:</b> {!! $aOrder->user_info->email!!}</li>

                    <li><b>Phone:</b>{!! $aOrder->mobile_num !!}</li>
                    @endif
                </ul>
                <div id="items">
                    <table style="width:100%">
                        <thead style="text-align: left;">
                            <tr>
                                <th>S.No</th>
                                <th>Product Item</th>
                                {{-- <th>Adon Detail</th> --}}
                                <th>Price</th>
                                <th>GST (%)</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($aOrder->accepted_order_items) > 0)
                            <?php $TotPrice = 0;?>
                            @foreach($aOrder->accepted_order_items as $key => $value)
                            <tr style="background-color: #f9f9f9;">
                                <td>{!! $key + 1 !!}</td>
                                <td>{!! $value->food_item!!}</td>
                                {{-- <td>{!! $value->adon_detail!!}</td> --}}
                                @if($value->check_status === 'yes')
                                <?php $TotPrice += $value->quantity * ((float) $value->selling_price );  
                                ?>
                                <td style="white-space: nowrap;">Rs.&nbsp;{!! number_format(((float)$value->base_price+$value->base_price_gst+$value->hiking_price+$value->hiking_gst_price ),2) !!}</td>
                                <td>@if($value->gst > 0){!! $value->gst !!} - {!! (($value->hiking_gst_price + $value->base_price_gst) * $value->quantity) !!}@endif</td>
                                {{-- <td>Rs.&nbsp;{!! number_format(((float)$value->vendor_price ),2) !!}</td> --}}
                                <td>{!! $value->quantity !!}</td>
                                <td style="white-space: nowrap;">Rs.&nbsp;{!! number_format((((float) $value->base_price + $value->hiking_price + $value->base_price_gst + $value->hiking_gst_price )*$value->quantity  ),2) !!}</td>
                            </tr>
                            @endif   
                            @endforeach
                            @if(!empty($aOrder->inaugural_offer) && $aOrder->inaugural_offer['isfirst'])
                            <tr>
                                <td style="background-color:#baf8f9"></td>
                                <td style="background-color:#baf8f9">{!! $aOrder->inaugural_offer->offer_name !!}</td>
                                <td style="background-color:#baf8f9;color: #008000;">FREE</td>
                                <td style="background-color:#baf8f9"></td>
                                <td style="background-color:#baf8f9"></td>
                            </tr>
                            @endif
                        </tbody>

                    </table> 
                    <table class="table table-bordered table-striped table-hover down_data" style="width:100%">
                        <tr>
                            <td style="border:none;padding-right: 0;">
                                @if(Auth::user()->group_id=='1' || Auth::user()->group_id == '2')
                                <table style="width:100%;border: none;">
                                    <tbody>
                                        <tr>
                                            <td style="border:none;width: 50%;" valign="top">
                                                <table class="addgst" valign="middle" style="width:100%">
                                                    <?php $id = $aOrder->id;
                                                    $bifur = AbserveHelpers::GSTBifurcation($id); ?>
                                                    @if($bifur > 0)
                                                    <?php
                                                    $tGst=0;
                                                    $tPrice=0;
                                                    $packaging_charge=0;
                                                    $festival_charge=0;
                                                    $weather_charge=0;
                                                    $packaging_tax =0;
                                                    $festival_tax =0;
                                                    $weather_tax=0;
                                                    ?>
                                                    @foreach($bifur as $key => $val)
                                                    <?php
                                                    $per_val = (100/18);
                                                    if($aOrder->add_del_charge > 0){
                                                        $packaging_tax = number_format(($aOrder->add_del_charge / $per_val),2) ;
                                                        $packaging_charge = number_format(($aOrder->add_del_charge - $packaging_tax),2);
                                                    }
                                                    if($aOrder->festival_mode_charge > 0){
                                                        $festival_tax =  number_format(($aOrder->festival_mode_charge / $per_val),2) ;
                                                        $festival_charge = number_format(($aOrder->festival_mode_charge - $festival_tax),2) ; 
                                                    }
                                                    if($aOrder->bad_weather_charge > 0){
                                                        $weather_tax =  number_format(($aOrder->bad_weather_charge / $per_val),2);
                                                        $weather_charge = number_format(($aOrder->bad_weather_charge - $weather_tax),2) ; 
                                                    }
                                                    $delcharge = $aOrder->del_charge;
                                                    $del_tax = $aOrder->del_charge_tax_price;
                                                    $tGst   += array_sum($val['gst']);
                                                    $tPrice += array_sum($val['price']);
                                                    $gst    = array_sum($val['gst']);
                                                    $price_gst = array_sum($val['price']);
                                                    ?>
                                                    <tr>
                                                        <td><span class="bold">{{ $key }} % GST </span></td>
                                                        @if($key == "18")
                                                        <td>{!! abs($price_gst + $delcharge + $packaging_charge + $festival_charge + $weather_charge) !!}</td>
                                                        <td>{!! $gst + $del_tax + $packaging_tax + $festival_tax + $weather_tax !!}</td>
                                                        @else
                                                        <td>{{ abs($price_gst) }}</td>
                                                        <td>{{ $gst }}</td>
                                                        @endif
                                                        @if(!(array_key_exists("18",$bifur)))
                                                        <tr>
                                                            <td><span class="bold">18% GST </span></td>
                                                            <td>{!! abs($delcharge + $packaging_charge + $festival_charge + $weather_charge)  !!}</td>
                                                            <td>{!! $del_tax + $packaging_tax + $festival_tax + $weather_tax !!}</td>
                                                        </tr>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                    <td><span class="bold">Total GST = </span></td>
                                                    <td></td>
                                                    <td>{{ $tGst + isset($del_tax) + $packaging_tax + $festival_tax + $weather_tax }}</td>
                                                </table>
                                                @else
                                                <table>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>

                                                    </tr>
                                                </table>
                                                @endif
                                                @endif
                                            </td>
                                            <td style="border:none;width: 50%;padding: 0;">
                                                <table class="addgst1">
                                                    <tr>
                                                        <td style="font-weight: bold;">Item Price</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $TotPrice !!}</td>
                                                    </tr>
                                                    @if(\Auth::user()->group != 3)
                                                    @if($aOrder->offer_price > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;">Offer Price</td>
                                                        <td style="font-weight: bold;text-align:right;">${!! $aOrder->offer_price !!}</td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->s_tax1 > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;">Tax Price</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->s_tax1 !!}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td style="font-weight: bold;">Delivery Charge(Incl. GST)</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! ($aOrder->del_charge + $aOrder->del_charge_tax_price)  !!}</td>
                                                    </tr>
                                                    @if($aOrder->add_del_charge > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;">Packaging Charge (Incl. GST) </td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->add_del_charge !!}</td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->bad_weather_charge > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;">Bad Weather Charge (Incl. GST)</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->bad_weather_charge !!}</td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->festival_mode_charge > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;"> Festival Charge (Incl. GST)</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->festival_mode_charge !!}</td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->del_charge_discount > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;">Delivery Charge Discount</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->del_charge_discount !!}</td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->coupon_price > 0)
                                                    <tr>
                                                        <td style="font-weight: bold;">Coupon Discount</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->accept_coupon_price !!}</td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->cash_offer > 0)
                                                    <tr>
                                                        <td  style="font-weight: bold;">Cash back offer amount</td>
                                                        <td style="font-weight: bold;text-align:right;color:red;"> - Rs. {!! $aOrder->cash_offer !!} </td>
                                                    </tr>
                                                    @endif
                                                    @if($aOrder->wallet_amount > 0)
                                                    <tr>
                                                        <td  style="font-weight: bold;">Wallet amount</td>
                                                        <td style="font-weight: bold;text-align:right;color:red;"> - Rs. {!! $aOrder->wallet_amount !!}</td>
                                                    </tr>
                                                    @endif
                                                    <?php $wallet = ($wallet != '') ? $wallet : 0 ; ?>
                                                    <tr>
                                                        <td style="font-weight: bold;">Amount Refunded @if(Auth::user()->group_id == '1') (Customer wallet) @endif  </td>
                                                        <td style="font-weight: bold;text-align:right;white-space: nowrap;">Rs.{!! $wallet !!} </td>
                                                    </tr>
                                                    @if($aOrder->gst > 0)
                                                    <tr>
                                                        <td  style="font-weight: bold;">GST</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs.{!! $aOrder->gst !!}</td>
                                                    </tr>
                                                    @endif
                                                    @endif
                                                    <tr>
                                                        <td style="font-weight: bold;">Grand Total</td>
                                                        <td style="font-weight: bold;text-align:right;">Rs. {!! abs($aOrder->accept_grand_total - $aOrder->cash_offer) !!}</td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>              
                </div>
        </div>
    </div>
    
</body>
</html>