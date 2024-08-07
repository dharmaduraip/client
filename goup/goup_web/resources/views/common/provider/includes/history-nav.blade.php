

<div class="sidebar clearfix m-b-20">
   <div class="main-block">
      <div class="sidebar-title white-txt">
         <h6>@lang('provider.history')</h6>
         <i class="fa fa-history pull-right"></i> 
      </div>
      <form>
         <ul>
           @foreach(Helper::getServiceList() as $k=>$v)
            <li>
               <span class="radio-box"><input type="radio" value='{{$k}}'  name="filter" id="{{$v}}"><label for="{{$v}}">{{$v}}</label></span>
            </li>
            @endforeach
         </ul>
      </form>
      <div class="clearfix"></div>
   </div>
</div>