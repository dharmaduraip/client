{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<link rel="stylesheet" href="{{ asset('assets/layout/css/service-master.css')}}">
<div class="row p-2">
    <div class="col-md-4 box-card border-rightme myprice">

    </div>
    <div class="col-md-8 box-card price_lists_sty priceBody">
        



        <form id="formId" >
            <div class="col-xs-12">
                <!-- Navbar tab -->
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Daily</a>
                    </div>
                </nav>
                <!-- End Navbar tab -->
                <div class="tab-content pricing-nav nav-wrapper" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="nav-daily-tab">
                    <input type="hidden" id="countryId" value="" name="country_id">
                    <input type="hidden" id="cityId" value="" name="city_id">
                    <input type="hidden" id="vehicleId" value="" name="ride_delivery_vehicle_id">
                    <input type="hidden" id="ride_price_id" value="" name="ride_price_id">

                    <!-- Pricing for Country -->
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                    
                                        <label for="feFirstName">Pricing Logic</label>
                                        <select class="form-control" name="calculator" id="calculator">
                                            <option value="DISTANCE"   >Per Distance Pricing</option>
                                            <option value="WEIGHT"  >Per Weight Pricing</option>
                                            <option value="DISTANCEWEIGHT">Distance Weight Pricing</option>
                                            
                                        </select>
                                        <span class="txt_clr_4"><i id="changecal">Price Calculation: BP + (TKms-BD*PKms)</i></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">Base Distance (0 Kms)</label>
                                        <input class="form-control" type="number" value="" name="distance" id="distance" placeholder="Base Distance" min="0">
                                        <span class="txt_clr_4"><i> BD (Base Distance)</i></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">Unit Weight (0 kgs)</label>
                                        <input class="form-control" type="number" value="" name="weight" id="weight" placeholder="Unit Weight" min="0">
                                        <span class="txt_clr_4"><i> UW (Unit Weight)</i></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">Base Price (<span class="currency">$</span>0.00)</label>
                                        <input class="form-control" type="number" value="" name="fixed" id="fixed" placeholder="Base Price" min="0">
                                    <span class="txt_clr_4"><i>BP (Base Price)</i></span>
                                    </div>

                              
                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">Unit Distance Pricing (0 Kms)</label>
                                        <input class="form-control" type="hidden" value="" name="price" id="price1" placeholder="Unit Distance Price" min="0">
                                        <input class="form-control" type="number" value="" name="distance_price" id="price" placeholder="Unit Distance Price" min="0">
                                        <span class="txt_clr_4"><i> PKms (Per Kms), TKms (Total Kms)</i></span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">Commission(%)</label>
                                        <input class="form-control decimal" type="text" value="" name="commission" id="commission" placeholder="Commission" min="0">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">Fleet Commission(%)</label>
                                        <input class="form-control decimal" type="text" value="" name="fleet_commission" id="fleet_commission" placeholder="Fleet Commission" min="0">
                                     </div>
                                     <div class="form-group col-md-6">
                                        <label for="feFirstName">Tax(%)</label>
                                        <input class="form-control decimal" type="text" value="" name="tax" id="tax" placeholder="Tax" min="0">
                                     </div>
                                     <div class="form-group col-md-6">
                                        <label for="feFirstName">Peak Commission(%)</label>
                                        <input class="form-control decimal" type="text" value="" name="peak_commission" id="peak_commission" placeholder="Peak Commission" min="0">
                                     </div>

                                     <div class="custom-heading col-md-12 table-responsive">
                                       <table id="country_serv_type" class="table table-hover table_width display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Time</th>
                                                    <th>Peak Price(%) - Ride fare x Peak price(%)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="peak_table">

                                            </tbody>
                                        </table>

                                    </div>

                                    

                                    <div class="form-group col-md-12">
                                        <div class="col-xs-10">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <a href="#" class="btn btn-danger btn-block addPrice">{{ __('Submit') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- End Pricing for Country -->

                            </div>

                    </div>

                </div>
            </form>

    </div>
</div>
