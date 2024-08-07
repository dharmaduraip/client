<div class="alert alert-danger displaymsg2" style="display: none;">
  <strong>Failed!</strong> Old Password and New Password must not be same.
</div>
<div class="col-md-8 account_details col-sm-8 col-xs-12 nopadding">
    <div class="smallHeading mainthemeGray">{!! Lang::get("core.changepassword") !!}</div>
    <div class="editProfile change_pwd"> 
        <form id="change_pass" method="post" action="{{ URL::to('users/changepassword')}}">
            <dl class="profileField bdr_none">
                <dt class="mainthemeGray col-xs-12 nopadding nowidth">{!! Lang::get("core.currentpassword") !!}</dt>
                <dd class="col-xs-12 nopadding nomargin">
                    <span class="fieldValue fn_email1" >
                        <input class="form-control old_password curpass" name="old_password" id="password" type="password" required="">
                    </span>
                </dd>
            </dl>
            <dl class="profileField">
                <dt class="mainthemeGray col-xs-12 nopadding nowidth">{!! Lang::get("core.newpassword") !!}</dt>
                <dd class="col-xs-12 nopadding nomargin">
                    <span class="fieldValue fn_email1" >
                        <input class="form-control new_password newpass" name="password" id="password_confirmation" type="password" required="">
                    </span>
                </dd>
            </dl>
            <dl class="profileField">
                <dt class="mainthemeGray col-xs-12 nopadding nowidth">{!! Lang::get("core.conewpassword") !!}</dt>
                <dd class="col-xs-12 nopadding nomargin">
                    <span class="fieldValue fn_email1" >
                        <input class="form-control old_password newpass1"  name="password_confirmation" type="password" id="password" required=""/>
                    </span>
                </dd>
            </dl>
            <?php 
                  $seg='foodstar';
                  $seg1='products';
                  $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                  $uri_segments = explode('/', $uri_path);
                  ?>
             @if($seg == $uri_segments[2] and $seg1==$uri_segments[1])
            @if(Auth::user()->email=="customer@abservetech.com")
           <font color="red">  you can't edit password. Kindly register one account</font>
            <div></div>
            @else
            <div class="password_action">
                <input class="btn btn-primary but_sucss pull-left checkpass" type="submit" value="{!! Lang::get('core.changepassword') !!}">
            </div>
            @endif
              @else
            <div class="password_action">
                <input class="btn btn-primary but_sucss pull-left checkpass" type="submit" value="{!! Lang::get('core.changepassword') !!}">
            </div>
            @endif
        </form>
    </div>
</div>    
<script type="text/javascript">
    $(document).on('click','.checkpass',function(){
        if($('.curpass').val() == $('.newpass').val()){
            $('.displaymsg2').css('display','block');
            setTimeout(function(){ $('.displaymsg2').css('display','none'); }, 5000);
            return false;
        }
    });
</script>