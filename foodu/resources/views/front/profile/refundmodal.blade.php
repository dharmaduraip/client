<div class="alert alert-success alert-dismissible fade in" role="alert">
  <strong>Status : </strong> {{ $message }}
  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@if(!isset($data))
  <form action="{{ \URL::to('refund/checkrefund') }}" action="post" enctype="multipart/form-data" id="giveRefund">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="oId" value="{{ $oId }}">
    <div class="form-group">
      <label for="email">Select Type :</label>
      <select class="form-control" name="type" required>
        <option value="">--- Select Type ---</option>
        <option value="refund">Refund</option>
        <option value="replace">Replacement</option>
      </select>
    </div>
    <div>
      <label for="select_item">Select Items :
        <span class="errorNoItems alert alert-dismissible alert-danger fade"></span>
      </label>      
      <table class="table">
        <thead>
          <th>id</th>
          <th>Food Name</th>
          <th>adon_detail</th>
          <th>quantity</th>
          <th>amount</th>
        </thead>
        <tbody>
          @if(!empty($order) && count($order->order_items) > 0)
            @foreach($order->order_items as $k => $v)
            <tr>
              @if($v->check_status === 'yes')
              <?php
              $TotPrice = 0; 
              $TotPrice += $v->selling_price_total; 
              ?>
              <td><input type="checkbox" name="items[]" checked class="form-control order_items" value="{{ $v->id }}">{!! $k + 1 !!}</td>
              <td>{!! $v->food_item!!}</td>
              <td>{!! $v->adon_detail!!}</td>
              <td>{!! $v->quantity !!}</td>
              <td>{!! isset($cur_symbol) !!}&nbsp;{!! number_format($v->selling_price_total,2) !!}</td>
              @endif
            </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
    <div class="form-group">
      <label for="email">Enter Comment :</label>
      <textarea class="customer_comment form-control" name="customer_comment" required ></textarea>
    </div>
    <div class="form-group">
      <label for="pwd">Upload Images:</label>
      <input type="file" name="image[]" multiple class="form-control" required  accept="image/x-png,image/jpeg">
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-default">Send</button>
  </div>
  </form>
@else
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a data-toggle="collapse" href="#customer_request">Customer Request</a>
      <span class="label status label-info">{{ $data->customer_image_status }}</span>
    </h4>
  </div>
  <div id="customer_request" class="panel-collapse collapse">
    <div class="panel-body">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          {{--*/
            $images = $data->customer_src;
            $imagesArray = [];
            if($images != '' && $images != null){
              $imagesArray = $images;
              $imagesArray = $images;
            }
            /*--}}
          @if(!empty($imagesArray))
            @foreach($imagesArray as $iKey => $iValue)
              <div class="item @if($iKey == 0) active @endif">
                <img src="{{ $iValue }}" alt="{{ $iKey }}">
              </div>
            @endforeach
          @else
            <div class="item active">
              <img src="{{ \URL::to('public/1280x853.png') }}" alt="No-Image">
            </div>
          @endif
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <div class="panel-footer">
      <div class="media">
        <div class="pull-left">
          <img src="{{ $data->getMainOrder->getCustomerInfo->src }}" class="media-object" style="width:60px">
        </div>
        <div class="media-body">
          <h4 class="media-heading">Customer Comments</h4>
          <p>{{ $data->comment }}</p>
        </div>
      </div>
      <hr>
      <div class="media">
        <div class="pull-right">
          <img src="{{ \Auth::user()->src }}" class="media-object" style="width:60px">
        </div>
        <div class="media-body">
          <h4 class="media-heading">Admin Comments @if($data->customer_image_status != 'Pending') <span class="label status label-info"> {{ $data->customer_image_status }}</span> @endif</h4>
          <div class="row">
            @if($data->customer_image_status == 'Pending')
            <div class="col-md-10">
              {{ $message }}
            </div>
            @else
            <div class="col-md-10">
              {{ json_decode($data->admin_comment)->for_customer }}
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="adminActionMessage"></div>
    </div>
  </div>
</div>

@endif

@if(isset($data) && $data->boy_image_status == 'Approved')
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#refund_details">Transaction Details <span class="label status label-info">@if($data->gatCheckWallet()->count() > 0) Refunded @else Not Refunded @endif</span></a>
        </h4>
      </div>
        <div id="refund_details" class="panel-collapse collapse">
          <div class="panel-body">
            <div class="adminActionRefundMessage"></div>
              @if($data->gatCheckWallet()->count() > 0)
                Refunded Amount : {{ $data->gatCheckWallet->amount }}
              @else
                Refunded Amount : 0
              @endif
          </div>
      </div>
    </div>
  </div>
@endif