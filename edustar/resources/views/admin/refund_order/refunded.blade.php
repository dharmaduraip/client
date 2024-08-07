
<!-- /.box-header -->
<div class="box-body">

  <div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
     
      <tr>
        <th>#</th>                  
        <th>{{ __('User') }}</th>
        <th>{{ __('Course') }}</th>
        <th>{{ __('OrderId') }}</th>
        <th>{{ __('PaymentMethod') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('View') }}</th>
        <th>{{ __('Delete') }}</th>
      </tr>
      </thead>
      <tbody>
      @foreach($refunds as $key=>$refund)

      @if($refund->status == 1)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $refund->user['fname'] }}</td>
        <td>{{ $refund->courses->title }}</td>
        <td>{{ $refund->order->order_id }}</td>
        <td>{{ $refund->payment_method }}</td>
        <td>
           
            @if($refund->status ==1)
            {{ __('Refunded') }}
            @else
            {{ __('Pending') }}
            @endif
             
        </td>
        
        <td><a class="btn btn-success btn-sm" href="{{url('refundorder/'.$refund->id.'/edit')}}">
          {{ __('view') }}</a>
        </td>

        <td><form  method="post" action="{{url('refundorder/'.$refund->id)}}
              "data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
            <button  type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
          </form>
        </td>

        @endif

        @endforeach

      </tr>
      </tfoot>
    </table>
  </div>
</div>
<!-- /.box-body -->