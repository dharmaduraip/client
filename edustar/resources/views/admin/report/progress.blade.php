@extends('admin.layouts.master')
@section('title','All Progress')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Progress') }}
@endslot

@slot('menu1')
   {{ __('Progress') }}
@endslot
@endcomponent

<div class="contentbar"> 
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-box">{{ __('All Progress') }}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable" class="table table-striped table-bordered">
                          <thead><th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                      value="all" /> {{ __('ID') }}  </th>
                  <label for="checkboxAll" class="material-checkbox"></label></th>
                  
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Action') }}</th>
                  </thead>
                  <tbody>
                    @foreach($user as $key=> $pro)
                      <tr>
                        <td>
                            {{$key+1}}
                          </td>
                          <td>
                            @if($pro['user_img'] != null && $pro['user_img'] !='' &&  @file_get_contents('../public/images/user_img/'.$pro->user_img))
                                   
                                <img  src="{{ url('images/user_img/'.$pro->user_img) }}" alt="profilephoto" class="img-responsive img-circle" >

                            @else

                               <img  src="{{ Avatar::create($pro->fname)->toBase64() }}" alt="profilephoto" class="img-responsive img-circle" >

                            @endif
                            &emsp;
                            {{ $pro->fname }} {{ $pro->lname }}
                          </td>
                         
                        <td>
                           
                        <div class="btn-group mr-2">
                            <a href="{{url('progress/report/'.$pro->id)}}" class="btn btn-xs btn-primary-rgba"><i class="feather icon-eye mr-2"></i>{{ __('View') }}</a>
                                  </div>
                      </div>
                    </td>
                      </tr>
                    @endforeach
                  </tbody>
                </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
<!-- End col -->
</div>
<!-- End row -->
</div>
@endsection
@section('scripts')

<script>
      $("#checkboxAll").on('click', function () {
  $('input.check').not(this).prop('checked', this.checked);
});
</script>
@endsection
