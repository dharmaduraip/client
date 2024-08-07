@extends('common.web.layout.base')
@section('styles')

@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/owl-carousel/css/owl.carousel.min.css')}}"/>
<style>
.top-section {
    color: #2c2e30;
   padding-bottom: 100px;
   padding-top: 80px 

}
</style>
@stop
@section('content')
<section class="top-section dis-center">
 

   <div class="container">
   @foreach(Helper::getcmspage() as $k=>$v)
  @if($v->page_name == $type )
       {!!$v->content !!} 

  @endif
  @endforeach     
   
   </div>
</section>


@stop
@section('scripts')
@parent

<script>
   $(document).ready(function() {
   $('.menu').hide();
    });

</script>
@stop
