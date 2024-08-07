<div class="smallHeading">{!! Lang::get("core.abs_wallet") !!}
         <button id="topup-btn" class="btn btn-primary">Top-Up Wallet </button>
</div>
 <div class="table-responsive" style="min-height:300px;">
    <table class="table table-striped ">
        <thead>
			<tr>
				<th class="number"> No </th>
				<th>Order Id</th>
				<th>Amount Added</th>
				<th>Reason</th>
				<th>Date</th>
			  </tr>
        </thead>

        <tbody>  
        <?php $p = 0; ?>					
            @foreach ($wallet as $i => $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>						
					<td>{{ $row->order_id }}</td>
					<td>{{ \AbserveHelpers::CurrencySymbol( number_format($row->amount,2,'.','')) }} <?php if($row->type=="credit"){ echo "(<span style='color:green;'>+</span>)"; } else { echo "(<span style='color:red;'> - </span>)";} ?></td>
					<td>{{ $row->title }}</td>
					<td>{{ $row->date }}</td> 
                </tr>
				<?php $p++; ?>
            @endforeach  
            {{-- <tr style="color:red;"><td colspan="2" >Wallet Balance: </td><td colspan="3">{{ \SiteHelpers::CurrencySymbol( number_format(\Auth::user()->customer_wallet,2,'.','')) }}</td></tr> --}}
        </tbody>
    </table>
            {!! $wallet->appends($_REQUEST)->render() !!}
    <script>
		 $(document).ready(function() {
		    $('#topup-btn').click(function() {
		        $('#topup-modal').modal('show');
		    });
		}); 
		function topupwallet(response){
	    var token = '<?php echo \Session::get('access_token'); ?>';
	    $('#topup-modal').modal('hide');
	    console.log(response);
	    console.log(response['razorpay_payment_id']);
        $.ajax({
            url : base_url+"api/user/userWalletTopup",
            data : {'razorpay_payment_id' : response['razorpay_payment_id']},
            type : 'post',
            headers: {
            'Authorization': 'Bearer '+ token
            },
            success : function(result) {                                
                if(result.msg == 'success') {
                    location.reload();
                } else if(result.msg == 'fail'){
                    alert(result.error_msg);
                } else{
                    location.reload();
                }
            }
        });
    }
    </script>        