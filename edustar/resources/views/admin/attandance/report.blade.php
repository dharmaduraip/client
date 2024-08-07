@extends('admin.layouts.master')
@section('title','Attendance Report')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Report') }}
@endslot

@slot('menu1')
   {{ __('Attendance Report') }}
@endslot
@endcomponent

<div class="contentbar"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('Attendance Report') }}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('User Name') }}</th>
                              <th>{{ __('Course Name') }}</th>
                              <th>{{ __('Attendance Date') }}</th>          
                            </tr>
                          </thead>
                          <tbody>
                            @if ($data)
                              @foreach($data as $key => $datas)
                                <tr>
                                  <td>
                                    {{$key+1}}
                                  </td>
                                  <td>{{$datas->user->fname}}</td>
                                  <td>{{$datas->course->title}}</td>
                                  <td>{{$datas->date}}</td>  
                                </tr>
                              @endforeach
            
                            @endif
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

