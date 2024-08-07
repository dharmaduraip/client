<div class="smallHeading">{!! Lang::get("core.abs_offer_wallet") !!}</div>
 <div class="table-responsive" style="min-height:300px;">
    <table class="table table-striped ">
        <thead>
			<tr>
				<th class="number"> No </th>
				<th>Order Id</th>
				<th>Offer Name</th>
				<th>Offer Price</th>
				<th>Grand Total</th>
				<th>Date</th>
			  </tr>
        </thead>


        <tbody>  
        <?php $p = 0; ?>					
            @foreach ($offerwallet as $i => $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>						
					<td>{{ $row->order_id }}</td>
					<td>{{ $row->offer_name }}</td>
					<td>{{ \AbserveHelpers::CurrencySymbol( number_format($row->offer_price,2,'.','')) }} <?php if($row->type=="credit"){ echo "(<span style='color:green;'>+</span>)"; } else { echo "(<span style='color:red;'> - </span>)";} ?></td>
					<td>{{ \AbserveHelpers::CurrencySymbol( number_format($row->grand_total,2,'.','')) }}</td>
					<td>{{ date_format($row->created_at,'d-m-Y') }}</td> 
                </tr>
				<?php $p++; ?>
            @endforeach  
            <tr style="color:red;"><td colspan="2" >Offer Wallet Balance: </td><td colspan="4">{{ \AbserveHelpers::CurrencySymbol( number_format(\Auth::user()->offer_wallet,2,'.','')) }}</td></tr>
        </tbody>
    </table>