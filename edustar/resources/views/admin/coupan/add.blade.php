@extends('admin.layouts.master')
@section('title','Create a new Coupon')
@section('breadcum')
<div class="breadcrumbbar">
  <div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
      <h4 class="page-title">{{ __('Add Coupon') }}</h4>
      <div class="breadcrumb-list">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admins') }}">{{ __('Dashboard') }}</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ __('Add Coupon') }}
          </li>
        </ol>
      </div>
    </div>

    <div class="col-md-4 col-lg-4">

      <div class="widgetbar">
        <a title="Back" href="{{ url('coupon') }}" class="btn btn-primary-rgba"><i
            class="feather icon-arrow-left mr-2"></i>{{__('Back')}}</a>
      </div>
    </div>
  </div>
</div>
@endsection
@section('maincontent')
<div class="contentbar">
    <div class="row">
      <div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-header">
            <h5 class="card-box">{{ __('Add') }} {{ __('Coupon') }}</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('coupon.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="text-dark">{{ __('Coupon Code') }}: <span class="text-danger">*</span></label>
                          <input required="" type="text" class="form-control" name="code">
                      </div>
                    </div>

                    <div class="col-md-6">
                     <div class="form-group">
                          <label class="text-dark">{{ __('Discount Type') }}: <span class="text-danger">*</span></label>
                          <select required="" name="distype" id="distype" class="form-control select2">
                              <option value="fix">{{ __('FixAmount') }}</option>
                              <option value="per">% {{ __('Percentage') }}</option>
                          </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="text-dark">{{ __('Amount') }}: <span class="text-danger">*</span></label>
                          <input required="" type="number"  type="text" class="form-control" name="amount">
      
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                            <label for="exampleInputDetails">{{ __('Coupon Code display on front') }}:</label>
                            <br>
                                <input  class="custom_toggle"  type="checkbox" name="show_to_users"  checked />
                                <br>
                            <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="frees"></label>
                            <small class="text-info">({{ __('If Choose Yes then Coupon Code shows to all users') }})
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="text-dark">{{ __('Linked to') }}: <span class="text-danger">*</span></label>
      
                          <select required="" name="link_by" id="link_by"
                              class="form-control select2">
                              <option value="none" selected disabled hidden>
                                  {{ __('Select an Option') }}
                              </option>
                              <option value="course">{{ __('Link to Course') }}</option>
                              <option value="cart">{{ __('Link to Cart') }}</option>
                              <option value="category">{{ __('Link to Category') }}</option>
                              <option value="bundle">{{ __('Link to Bundle') }}</option>
                          </select>
      
                      </div>
                    </div>


                    <div class="col-md-6" id="probox" style="display: none;"> 
                      <div  class="form-group" >
                          <label class="text-dark">{{ __('Select Course') }}: <span class="text-danger">*</span> </label>
                          <br>
                          <select style="width: 100%" id="pro_id" name="course_id"
                              class="form-control select2">
                              <option value="none" selected disabled hidden>
                                  {{ __('Select an Option') }}
                              </option>
                              @foreach (App\Course::where('status', '1')->get() as $product)
                                  @if ($product->type == 1)
      
                                      <option value="{{ $product->id }}">{{ $product['title'] }}
                                          - {{ $product->discount_price }}<i
                                              class="{{ $currency->icon }}">{{ $currency->currency }}</i>
                                      </option>
                                  @endif
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <div id="bundlebox" class="col-md-6" style="display: none;">
                      <div  class="form-group" >
                          <label class="text-dark">{{ __('Select Bundle') }}: <span class="text-danger">*</span> </label>
                          <br>
                          <select style="width: 100%" id="bundle_id" name="bundle_id"
                              class="form-control select2">
                              <option value="none" selected disabled hidden>
                                  {{ __('Select an Option') }}
                              </option>
                              @foreach (App\BundleCourse::where('status', '1')->get()->sortByDesc('updated_at') as $product)
                                  @if ($product->type == 1)
                                      <option value="{{ $product->id }}">{{ $product['title'] }}
                                          @isset($product->billing_interval)
                                              - {{ $product->discount_price }} <i
                                                  class="{{ $currency->icon }}">{{ $currency->currency }}</i> /
                                              {{ $product->billing_interval }}
                                          @endisset()
                                      </option>
                                  @endif
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <div id="catbox" class="col-md-6" style="display: none;">

                      <div class="form-group">
                          <label class="text-dark">{{ __('Select Categories') }}: <span class="text-danger">*</span>
                          </label>
                          <br>
                          <select style="width: 100%" id="cat_id" name="category_id"
                              class="form-control select2">
                              <option value="none" selected disabled hidden>
                                  {{ __('Select an Option') }}
                              </option>
                              @foreach (App\Categories::where('status', '1')->get() as $category)
                                  <option value="{{ $category->id }}">{{ $category['title'] }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-md-6" id="minAmount">
                      <div  class="form-group">
                          <label class="text-dark">{{ __('Min Amount') }}: </label>
                          <div class="input-group">
                              
                              <input type="number" min="0.0" value="0.00" step="0.1" class="form-control" name="minamount">
                              <span class="input-group-text" id="basic-addon2"><i class="{{ $currency->icon }}"></i></span>
      
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="text-dark">{{ __('Expiry Date') }}: </label>
                             
                          <div class="input-group">                                  
                            <input type="text" id="default-date" class="datepicker-here form-control"  name="expirydate" placeholder="dd/mm/yyyy" aria-describedby="basic-addon2"/>
                              <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar"></i></span>
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">

                      <div class="form-group">
                          <label class="text-dark">{{ __('Max Usage Limit') }}: <span class="text-danger">*</span></label>
                          <input required="" type="number" min="1" class="form-control" name="maxusage">
                      </div>

                    </div>

                     
                    <br>
                    <div class="form-group col-md-6 mt-5">
                        <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{__('Reset')}}</a>
                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                        {{__('Create')}}</button>
                    </div>
                  
                  <div class="clear-both"></div>
                  </div>
                  </div>
                </div>
        </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
    <script>
        (function($) {
            "use strict";

            $('#link_by').on('change', function() {
                var opt = $(this).val();

                if (opt == 'course') {
                    $('#minAmount').hide();
                    $('#probox').show();
                    $('#bundlebox').hide();
                    $('#pro_id').attr('required', 'required');
                } else if (opt === 'bundle') {
                    $('#minAmount').hide();
                    $('#probox').hide();
                    $('#bundlebox').show();
                    $('#bundle_id').attr('required', 'required');
                } else {
                    $('#minAmount').show();
                    $('#probox').hide();
                    $('#bundlebox').hide();
                    $('#pro_id').removeAttr('required');
                }
            });

            $('#link_by').on('change', function() {
                var opt = $(this).val();

                if (opt == 'category') {
                    $('#catbox').show();
                    $('#pro_id').attr('required', 'required');
                } else {
                    $('#catbox').hide();
                    $('#pro_id').removeAttr('required');
                }
            });

            $(function() {
                $("#expirydate").datepicker({
                    dateFormat: 'yy-m-d'
                });
            });

        })(jQuery);

    </script>

@endsection

