              @if(\Request::segment(1) == 'manage_addresses')
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
                                          <input class="input_box" disabled id="location" name="location"  value="">
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
                                            <input class="hide" type="radio" name="address_type" id="address_type_1" required value="1" hidden>
                                            <label class="annotation" for="address_type_1"> 
                                              <i class="fa fa-home"></i>{!! Lang::get("core.home") !!}
                                              <span class="checkmark"></span>
                                            </label> 
                                            <input class="hide" type="radio" name="address_type" id="address_type_2" required value="2" hidden>
                                            <label class="annotation" for="address_type_2"> 
                                              <i class="fa fa-briefcase "></i>{!! Lang::get("core.work") !!}
                                              <span class="checkmark"></span>
                                            </label> 
                                            <input class="hide" type="radio" name="address_type" id="address_type_3" required value="3" hidden>
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
      var purl = "{{ URL::to('/')}}/updateaddress";
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