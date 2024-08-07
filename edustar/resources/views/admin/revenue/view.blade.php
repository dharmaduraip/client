@extends('admin.layouts.master')
@section('title', 'Payout - Admin')
@section('maincontent')

@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('Invoice') }}
@endslot
@slot('menu1')
{{ __('Instructor Payout') }}
@endslot
@slot('menu2')
<a href="{{ route('admin.completed') }}">{{ __('Completed Payout') }}</a>
@endslot
@slot('menu3')
{{ __('Invoice') }}
@endslot


@endcomponent

<div class="contentbar">
  <div class="row">
    <div class="col-md-12">
      <div class="card m-b-30">
        <!-- <div class="card-header">
          <h3 class="box-title">{{ __('Invoice') }}</h3>
        </div> -->
        <div class="card-body">
          <div class="invoice">
            <div class="invoice-head">
              <div class="row">
                <div class="col-12 col-md-7 col-lg-7">
                  @if($gsetting->logo_type == 'L')
                  <div class="logo-invoice">
                    <img src="{{ asset('images/logo/'.$gsetting->logo) }}" style="height:50px">
                  </div>
                  @else()
                  <a href="{{ url('/') }}"><b>
                      <div class="logotext">{{ $gsetting->project_title }}</div>
                    </b></a>
                  @endif
                </div>
                <div class="col-12 col-md-5 col-lg-5 d-flex flex-column align-items-end">
                  <div class="invoice-name">
                    <h5 class="text-uppercase mb-3">{{ __('Invoice') }}</h5>
                    <small>{{ __('Date') }}:&nbsp;{{ date('jS F Y', strtotime($payout['created_at'])) }}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="printableArea">
            <!-- title row -->
            <div class="row d-none">
              <div class="col-xs-12">
                <div class="page-header">
                  @if($gsetting->logo_type == 'L')
                  <div class="logo-invoice">
                    <img src="{{ asset('images/logo/'.$gsetting->logo) }}">
                  </div>
                  @else()
                  <a href="{{ url('/') }}"><b>
                      <div class="logotext">{{ $gsetting->project_title }}</div>
                    </b></a>
                  @endif
                  <small>{{ __('Date') }}:&nbsp;{{ date('jS F Y', strtotime($payout['created_at'])) }}</small>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="view-order">
              <div class="row invoice-info mt-3">
                <div class="col-sm-4 invoice-col">
                  {{ __('From') }}:
                  <address>
                    <strong>{{ $payout->payer['fname'] }}</strong><br>
                    Address: {{ $payout->payer['address'] }}<br>
                    @if($payout->payer['state_id'] == !NULL)
                    {{ $payout->payer->state['name'] }},
                    @endif
                    @if($payout->payer['country_id'] == !NULL)
                    {{ $payout->payer->country['name'] }}
                    @endif
                    <br>
                    {{ __('Phone') }}:&nbsp;{{ $payout->payer['mobile'] }}<br>
                    {{ __('Email') }}:&nbsp;{{ $payout->payer['email'] }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  {{ __('To') }}:
                  <address>
                    <strong>{{ $payout->user['fname'] }}</strong><br>
                    {{ __('Address') }}: {{ $payout->user['address'] }}<br>
                    @if($payout->user['state_id'] == !NULL)
                    {{ $payout->user->state['name'] }},
                    @endif
                    @if($payout->user['country_id'] == !NULL)
                    {{ $payout->user->country['name'] }}<br>
                    @endif
                    {{ __('Phone') }}:&nbsp;{{ $payout->user['mobile'] }}<br>
                    {{ __('Email') }}:&nbsp;{{ $payout->user['email'] }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <br>
                  <b>{{ __('OrderId') }}:</b>&nbsp;

                  @foreach($payout->order_id as $order)
                  @php
                  $id= App\Order::find($order);
                  @endphp
                  {{ $id['order_id'] }},

                  @endforeach
                  <br>

                  <b>{{ __('PaymentMethod') }}:</b>&nbsp;{{ $payout['payment_method'] }}<br>
                  <b>{{ __('Currency') }}:</b>&nbsp;{{ $payout['currency'] }}
                </div>
                <!-- /.col -->
              </div>
            </div>
            <!-- /.row -->

            <div class="order-table">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>{{ __('Instructor') }}</th>
                    <th>{{ __('Currency') }}</th>

                    <th>{{ __('Total') }}</th>
                    <th>{{ __('PaymentMethod') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $payout->user['fname'] }}</td>
                    <td>{{ $payout['currency'] }}</td>
                    <td>{{ $payout['currency_icon'] }} {{ $payout['pay_total'] }}</td>
                    <!-- <i class="fa {{ $payout['currency_icon'] }}"></i> -->
                    <td>{{ $payout->payment_method }}</td>



                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>


          <div class="form-group">

            <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print" />

            <div class="print-btn" style="display: inline-block;">
              <a href="{{route('payout.download',$payout->id)}}" target="_blank" class="btn btn-secondary">{{ __('Download') }}</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@section('scripts')

<script>
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });
</script>

<script lang='javascript'>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();
  }
</script>
@endsection