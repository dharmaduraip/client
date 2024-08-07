{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<link rel="stylesheet" href="{{ asset('assets/layout/css/service-master.css')}}">
<div class="row p-2">
    <div class="col-md-4 box-card border-rightme myprice">

    </div>
    <div class="col-md-8 box-card price_lists_sty priceBody">
        <form class="validateForm" >
            <div class="col-xs-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">{{ __('Daily') }}</a>
                    </div>
                </nav>
                <div class="tab-content pricing-nav nav-wrapper" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">

                    <!-- Pricing for Country -->
                     <div class="form-group col-md-12"></div>
                    <div class="form-row">

                        <div class="form-group col-md-6">


                            <input type="hidden" id="countryId" value=""name="country_id">
                            <input type="hidden" id="cityId" value="" name="city_id">
                            <input type="hidden" id="store_type_id" value="" name="store_type_id">
                            <input type="hidden" id="id" value="" name="id">

                            <label for="feFirstName">Base Price</label>
                            <input class="form-control   price" type="text" value="" name="delivery_charge" id="delivery_charge" placeholder="Delivery Charges" min="0">
                        </div>
                        <div class="form-group col-md-6"></div>

                        <div class="form-group col-md-6">
                            <label for="feFirstName">Base Distance</label>
                            <input class="form-control numbers" type="text" value="" name="base_distance" id="base_distance" placeholder="Base Distance" min="0" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="feFirstName">Unit Distance Pricing</label>
                            <input class="form-control price" type="text" value="" name="distance_price" id="distance_price" placeholder="Unit Distance Price" min="0" required="">
                        </div>



                    </div>
                    <div class="form-group">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                    <button type="submit" class="btn btn-success ">{{ __('Submit') }}</button>
                                    <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>   
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>
    basicFunctions();
    var id={{$id}};
  $.ajax({
        url: getBaseUrl() + "/admin/store/get-store-price",
        type: "GET",
        async : false,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success: function(data) {
            var countryCityList ='';
            $.each( data.responseData,function(key,value){
                countryCityList += `<label class="country_list_style">`+value.country.country_name+`<span class="pull-right"><i class="fa fa-globe" aria-hidden="true"></i></span></label>`;
                $.each( value.company_country_cities,function(key1,value1){
                    if(key == 0 && key1 ==0){
                        var cityActiveClass ="active";
                        $("#countryId").val(value.country.id);
                        $("#cityId").val(value1.city.id);
                        $("#store_type_id").val(id);
                         getData(id,value1.city.id,value.country.id);
                    }else{
                        var cityActiveClass ='';
                    }
                    if (value1.city != null) {
                        countryCityList +=  `<a href="#" class="list-group-item cityActiveClass  `+cityActiveClass+`" onclick="getData(`+id+`,`+value1.city.id+`,`+value.country.id+`)" id="`+value1.city.id+`"><span>`+value1.city.city_name+`</span></a>`;
                    }
                });
            });
            $('.myprice').empty().append(`<div class="form-group">
                    <div class="select_city nav-wrapper"><div class="list-group">
                        `+countryCityList+`
                    </div>
                    </div>
                </div>
            `);
        }
    });

function getData(storeId,cityId,countryId){
 $('#delivery_charge,#tax,#id').val('');   
$('.cityActiveClass').removeClass("active");
$('#'+cityId).addClass(" active");
var url = getBaseUrl() + "/admin/store/pricing/"+storeId+"/"+cityId
$("#cityId").val(cityId);
$("#countryId").val(countryId);
$("#store_type_id").val(storeId);
setData( url ); 
}

$('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            delivery_charge: { required: true },
            tax: { required: true },
        },

		messages: {
			// vehicle_type: { required: "Vehicle Type is required." },
			delivery_charge: { required: "Delivery charge  is required." },
            tax: { required: "Tax is required." },
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

            var formGroup = $(".validateForm").serialize().split("&");

            var data = new FormData();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
             var url = getBaseUrl() + "/admin/store/pricings";
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });




</script>