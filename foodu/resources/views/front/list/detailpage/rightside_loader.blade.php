{{-- for empty cart --}}

{{-- <div class="righttittle placeholder-glow"><span class="placeholder col-8"></span></div>
<img src="{!! \URL::to('uploads/images/no-image.jpg') !!}" class="rghtimg img-responsive m-0">
<div class="text_add placeholder-glow">
	<span class="placeholder col-12"></span>
	<span class="placeholder col-12"></span>
	<span class="placeholder col-8"></span>
</div> --}} 


{{-- for add cart --}}

<div class="menu-cart-title">
	<div class="rphidetitle placeholder-glow"><span class="placeholder col-5"></span></div>
	<div class="rphitem placeholder-glow"><span class="placeholder col-2"></span></div>
</div>

<div class="menu-cart-body">
	<input type="hidden" value="2" id="quan">
	<input type="hidden" value="11" id="countitem">
	<input type="hidden" value="2" id="res_id_cart"> 
	<div class="menu-cart-items" id="item_139429_0">
		<div class="item_naem" style="margin-right:20px">
			<p class="veg-item placeholder-wave">
				<span class="placeholder bg-secondary col-12"></span>
				<span class="placeholder bg-secondary col-6"></span>
				<span class="placeholder bg-secondary col-10"></span>
			</p>
		</div>
		<div class="block-item text-center no-pad items_count" id="fnitem_139429_0" style="margin-right:20px">
			<span class="remove_cart_item count_in_dec placeholder disabled" data-isad="" data-faid="139429" data-type="">
				<i data-faid="139429" data-aid="0" data-type="" class="fa fa-minus placeholder" aria-hidden="true" style="cursor:pointer;"></i>
			</span>
			<span id="afid_139429_0" class="item-count placeholder"></span>
			<span class="add_cart_item count_in_dec placeholder disabled" data-faid="139429" data-aid="0" data-type="" data-isad="">
				<i data-faid="139429" id="fitem_139429" class="fa fa-plus placeholder" aria-hidden="true" style="cursor:pointer;"></i>
			</span>
		</div>
		<div class="d-flex flex-column">
			<div class="block-item text-right placeholder-glow">
				<span style="color: red;" class="placeholder col-8"></span>
			</div>
			<div class="block-item text-right placeholder-glow">
				<span class="placeholder col-8"></span>
			</div>
		</div>
	</div> 
	<div class="menu-cart-items" id="item_139427_0">
		<div class="item_naem" style="margin-right:20px">
			<p class="veg-item placeholder-wave">
				<span class="placeholder bg-secondary col-6"></span>
				<span class="placeholder bg-secondary col-12"></span>
				<span class="placeholder bg-secondary col-12"></span>
			</p>
		</div>
		<div class="block-item text-center no-pad items_count" id="fnitem_139429_0" style="margin-right:20px">
			<span class="remove_cart_item count_in_dec placeholder disabled" data-isad="" data-faid="139429" data-type="">
				<i data-faid="139429" data-aid="0" data-type="" class="fa fa-minus placeholder" aria-hidden="true" style="cursor:pointer;"></i>
			</span>
			<span id="afid_139429_0" class="item-count placeholder"></span>
			<span class="add_cart_item count_in_dec placeholder disabled" data-faid="139429" data-aid="0" data-type="" data-isad="">
				<i data-faid="139429" id="fitem_139429" class="fa fa-plus placeholder" aria-hidden="true" style="cursor:pointer;"></i>
			</span>
		</div>
		<div class="d-flex flex-column">
			<div class="block-item text-right placeholder-glow">
				<span style="color: red;" class="placeholder col-8"></span>
			</div>
			<div class="block-item text-right placeholder-glow">
				<span class="placeholder col-8"></span>
			</div>
		</div>
	</div>
</div>

<div class="menu-cart-footer">
	<div class="final-total">
		<h5 class="placeholder-glow d-flex justify-content-between">
			<span class="sub_total placeholder col-4"></span>
			<span class="pull-right placeholder col-2">
				<span class="grand_total"></span>
			</span>
		</h5>
		<div class="extra_charge placeholder-glow">
			<span class="placeholder placeholder-sm col-12"></span>
		</div>
	</div>
	<button class="btn login_checkout disabled placeholder col-12" id="btn-checkout">
	</button>
</div>