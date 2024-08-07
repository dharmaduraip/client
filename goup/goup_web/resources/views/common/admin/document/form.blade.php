{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Documents') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('admin.document.document_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="" autocomplete="off">
                    </div>
                </div>

                <div class="form-row">
                   <div class="form-group col-md-6">
                      <label><input type="radio" value = "image" name="file_type"> {{ __('admin.document.image') }}</label>
                      <label><input type="radio" value = "pdf" name="file_type"> {{ __('admin.document.pdf') }}</label>
                    </div>
                </div>
                <div class="form-row">
                   <div class="form-group col-md-12">
                       <!-- <label><input type="checkbox" id ="frontend_image" value ="1" name="frontend_image"> {{ __('admin.document.frontend') }}</label> -->
                        <!-- <div class="form-group col-md-6" id ="frontend_document">
                           <div class="imgUploadbx">
                                <div class="picture-container">
                                    <div class="picture productPic">
                                      <img src="#" class="input_img picture-src" title="" class="img-responsive" />
                                      <input type="file" name="frontend_image" id="front_image" onchange="readURL(this);" >
                                      <h6 class="addPoto">
                                        <img src="{{ asset('assets/layout/images/camera.svg')}}"> <br>Add Your image
                                      </h6>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                       <label><input type="checkbox" id ="is_backside" value ="1" name="is_backside"> {{ __('admin.document.backend') }}</label>
                       <!-- <div class="form-group col-md-6" id = "backend_document">
                           <div class="imgUploadbx">
                                <div class="picture-container">
                                    <div class="picture productPic">
                                      <img src="#" class="input_img picture-src" title="" class="img-responsive" style="display:none" />
                                      <input type="file" name="is_backside" onchange="readURL(this);" >
                                      <h6 class="addPoto">
                                        <img src="{{ asset('assets/layout/images/camera.svg')}}"> <br>Add Your image
                                      </h6>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
               
               {{-- @if(count(Helper::getServiceList())> 1)
                    <!-- <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="notify_type" class="col-xs-2 col-form-label">@lang('admin.service')    </label>
                            <select name="service" class="form-control"  id= "service">
                                <option value="">Select</option>
                                    @foreach(Helper::getServiceList() as $service)
                                        <option value={{$service}}>{{$service}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div> -->
                @else
                    <!-- <input type="hidden" name ="service" value="{{Helper::getServiceList()[key(Helper::getServiceList())]}}" /> -->
                @endif
                --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('admin.document.document_type') }}</label>
                        <select name="type" class="form-control" id= "document_type">
							<option value="">Select</option>
							    <option value="TRANSPORT" id = "driver">TRANSPORT</option>
                                <option value="ORDER" id = "shop">ORDER</option>
                                <option value="SERVICE" id = "fleet">SERVICE</option>
                                <option value="DELIVERY" id = "fleet">DELIVERY</option>
                                <option value="ALL" id = "fleet">ALL</option>
						</select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-accent frontend_image">{{$action_text}} {{ __('Document') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>
            </form>
        </div>
    </div>
</div>


@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{

     basicFunctions();
     var id = "";

     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/document"+id;
        setData( url );
     }


     $('#is_backside').on('click',function(){
        if($(this).is(':checked')){
            $(this).val(1);
        }else{
            $(this).val(0);
        }
     });



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true },
            type: { required: true },
            service: { required: true },
            file_type: { required: true },
		},

		messages: {
			name: { required: "Name is required." },
			type: { required: "Type is required." },
            service: { required: "Service is required." },
            file_type: { required: "File Type is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form) {

            var data = new FormData();

            var formGroup = $(".validateForm").serialize().split("&");

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            
            var url = getBaseUrl() + "/admin/document"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });
    $('#service').on('click', function(){
        var optionvalue = $(this).val();
        if(optionvalue == 'TAXI' ||  optionvalue == 'XUBER')
        {
            $('#driver,#vehicle,#fleet').show();
            $('#shop').hide();
        }else{
            $('#shop').show();
            $('#driver,#vehicle,#fleet').hide();
        }
    });

});
</script>
