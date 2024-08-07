@extends('website.layouts.app')

@section('title')
    {{ __('Resume') }}
@endsection

@section('css')
    <style type="text/css">
        .sky-resume {
            padding:50px;
            background: #fff;
            display: block;
            margin: auto;
            max-width:900px;
            width:100%;
            
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        .sky-resume img {
          width:170px;
          height:170px;
          display: inline-block;
          margin-right: 30px;
          float: left;
        }
        .address1 {
          
          list-style: none;
          text-transform: capitalize;
        }
        .address1 svg {
          margin-right: 15px;
          background: #576d7b;
          width: 20px;
          height: 20px;
          padding: 4px;
          line-height: 20px;

        }
        
        .address1 li {
          margin-bottom: 10px;
        } 
        .head-title {
          color:#576d7b;
          text-transform: uppercase;
          font-size: 40px;
          font-weight: 600;
          margin-bottom: 35px;
        }
        .common {
           display: inline-block;
        }
        .sec1 {
           margin-bottom:20px;
        }
        .left {
          display:inline-block;
          width:25%;
          float:left;
          margin-right:4px;
          position: relative;
        }
        .right {
          display:inline-block;
          width:65%;
        }
        .bold {
          font-weight:600;
          text-transform: uppercase;
          font-size: 19px;
        }
        .line {
          border-bottom: 1px solid #576d7b;
          margin-bottom: 10px;
        }
        .contentbold {
          font-weight: 600;
          text-transform: capitalize;
          display: inline-block;
        }  
        .content {
          color: #000;
          text-transform: capitalize;
          display: inline-block;
        } 

        .skill_progress1 {
          width: 47%;
          height: 6px;
          background: #ccc;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display: inline-block;
        } 
        .skill_progress1 .progress {
          position: absolute;
          top: 0;
          left: 0;
          height: 100%;
          background: #576d7b;
        }
        .skill_progress {
          width: 47%;
          height: 6px;
          background: #576d7b;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display: inline-block;
          margin-right: 25px;
        }
        .horizon {
          position: absolute;
          width: 180px;
          border: 1px solid #576d7b;
          height: 6px;
          background: #576d7b;
          top: -17px;
        }
        table{
        page-break-inside: avoid;
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
                            <a href="{{ route('candidate.section.summary') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> Back</a>
                            <a href="{{ route('candidate.resume.download') }}" class="btn btn-warning"><i class="fas fa-download"></i> {{__('DOWNLOAD PDF') }}</a>
                        </div>
                        <div class="sky-resume">
                            <div class="sec1">
                                @if($candidate->photo != "" && $candidate->photo != NULL)
                                    <img src="{{ url($candidate->photo) }}">
                                @endif
                               <div class="common">
                                 <h2 class="head-title">{{ $user->name }}</h2>
                                 <ul class="address1" style="padding-left:0px;">
                                      <li>
                                        
                                        {{ $user->city }}, {{ $user->country }} {{ $user->pin_code }}
                                      </li>
                                      <li>
                                        {{ $user->mobile_num }}
                                      </li>
                                      <li>
                                        {{ $user->email }}
                                      </li>
                                 </ul>

                               </div>
                            </div>
                            <div class="line"></div>
                            <div class="sec2" style="width:100%;margin-bottom:25px;">
                              <div class="left">
                                <span class="bold">summary</span>
                                <div class="horizon"></div>
                              </div>
                              <div class="right">
                                <p>
                                    {{ $user->summary }}
                                </p>
                              </div>

                            </div>
                            <div class="line"></div>

                            <div class="sec3" style="width:100%;margin-bottom:25px;">
                              <div class="left">
                                <span class="bold">skills</span>
                                <div class="horizon"></div>
                              </div>
                              <div class="right">
                                @php
                                    $skillcount = count($candidate_skills);
                                    $equal = (round($skillcount/2));
                                  @endphp
                                  @if($skillcount == "1")
                                      @foreach($candidate_skills as $skill)
                                          <li>{{ $skill->name }}</li>
                                      @endforeach
                                  @else
                                      <ul class="" style="padding-left:15px;text-transform: capitalize;display: inline-block;width:50%;">
                                        @foreach($candidate_skills as $skill)
                                            @if($loop->iteration <= $equal)
                                                <li>{{ $skill->name }}</li>
                                            @endif
                                        @endforeach
                                      </ul>
                                      <ul class="" style="padding-left:15px;text-transform: capitalize;display: inline-block;width:45%;">
                                        @foreach($candidate_skills as $skill)
                                            @if($loop->iteration > $equal)
                                                <li>{{ $skill->name }}</li>
                                            @endif
                                        @endforeach
                                      </ul>
                                  @endif
                              </div>
                            </div>
                            <div class="line"></div>
                            @if($user->fresher != "1" || count($experiences) > 0)
                            <div class="sec4">
                              <div class="">
                                @foreach($experiences as $experience)
                                    @if($loop->first)
                                        <table style="width:100%;">
                                        <tr>
                                            <td style="width:30%;vertical-align:top" rowspan="2" class="bold">
                                                EXPERIENCE
                                            </td>
                                            <td style="width:70%">
                                                {{ $experience->designation }}, {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                                <br>
                                                {{ $experience->company }}, {{ $experience->company_location }}
                                            </td>
                                        </tr>
                                        @if(count($experience->responsible) > 0)
                                            <tr>
                                                <td style="width:70%">
                                                    <ul >
                                                          @foreach($experience->responsible as $res)
                                                              <li>{{ $res->responsibility }}</li>
                                                          @endforeach
                                                      </ul>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                    @else
                                        <table style="width:100%;">
                                            <tr>
                                                <td style="width:30%;vertical-align:top" rowspan="2">
                                                    
                                                </td>
                                                <td style="width:70%">
                                                    {{ $experience->designation }}, {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                                    <br>
                                                    {{ $experience->company }}, {{ $experience->company_location }}
                                                </td>
                                            </tr>
                                            @if(count($experience->responsible) > 0)
                                                <tr>
                                                    <td style="width:70%">
                                                        <ul >
                                                              @foreach($experience->responsible as $res)
                                                                  <li>{{ $res->responsibility }}</li>
                                                              @endforeach
                                                          </ul>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    @endif
                                    @if(!$loop->last)
                                            <table style="width:100%">
                                                <tr>
                                                    <td style="width:30%"></td>
                                                    <td style="border-bottom:1px dotted black;width: 70%;"></td>
                                                </tr>
                                            </table>
                                        
                                    @endif
                                @endforeach
                              </div>

                            </div>
                            <div class="line"></div>
                            @endif
                            <div class="sec5" style="width:100%;margin-bottom:25px;">
                                 <div class="">
                                    @foreach($educations as $education)
                                        @if($loop->first)
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 30%;font-weight:bold">EDUCATION AND</td>
                                                    <td style="width: 70%;"><b>{{ $education->university }}</b>, {{ $education->location }}</td>
                                                </tr>
                                                <tr>
                                                    <td style=" width: 30%;font-weight:bold">TRAINING</td>
                                                    <td style="width: 70%;">{{ $education->qualification }} | {{ $education->year }}</td>
                                                </tr>
                                            </table>
                                           @else
                                            <table style="width: 100%;margin: 10px 0px;">
                                                <tr>
                                                    <td style="width:30%" rowspan="2"></td>
                                                    <td style="width:70%"><b>{{ $education->university }}</b>, {{ $education->location }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:70%">{{ $education->qualification }} | {{ $education->year }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                    @endforeach
                                  </div>
                            </div>
                            <div class="line"></div> 


                            <div class="sec6" style="width:100%;margin-bottom:25px;">
                              <div class="left">
                                <span class="bold">language</span>
                                <div class="horizon"></div>
                              </div>
                              <div class="right">
                                    <div style="width:100%;padding-bottom: 40px;">
                                        <ul style="width: 50%;float: left;">
                                            @foreach($candidate->languages as $user_lang)
                                                @if(fmod($loop->iteration,2) == "1")
                                                   <li>{{ $user_lang->name  }}</li>
                                                @endif
                                            @endforeach 
                                        </ul>
                                        <ul style="width: 50%;float: left;">
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
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        
    </script>
@endsection