<div class="leftorangemnu">
	@for($i=0; $i < 15 ; $i++)
	<a class="cart_menulink" href="#category">
		<div class="leftmenudiv placeholder-wave"><span class="placeholder col-{!! ($i%2 == 0) ? (($i>10) ? ($i-2) : 3 ) : 4 !!}"></span></div>
	</a>
	@endfor
</div>