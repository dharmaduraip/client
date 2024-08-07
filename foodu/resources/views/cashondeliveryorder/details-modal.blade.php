
<style type="text/css">
	.btn-close{background-color:}
	.ord-his{
		margin-bottom: 20px;
	}
	.detail-user p{
		margin-bottom: 5px;
		margin-top: 10px;
	}
	.detail-user{
		border: 1px solid #ccc;
		line-height: 20px
	}
	.address-section{margin-right: 12px;}
	.address-section .datetime{margin-top: 5px;}
	.address-section .label-success{padding: 5px 7px;font-size: 13px;margin-bottom: 12px;}
	.boy-detail{ line-height: 3px;margin-left: 10px;margin-bottom: 20px;}
	.btn-default.btn-close{background-color:#ed5565;font-weight:bold;}
	.side-title{font-weight:bold;color: #212121;}
	.mod-tittle{font-weight:normal;}
	.tooltip-box {
		position: relative;
		display: block;
		cursor: pointer;
	}

	.tooltip-box .tooltipcontent {
		visibility: hidden;
		background-color: #172028;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px 10px;
		position: absolute;
		z-index: 1;
		bottom: 130%;
		left: 6%;
		margin-left: -60px;
		width: max-content;
		font-weight: 400;
		font-size: 14px;
	}

	.tooltip-box:hover .tooltipcontent {
		visibility: visible;
	}
</style>

<style type="text/css">
	.addgst tr td{
		border: 1px solid #ddd;
		padding: 5px;
		width: 15%;
		white-space: nowrap;
	}

	.addgst1 td {
		padding: 5px;
		border:1px solid #ddd;
		white-space: nowrap;
	}
	.addgst1{
		width: 74%;
		float: right;
	}
	.addgst{
		float: right;
	}
</style>



	<div class="modal-body">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	 	 <p><b></b> </p>    
			<p></p>
		</div>
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>
						<div class="form-check">
							<input type="checkbox"  class="checkall" id="checkall" >
						</div></th>
					<th>S.No</th>
					<th>Product Item</th>
					<th>Adon Detail</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
				</tr>	
			</thead>
			<tbody>
			
				
			
			</tbody>
		</table>
		<p><b>Notes : </b> </p>
		<p><b>Delivery Preference : </b> </p>
		<table class="table table-bordered table-striped table-hover col-md-offset-3 " style="width:500px;">
			<thead>
				<tr>
					<th colspan="2">Order Detail Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Total Item Count</td>
					<td></td>
				</tr>
				<tr>
					<td>Item Checked Count</td>
					<td id="item_checked">0</td>
				</tr>
				<tr>
					<td>Total Price</td>
					<td></td>
				</tr>
				<tr>
					<td>Item Checked Price</td>
					<td> <span id="checked_price">0</span></td>
				</tr>
			{{-- <tr>
				<td>Amount To Refund (Customer wallet)</td>
				<td> <span id="refund_price"></span></td>
			</tr> --}}
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-success fn_accept arcls" data-oid="" data-partner="" data-selected="" style="display:none;" id="show_accept">Accept</button>
	<button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
</div>

