<div id="myModalphoneverified" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mobile Number Verification</h4>
            </div>
            <div class="modal-body">
                <input type="text" name="mobile_numberV" id="mobile_numberV" placeholder="Enter your Mobile number" class="form-control" @if(\Auth::check() && \AbserveHelpers::verifiedPhonenum(\Auth::user()->id) != 0) value="{!! \AbserveHelpers::verifiedPhonenum(\Auth::user()->id) !!}" @endif>
                <input type="text" style="display: none;" name="otpV" id="otpV" class="form-control" placeholder="Enter OTP">
                <div><span style="display: none;cursor: pointer;" class="resend_otp" id="send_otp" data-id="@if(\Auth::check()){!! \Auth::user()->id !!}@endif">Resend otp</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="send_otp"  data-id="@if(\Auth::check()){!! \Auth::user()->id !!}@endif" class="btn btn-success send_otp">Send OTP</button>
                <button type="button" style="display: none;" id="verify_OTP" data-id="@if(\Auth::check()){!! \Auth::user()->id !!}@endif" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{-- <div id="megaoffers" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <iframe src="{!! URL('/').'/mega-offer?appview=1' !!}"></iframe>
            </div>
        </div>
    </div>
</div> --}}
@if(\Request::segment(2) == 'manage_addresses')
<div id="map_modal" class="  left-menu">
    <div class="closebtn">
        <i class="closefilter closeicon2"></i><span>Save delivery address</span>
    </div>    
    <form role="form" action="" method="post" id="address_form">
        <div class="">
            <div class="step1">
                <div id="myaddrMap"></div><br/>
            </div>
            <div class="step2">
                <div class="no-pad" ng-show="vm.newAddressStep == '2'">
                    <div class="col-xs-12 no_pad">
                        <div class="address_values">
                            <div class="input_group active" >
                                <input class="input_box" disabled id="location" name="location"  value="{!! $restaurant->location !!}">
                                <label class="floating-label" id="log_email" for="mobile">{!! Lang::get("core.address_details") !!}123</label>
                            </div>
                            <div class="alert_fn"></div>
                        </div>
                        <div class="save_more_add">
                            <div class="input_group">
                                <input class="input_box" name="building" required value="" id="building" >
                                <label class="floating-label">{!! Lang::get("core.build_flat") !!}</label>
                            </div>
                            <div class="input_group" >
                                <input class="input_box" name="landmark" id="landmark" >
                                <label class="floating-label">{!! Lang::get("core.add_landmark") !!}</label> 
                            </div>
                            <div class="group save_adrs" >
                                <input class="hide" type="radio" name="address_type" id="address_type_1" required value="1">
                                <label class="annotation" for="address_type_1"> 
                                    <i class="fa fa-home"></i>{!! Lang::get("core.home") !!}
                                    <span class="checkmark"></span>
                                </label> 
                                <input class="hide" type="radio" name="address_type" id="address_type_2" required value="2">
                                <label class="annotation" for="address_type_2"> 
                                    <i class="fa fa-briefcase "></i>{!! Lang::get("core.work") !!}
                                    <span class="checkmark"></span>
                                </label> 
                                <input class="hide" type="radio" name="address_type" id="address_type_3" required value="3">
                                <label class="annotation" for="address_type_3">
                                    <i class="fa fa-book"></i>{!! Lang::get("core.others") !!}
                                    <span class="checkmark"></span>
                                </label>
                            </div>             
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="a_lat" id="a_lat" value="">
            <input type="hidden" name="a_lang" id="a_lang" value="">
            <input type="hidden" name="a_addr" id="a_addr" value="">
        </div>
        <button type="submit" class="save_address go_to_step">{!! Lang::get("core.save_address") !!}</button>
    </form>
</div>
<script type="text/javascript">
    $("#address_form").validate({
        // Rules for form validation
        rules:
        {
            building:
            {
                required: true,

            },
            landmark:
            {
                required: true,

            },
            address_type:
            {
                required: true,

            }
        },

        // Messages for form validation
        messages:
        {
            building:
            {
                required: '{!! Lang::get("core.enter_building") !!}',
            },
            landmark:
            {
                required: '{!! Lang::get("core.enter_landmark") !!}'
            },
            address_type:
            {
                required: '{!! Lang::get("core.enter_address") !!}'
            }
        },                  
        submitHandler: function(form) {
            var purl = "{{ URL::to('/')}}/frontend/updateaddress";
            var id = $('#address_form').find("#id").val();
            $.ajax({
                url: purl,
                type: 'post',
                data:  $('#address_form').serialize(),
                success: function(data) {
                    if(data != ''){

                        /*$("#map_modal").modal("hide");*/
                        $("#map_modal").removeClass("left-active");
                        $('.overlay').hide();
                        if(id!= '')
                        {
                            $(".fn_"+id).html(data);
                        }else
                        {
                            $('.user_address').append('<div class="col-md-6 col-sm-6 col-xs-12 fn_25">'+data+'</div>');
                        }
                    }

                }            
            });
        },
        // Do not change code below
        errorPlacement: function(error, element)
        {
            error.insertAfter(element.parent());
        }         
    });
</script>
@endif
<div class="popup_div" >
    <div id="multiple_cust_div"></div>
</div>