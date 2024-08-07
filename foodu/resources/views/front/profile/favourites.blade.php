<style>
.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 20px 0;
    border-radius: 4px;
    float: right;
}
</style>    
<div class="tab-content">
    <div id="home" class="tab-pane fade in active topcolor">
        <div class="smallHeading">Favourites</div>
        <div class="boxcontent row d-flex flex-wrap">
            @php 
            $iNc = '0'; $sNc = '1';
            @endphp

            @if(count($res_restaurnts) > 0)
            @foreach($res_restaurnts as $key=>$rest)
            @php 
            $rating = \AbserveHelpers::getOverallRating($rest->id);
            @endphp
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mar-bottm  columpad">
                <div class="box">
                    <div class="align"> 
                        <a class="item-list" href="{{ URL::to('details/'.$rest->getRestuarantItems[0]->restaurant_id) }}" >
                        <div class="food_img" style="background-image: url('{{$rest->logo}}');" ></div>
                        </a>
                        <div class="icon_heart">
                            <span><i class="fa fa-heart" aria-hidden="true"></i></span>
                        </div>
                    </div>

                    <a class="item-list" href="{{ URL::to('details/'.$rest->getRestuarantItems[0]->restaurant_id) }}">
                    <h3>{{$rest->name}}</h3>
                    </a>
                    <p>{{$rest->cuisine_text}}</p>
                    <div class="botm-box">
                        <div class="starbck">
                            <span><i class="fa fa-star star"></i></span>
                            <span class="four">{{round($rating)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @endforeach
            @else
            <div class="item-list">
                <div class="col-sm-12 no-padding text-center no-address">
                    <img src="{{ url('sximo5/images/themes/images/fav_dish.png') }}" height="200">
                    <h3>Where is the love?</h3>
                    <h4>{!! Lang::get('core.no_restaurnts') !!}</h4>
                </div>
            </div>
            @endif
        </div>
            {!! $res_restaurnts->links() !!}
    </div>
</div>