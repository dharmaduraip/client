@extends('website.layouts.app')

@section('title')
    {{ __('Resume') }}
@endsection

@section('css')
    <style>
    * {
      color: #434D54;
    }
    .center {
      text-align: center;
    }
    .border {
      border: 1px solid black;
      margin: 25px 0px;
    }
    .my-1 {
      margin: 10px 0px;
    }
    .title-con {
      position: relative;
    }
    .title-con span {
      position: absolute;
      top: -12px;
      left: 0;
      right: 0;
      z-index: 99999;
      margin: 0 auto;
      background: white;
      width: 100px;
      text-align: center;
      font-weight: bold;
      font-size: 20px;
    }
    .Summary {
      width: 120px !important;
    }
    .skills {
      width: 80px !important;
    }
    .exp {
      width: 130px !important;
    }
    .Education {
      width: 260px !important;
    }
    .Languages {
      width: 130px !important;
    }
    ul li {
      padding: 5px 0px;
    }
    .bold {
      font-weight: bold;
    }
    .tempsec{
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
      padding: 25px;
    }
  </style>
@endsection
@section('main')
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row">
                <x-website.candidate.sidebar />
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{ route('candidate.section.summary') }}" class="btn btn-primary" ><i class="fas fa-arrow-circle-left fa-lg" style="color:white;"></i> Back</a>
                            <a href="{{ route('candidate.resume.download') }}" class="btn btn-warning"><i class="fas fa-download" style="color:white;"></i> {{__('DOWNLOAD PDF') }}</a>
                        </div>
                        <div class="tempsec">
                          <div style="padding:15px;">
                            <h3 class="center">{{ $user->name }}</h3>
                            <p class="center">{{ $user->email }} | {{ $user->mobile_num }} | {{ $user->city }}, {{ $user->country }} {{ $user->pin_code }}</p>
                          </div>
                          <div class=" title-con">
                            <div class="border"></div>
                            <span class="Summary">Summary</span>
                            <p class="center" style="padding:0px 15px;">{{ $user->summary }}</p>
                          </div>
                          <div class=" title-con">
                            <div class="border"></div>
                            <span class="skills">Skills</span>
                            <div class="d-block ">
                              @php
                                $skillcount = count($candidate_skills);
                                $equal = (round($skillcount/2));
                              @endphp
                              @if($skillcount == "1")
                                  <div style="display:inline-block;width:48%">   
                                      <ul>
                                          @foreach($candidate_skills as $skill)
                                              <li>{{ $skill->name }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @else
                                  <div style="display:inline-block;width:48%">   
                                      <ul>
                                        @foreach($candidate_skills as $skill)
                                          @if($loop->iteration <= $equal)
                                            <li>{{ $skill->name }}</li>
                                          @endif
                                        @endforeach
                                      </ul>
                                  </div>
                                  <div style="display:inline-block;width:48%">
                                    <ul>
                                        @foreach($candidate_skills as $skill)
                                          @if($loop->iteration > $equal)
                                            <li>{{ $skill->name }}</li>
                                          @endif
                                        @endforeach
                                    </ul>
                                  </div>
                              @endif
                            </div>
                          </div>
                          @if($user->fresher != "1" || count($experiences) > 0)
                          <div class=" title-con">
                            <div class="border"></div>
                            <span class="exp">Experience</span>
                            @foreach($experiences as $experience)
                                <p class="center"> <i class="bold"> {{ $experience->designation }} </i> | {{ $experience->company }} - {{ $experience->company_location }} | {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif</p>
                                @if(count($experience->responsible) > 0)
                                    <ul>
                                        @foreach($experience->responsible as $res)
                                            <li>{{ $res->responsibility }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                          </div>
                          @endif
                          <div class=" title-con">
                            <div class="border"></div>
                            <span class="Education">Education and Training</span>
                              @foreach($educations as $education)
                                  <p class="center">{{ $education->qualification }} | {{ $education->university }} | {{ $education->year }}</p>
                                  <p class="center bold">{{ $education->location }}</p>
                              @endforeach
                          </div>
                          <div class=" title-con">
                            <div class="border"></div>
                            <span class="Languages">Languages</span>
                                <div style="display:inline-block;width:48%">   
                                    <ul>
                                     @foreach($candidate->languages as $user_lang)
                                        @if(fmod($loop->iteration,2) == "1")
                                          <li>{{ $user_lang->name  }}</li>
                                        @endif
                                      @endforeach
                                    </ul>
                                </div>
                                <div style="display:inline-block;width:48%">
                                  <ul>
                                      @foreach($candidate->languages as $user_lang)
                                          @if(fmod($loop->iteration,2) == "0")
                                             <li>{{ $user_lang->name  }}</li>
                                          @endif
                                      @endforeach
                                  </ul>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
    
