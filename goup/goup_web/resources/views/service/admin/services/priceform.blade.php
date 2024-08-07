{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row full-section-ser">
    <div class="col-md-4 box-card border-rightme myprice">

    </div>
    <div class="col-md-8 box-card price_lists_sty priceBody">
        <form id="servicePriceFormId" >
            <div class="col-xs-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Daily</a>
                    </div>
                </nav>
                <div class="tab-content pricing-nav nav-wrapper" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">

                    <!-- Pricing for Country -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <input type="hidden" id="countryId" value=""name="country_id">
                        <input type="hidden" id="cityId" value="" name="city_id">
                        <input type="hidden" id="serviceId" value="" name="service_id">
                        <input type="hidden" id="service_price_id" value="" name="service_price_id">
                                        
                            <label for="feFirstName"> {{ __('Pricing Logic') }}</label>
                            <select class="form-control" name="fare_type" id="calculator">
                                <option value="FIXED" >FIXED</option>
                                <option value="HOURLY" >HOURLY</option>
                                <option value="DISTANCETIME" >DISTANCE TIME</option>
                            </select>
                            <span class="txt_clr_4"><i id="changecal">{{ __('Price Calculation: BP + (TM*PM)') }}</i></span>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fixed">Base Price (<span class="currency">$</span>0.00)</label>
                            <input class="form-control" type="number" value="" name="base_fare" id="fixed" placeholder="Base Price" min="0">
                        <span class="txt_clr_4"><i>BP (Base Price)</i></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="per_mins"> {{ __('Unit Time Pricing ') }}(<span class="currency">$</span>0.00)</label>
                            <input class="form-control" type="number" value="" name="per_mins" id="minute" placeholder="Per min pricing" min="0">
                            <span class="txt_clr_4"><i> {{ __('PM (Per Minute), TM(Total Minutes)') }}</i></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="base_distance"> {{ __('Base Distance (0 Kms)') }}</label>
                            <input class="form-control" type="number" value="" name="base_distance" id="distance" placeholder="Base Distance" min="0">
                            <span class="txt_clr_4"><i>  {{ __('BD (Base Distance)') }}</i></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="per_miles"> {{ __('Unit Distance Pricing (0 Kms)') }}</label>
                            <input class="form-control" type="number" value="" name="per_miles" id="price" placeholder="Unit Distance Price" min="0">
                            <span class="txt_clr_4"><i>  {{ __('PKms (Per Kms), TKms (Total Kms)') }}</i></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="commission"> {{ __('Commission(%)') }}</label>
                            <input class="form-control" type="number" value="" name="commission" id="commission" placeholder="Admin Commission for service" min="0">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fleetcommission"> {{ __('Fleet Commission(%)') }}</label>
                            <input class="form-control" type="number" value="" name="fleet_commission" id="fleetCommission" placeholder="Fleet Commission for service" min="0">
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tax">Tax(%)</label>
                            <input class="form-control" type="number" value="" name="tax" id="tax" placeholder="Tax for service" min="0">
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6 allowdiv">
                            <label for="customToggle2"> {{ __('Allow Quantity') }}</label>
                            <div class="custom-control custom-toggle">
                                <input type="checkbox" id="allowQty" name="allow_quantity" class="custom-control-input" value ='0'>
                                <label class="custom-control-label" for="allowQty"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 allowdiv">
                            <label for="commission"> {{ __('Max Quantity') }}</label>
                            <input class="form-control" id="maxQty" name="max_quantity" type="number" value="" placeholder="Max Quantity" min="0">
                        </div>      
                        <div class="form-group col-md-12">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <a href="#" class="btn btn-danger  addService col-md-3 mb-2"> {{ __('Submit') }}</a>
                                        <button type="button" class=" btn btn-danger col-md-3 mb-2" data-dismiss="modal">{{ __('Close') }}</button>
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
<style>
   #service_type_service .select_city, .select_country {
    height: 473px;
    overflow-x: auto;
    background: #FFF;
    padding: 0px;
    margin-top: 20px;
} 
</style>