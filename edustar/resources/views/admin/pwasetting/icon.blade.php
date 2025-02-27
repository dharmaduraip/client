
<!-- form start -->
<form action="{{ route('icons.update') }}" method="POST" enctype="multipart/form-data">
  @csrf
      <!-- row start -->
      <div class="row">
          <div class="col-md-12">
              <!-- card start -->
              <div class="card">
                  <!-- card body start -->
                  <div class="card-body">
                      <!-- row start -->
                        <div class="row">
                            
                            <div class="col-md-12">
                                <!-- row start -->
                                <div class="row">
                                  
                                <div class="col-md-3">
                                      <div class="form-group">
                                          <label class="text-dark">{{ __('PWA') }} {{ __('Icon') }} (512x512) : <span class="text-danger">*</span> </label>           
                                          <input type="file" name="icon_512" class="form-control" accept=".png"/>
                                      </div>
                                  </div>

                                  <div class="col-md-2 well">
                                  <img src="{{ url('images/icons/icon-512x512.png') }}" class="img-responsive img-circle" >
                                  </div>


                                  <!-- SplashScreen -->
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="text-dark">{{ __('PWA') }} {{ __('SplashScreen') }} (2048x2732) : <span class="text-danger">*</span> </label>
                                          <input type="file" name="splash_2048" class="form-control" accept=".png" />
                                      </div>
                                  </div>

                                  <div class="col-md-2 well">
                                    <img src="{{ url('images/icons/splash-2048x2732.png') }}" class="img-responsive img-circle" >  
                                  </div>
                                                    
                                  <!-- create and close button -->
                                  <div class="col-md-12">
                                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                            {{ __("Update")}}</button>
                                    </div>


                                </div><!-- row end -->
                            </div><!-- col end -->
                        </div><!-- row end -->

                  </div><!-- card body end -->
              </div><!-- card end -->
          </div><!-- col end -->
      </div><!-- row end -->
</form>
                 

