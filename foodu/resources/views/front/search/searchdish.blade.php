@extends('layouts.default.index')
@section('content')
<div class="searchbox" id="search_page" style="display:block;">
    <div class="container contar">
        <!-- <form class="search-form" method="get" action="{{ URL::to('/frontend/search')}}"> -->
            <div class="searchdiv">
                <i class="fas fa-search searchicon"></i>
                <input type="text" value="{{ app('request')->input('q') }}" id="dish_fn_keyword" class="searchinputbox" placeholder="Search For Shops or Products" name="keyword" autocomplete="off"  >
                <!-- <input type="hidden" value="@if(isset($address) && !empty($address)){{$address->lat}}@else{{ app('request')->input('lat') }}@endif" id="lat" name="lat"> -->
                <!-- <input type="hidden" value="@if(isset($address) && !empty($address)){{$address->lang}}@else{{ app('request')->input('lang') }}@endif" id="lang" name="lang"> -->
                <input type="button" name="search_btn" id="search_btn_head" value="Search"  class="hidden"/>
                <a class="searchclear">clear</a>
                {{-- <a class="searchclose tohome" onClick="window.history.back();">
                    <span class="close searchcloseicon"><i class="fa fa-times"></i></span>
                    <span class="esc"> ESC</span>
                </a> --}}
            </div>
        <!-- </form> -->
    </div>
    <div class="schimages">
        <div class="container contar">
            {{-- <div class="searchimg">
                <div role="button" aria-label="Scroll left" class="icon-back searchleftarrw hicls hidden"></div>
                <div class="overflw">
                    <div class="foodimage foodslider owl-carousel">
                                    <div class="item">
                                        <span class="fimg zoom" role="button" aria-label="Select pizza" title="{!! 'name' !!}">
                                            <img class="fimgwidth imageeffect clickimg" src="{{ asset('uploads/dishes/'.'image')}}" alt="pizza" title="{!! 'name' !!}">
                                        </span>
                                    </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="dish_result ">
        
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).on('keyup','.searchinputbox',function(){
        var text = $(this).val();
        if(text.length >= 3){
            $.ajax({
                url:base_url+'searchdishresult',
                type:'get',
                dataType:'json',
                data:{search:text},
                success:function(data){
                    $('.dish_result').html(data.html);
                }                
            })
        }
    });
    $(document).on('click','.searchclear',function(){
        $("#dish_fn_keyword").val('');
        $(".dish_result").html('');
    });
</script>
@endpush