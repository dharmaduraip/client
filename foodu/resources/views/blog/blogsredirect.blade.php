
<section class="parallax-window" data-parallax="scroll" data-image-src="img/bg_blog.jpg" data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-1">
        <div class="animated fadeInDown">

        </div>
        @foreach($blog as $blog_g)

        <div class="blcko"  >
<?php $blog_image = explode(',',$blog_g->image);?>

           <img src="{!! URL::to('uploads/blogs/'.$blog_image[0]) !!}" style="width:100%;height:550px;object-fit:cover;">

           <div class="layout text-center">

            <h2 class="uppercase_mb12">{!! $blog_g->title !!}</h2>
        </div>

    </span>

</div> 

</div>

</div>

<br>



@endforeach

</section><!-- End section -->


<div class="container margin_60">

    <div class="row">



       <div class="col-md-12 no-pad">

        <div class="box_style_1">

            <div class="post nopadding">


                <div class="post_info clearfix">

                    <div class="post-left">

                        <ul>
                            <li><i class="icon-calendar-empty"></i>{!!trans('core.abs_on')!!} <span><?php
                                $indiatimezone = new DateTimeZone("Asia/Kolkata" );

                                $date = new DateTime();

                                $date->setTimezone($indiatimezone);

                                echo  $date->format( 'M,d, Y /h:i:s A ' );

                                ?></span></li>
                            </ul>

                        </div>
                       {{--<div class="post-right"><i class="icon-comment"></i><a href="#">  {!!$blog_comment->blog_count!!}  </a>{!!trans('core.abs_comments')!!}</div>--}}


                    </div>

                    @foreach($blog as $blog_g)

                    <h2 class="titles">{!! $blog_g->title !!}</h2>



                    <div class="post-left">

                        <p>

                            <ul class="Lab_top">

                                <div class="post nopadding">

                                    {!! $blog_g->content !!}

                                    <small>{!! $blog_g->description !!}</small>
                                    <h4>{!!trans('core.abs_comments')!!}</h4>
                                    <div id="comments">

                                        <div class="comment_right clearfix">

                                            @foreach($blogs as $comment_c)

                                            <p>

                                                {{-- {!! $comment_c->message !!} --}}

                                            </p>                        

                                            <div  class="space">Posted by 

                                                {{-- <a>{!! $comment_c->name !!}</a><span>|</span> --}}

                                                 {{-- {!! $comment_c->date !!}<span>|</span> --}}

                                              

                                                

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </ul>

                        </p>

                    </div>



                    
            <div class="col-xs-12 no-pad">          
                <div class="container">

                </div>
            </div>
            @endforeach
        </div></div>

    </div>









</li> 


{{--<div class="col-xs-12">          
 <div class="container" style="border-top: 1px dashed #bbb;">

    <h4>{!!trans('core.abs_Leave_a_comment')!!}</h4>

    <form  id="something"  class="ui large form" >



    <div class="form-group">

        <input class="form-control style_2" id="name1" type="text" name="name" placeholder="Enter name" required>

    </div>

    <div class="form-group">

        <input type="email" class="form-control style_2" id="email1"  name="email" placeholder="Enter email" required>

    </div>

    <div class="">

        <input class="form-control style_2" id="ids1" type="hidden" value="{!!$blog_id!!}" name="id" placeholder="Enter id">

    </div> 

    <div class="">

        <input class="form-control style_2" id="date1" type="hidden" value="{!!$date_time!!}" name="id" placeholder="Enter id">

    </div> 

    <div class="">

        <input class="form-control style_2" id="reply1" type="hidden" value="" name="reply" placeholder="Enter id">

    </div> 

    <div class="form-group">

        <textarea name="message"  type="text" id="message1" class="form-control style_2" style="height:150px;" placeholder="Message" required></textarea>

    </div>

    <div class="form-group">

        <input type="reset" class="newVerificationreset btn btn-danger" value="Clear form">

        <input type="submit"  class="btn btn-success" id="something" value="Post Comment">

    </div>

    </form>       

</div>--}}
</div>
</div>









</div>

</div>











<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<script type="text/javascript">

    $(document).on('submit','#something', function () {
        $.ajax({

            type: "POST",

            url: base_url+'blog/comment',

            data: {

                selectedName:$('#name1').val(),

                selectedEmail:$('#email1').val(),

                selectedMessage:$('#message1').val(),

                selectedId:$('#ids1').val(),

                selectedDate:$('#date1').val(),

            },

            success: function(data) {

                window.location.reload(true);

            }

        });
        return false;
    });

</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script>

    $('.quicklinks-button').click(function(){

        $('.quick-links-container').toggle();

    });

</script>

<script type="text/javascript">

    $(function () {



        $('.toggle').click(function (event) {

            event.preventDefault();

            var target = $(this).attr('href');

            $(target).toggleClass('hidden show');

        });



    });

</script>

<script type="text/javascript">



</script>

<script>

 /*   $('#something').click(function() {

        location.reload();

    });*/

</script>



</div></div></div></div>

<div class="post_info clearfix bdr_none">

    <div class="post-left">



    </div>

    <div class="post-right"></div>

</div>

<!--                     <h2>{!! $blog_g->title !!}</h2>

-->                   

<!-- <blockquote class="styled">

{!! $blog_g->content !!}

<small>{!! $blog_g->description !!}</small>

</blockquote> -->

</div><!-- end post -->

</div><!-- end box_style_1 -->

@endforeach

<!--                 <h4>comments</h4>

-->                

