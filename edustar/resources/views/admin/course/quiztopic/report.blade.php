@extends('admin.layouts.master')
@section('title','Report')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Report') }}
@endslot

@slot('menu1')
   {{ __('Report') }}
@endslot
@slot('button')
  <div class="col-md-4 col-lg-4">
      <div class="widgetbar">
        <a href="{{ url('/course/create/'.$topics->course_id) }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
      </div>
  </div>
@endslot
@endcomponent

<div class="contentbar"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('All Report') }}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('User') }}</th>
                              <th>{{ __('Email') }}</th>          
                              <th>{{ __('Quiz') }}</th>
                              <th>{{ __('Marks Get') }}</th>
                              <th>{{ __('Total Marks') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if ($ans)
                              @foreach($filtStudents as $key => $student)
                                <tr>
                                  <td>
                                    {{$key+1}}
                                  </td>
                                  <td>{{$student->fname}}</td>
                                  <td>{{$student->email}}</td>               
                                  <td>{{$topics->title}}</td>
                                  <td>
                                    @php
                                      $mark = 0;
                                      $correct = collect();
                                    @endphp
                                    @foreach ($ans as $answer)
                                      @if ($answer->user_id == $student->id && $answer->answer == $answer->user_answer)
                                        @php
                                         $mark++;
                                        @endphp
                                      @endif
                                    @endforeach
                                    @php
                                      $correct = $mark*$topics->per_q_mark;
                                    @endphp
                                    {{$correct}}
                                  </td>
                                  <td>
                                    {{$c_que*$topics->per_q_mark}}
                                  </td>
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

