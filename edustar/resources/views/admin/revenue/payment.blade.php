@extends('admin.layouts.master')
@section('title', 'Payment - Instructor')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Pay to Instructor') }}
@endslot
@slot('menu1')
{{ __('Instructor') }}
@endslot
@slot('menu2')
{{ __('Pay to Instructor') }}
@endslot
@slot('menu3')
{{ __('Pay to Instructor') }}
@endslot

@slot('button')
@endslot

@endcomponent

<div class="contentbar">
  <div class="row">
    <div class="col-xs-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h3 class="box-title">  {{ __('Pay to Instructor') }}</h3>
        </div>
        <div class="card-body">

          <div class="view-order">
            <div class="row">
              <div class="col-md-12">
                <b>{{ __('Instructor') }} </b>:  {{ $user->fname }}
                <br>
                <b>{{ __('Total Instructor Revenue') }}</b>:  {{ $total }}
                <br>
                
              </div>
            </div>
            <br>
          </div>
          
        @if($user->prefer_pay_method == "paypal")
          <form method="post" action="{{ route('admin.paypal', $user->id) }}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <input type="hidden" value="{{ $total }}" name="total" class="form-control">
              
              <div class="d-none">
              @foreach($allchecked as $checked)
               <label >
                  <input type="hidden" name="checked[]" value="{{ $checked }}">
                  {{ $checked }}
               </label>
              @endforeach
              </div>
             
              <b>{{ __('PayPal Email') }}</b>:  {{ $user->paypal_email }}
              <br>
              <br>
               
            <button type="submit" class="btn btn-primary">{{ __('Pay With Paypal') }}</button>
          </form>
        @endif


        @if($user->prefer_pay_method == "banktransfer")
          <form method="post" action="{{ route('admin.banktransfer', $user->id) }}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <input type="hidden" value="{{ $total }}" name="total" class="form-control">
              
              <div class="d-none">
              @foreach($allchecked as $checked)
               <label >
                  <input type="hidden" name="checked[]" value="{{ $checked }}">
                  {{ $checked }}
               </label>
              @endforeach
              </div>
             
              <b>{{ __('Bank Transfer') }}</b>: 

              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>{{ __('Account Holder Name') }}:</b>&nbsp;{{ $user['bank_acc_name'] }}</li>
                <li class="list-group-item"><b>{{ __('Bank Name') }}:</b>&nbsp;{{ $user['bank_name'] }}</li>
                <li class="list-group-item"><b>{{ __('IFSC Code') }}</b>:&nbsp;{{ $user['ifsc_code'] }}</li>
                <li class="list-group-item"><b>{{ __('Account Number') }}:</b>&nbsp;{{ $user['bank_acc_no'] }}</li>
              </ul>
                 
              <br>
               
            <button type="submit" class="btn btn-primary">{{ __('Pay to Instructor') }}</button>
          </form>
        @endif


        @if($user->prefer_pay_method == "paytm")
          <form method="post" action="{{ route('admin.paytm', $user->id) }}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <input type="hidden" value="{{ $total }}" name="total" class="form-control">
              
              <div class="d-none">
              @foreach($allchecked as $checked)
               <label >
                  <input type="hidden" name="checked[]" value="{{ $checked }}">
                  {{ $checked }}
               </label>
              @endforeach
              </div>
             
              <b>{{ __('Paytm Mobile No') }}</b>:  {{ $user->paytm_mobile }}
              <p>{{ __('Do Manual payment paytm') }}</p>
              <br>
              <br>
               
            <button type="submit" class="btn btn-primary">{{ __('Pay With Paytm') }}</button>
          </form>
        @endif
          
         
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>

@endsection


