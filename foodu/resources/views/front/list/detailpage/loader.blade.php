<div class="procontinrpad borderbotm container-fluid" id="category_8">
	<div class="newvl placeholder-wave"><span class="placeholder col-6  bg-secondary"></span></div>
	<div class="row d-flex flex-wrap">
		@for ($i=0; $i < 3 ; $i++)
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 p-0 mb-2">
			<div class="boxadd m-0 h-100">
				<div class="baddc placeholder-wave">
					<span class="placeholder col-2 placeholder-sm"></span>
					<span class="placeholder col-6 placeholder-sm"></span>
				</div>
				<img src="{!! \URL::to('uploads/images/no-image.jpg') !!}" class="" width="90" height="94">
				<div class="align-items-center justify-content-between placeholder-glow">
					<span class="placeholder col-2 placeholder-xs"></span>
					<div class=" items_count_box">
						<a href="javascript::void(0)" class="btn btn-secondary disabled placeholder w-100 h-100"></a>
					</div>
				</div>
			</div>
		</div>
		@endfor
	</div>
</div>