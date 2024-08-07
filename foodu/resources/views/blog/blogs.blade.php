    <section class="about-us">
    	<div class="banner-sec outer-bg">
    		<div class="container main-content-area no_pad">
    			<div class="main-content-inner col-xs-12 col-md-12">
                    
    				{{-- <div id="myCarousel" class="carousel slide" data-ride="carousel">
    					<div class="carousel-inner blog-sec">
    						<div class="item active"><img style="width: 100%;height:450px;object-fit:cover;" src="{!! URL::to(CNF_THEME.'/images/blog1.jpg') !!}" alt="slider1" /></div>
    						<div class="item"><img style="width: 100%;height:450px;object-fit:cover;" src="{!! URL::to(CNF_THEME.'/images/blog2.jpg') !!}" alt="slider2" /></div>
    						<div class="item"><img style="width: 100%;height:450px;object-fit:cover;" src="{!! URL::to(CNF_THEME.'/images/blog3.png') !!}" alt="slider3" /></div>
    						<!-- <div class="item"><img style="width: 100%;" src="{!! URL::to('abserve/images/blog4.jpg') !!}" alt="slider3" /></div> -->
    					</div>
    					<!-- Left and right controls --> <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="sr-only">Next</span> </a></div>
    				</div> --}}

    				<div class="row m-0">
    					@if(count($blog) > 0)
    					@foreach($blog as $blog_g)
    					<?php $bimage = explode(',', $blog_g->image); ?>
        					<section class="blog-sec col-xl-3 col-lg-4 col-md-6">
        						<article>
        							<div class="blog-item-wrap">
                                        <a href="{!!URL::to('/blogredirect/'.$blog_g->id)!!}" >
                                            <img src="@if($bimage[0]){!! asset('uploads/blogs/'.$bimage[0])!!}@else{!!url('uploads/images/1300x900.png')!!}@endif" style="" class="img-responsive">
                                        </a>
                                    </div>
        							<div class="post-inner-content">
                                        <header class="entry-header">
                                            <h2 class="entry-title">
                                                <a rel="bookmark">{!!$blog_g->title!!}</a>
                                            </h2>
        								    <div class="entry-meta">
                                                <span class="posted-on"> 
                                                    <a rel="bookmark">
                                                        <time class="entry-date published" datetime="2018-07-13T12:02:42+00:00">{!!$blog_g->created!!}</time>
                                                    </a>
                                                </span>
                                                <span class="byline"> 
                                                    <span class="author vcard"></span>
                                                </span>
                                            </div>
        								<!-- .entry-meta -->
                                        </header>
                                        <!-- .entry-header -->
        								<div class="entry-content">
        									<p>{!! $blog_g->description !!}</p>

        									<a class="btn btn-default read-more btn_1" data-bs-toggle="modal" data-bs-target="#exampleModal">Read More</a>
                                            {{-- <a class="btn btn-default read-more"  href="{!!URL::to('/blogredirect/'.$blog_g->id)!!}" class="btn_1" >Read More</a> --}}
                                        </div>
    								<!-- .entry-content -->
                                    </div>
    							</article>
    						</section>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>


    {{-- Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="d-flex justify-content-end align-items-center pt-2 px-2">
                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="article-image">
                            <img class="mb-3" src="{{ asset('sximo5/images/themes/images/Coming-soon.jpg') }}">
                            <h4 class="m-0">Lorem ipsum</h4>
                            <span>01 AUG 2030</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="article-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    {{-- Modal --}}











