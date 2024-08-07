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
        .content-name .person {
          color:#309999;
          text-transform: uppercase;
          font-size:30px;
        }
        .address {
          list-style: none;
          font-size: 14px;
          padding-left: 0px;
        }
        .address li:nth-child(1) {
          display: inline-block;
          border-right: 1px solid black;
          padding-right: 10px;
/*          padding-left: 10px;*/
          text-transform: capitalize;
        }
        .address li:nth-child(2) {
          display: inline-block;
          border-right: 1px solid black;
          padding-right: 10px;
          padding-left: 10px;
        }
        .address li:nth-child(3) {
          display: inline-block;
          padding-right: 10px;
          padding-left: 10px;
          
        }
        .side-head {
          color:#309999;
          text-transform: capitalize;
          font-weight:600;
          margin-bottom: 20px;
        }
        .sec1 {
          display:inline-block;
          width:40%;
          margin-right: 10px;
          padding-left: 15px;
          text-transform: capitalize;
        }
        .sec2 {
          display:inline-block;
          width:32%;
          vertical-align: top;
        }
        .dummy {
          display: inline-block;
          width:23%;
          margin-right:10px;
        }
        .lft {
          width:23%;
          display: inline-block;
          float: left;
          margin-right:10px;
        }
        .ryt {
          width:65%;
          display: inline-block;
        }
        .font-bold {
          font-weight:600;
          text-transform: capitalize;
        }
        .text {
          text-transform: capitalize;
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
       .skill_progress {
          width: 47%;
          height: 6px;
          background: #309999;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display: inline-block;
          margin-right: 25px;
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
          background: #309999;
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
                             <div class="content-name">
                                 <p class="person"><b>{{ $user->name }}</b></p>
                                 <ul class="address">
                                    <li>{{ $user->city }}, {{ $user->country }} {{ $user->pin_code }}</li>
                                    <li>{{ $user->mobile_num }}</li>
                                    <li>{{ $user->email }}</li>
                                 </ul>
                                 <div class="mb-4">
                                   <h5 class="side-head">summary</h5>
                                   <p>
                                       {{ $user->summary }}
                                   </p>
                                 </div>
                                 <div class="mb-4">
                                   <h5 class="side-head">skill</h5>
                                   <div class="" style="width:100%;">
                                      <p class="dummy"></p>
                                      @php
                                        $skillcount = count($candidate_skills);
                                        $equal = (round($skillcount/2));
                                      @endphp
                                        @if($skillcount == "1")
                                            <ul class="sec1">
                                                @foreach($candidate_skills as $skill)
                                                    <li>{{ $skill->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <ul class="sec1">
                                                @foreach($candidate_skills as $skill)
                                                    @if($loop->iteration <= $equal)
                                                        <li>{{ $skill->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <ul class="sec2">
                                                @foreach($candidate_skills as $skill)
                                                    @if($loop->iteration > $equal)
                                                        <li>{{ $skill->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                   </div>
                                 </div>
                                @if($user->fresher != "1" || count($experiences) > 0)
                                    <div class="mb-4">
                                    <h5 class="side-head">experience</h5>
                                    @foreach($experiences as $experience)
                                        @if($loop->first)
                                            <table style="width: 100%;">
                                              <tr>
                                                <td style="width:20%;vertical-align:top">
                                                  {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                                </td>
                                                <td style="width: 80%;">
                                                  <p class="font-bold " style="margin-bottom:0px;margin-top:0px;text-align:left!important;font-size:14px;">{{ $experience->designation }}</p>
                                                  <p class="text" style="margin-bottom:0px;margin-top:5px;font-size:14px;"><b>{{ $experience->company }} </b> - {{ $experience->company_location }}</p>
                                                      @if(count($experience->responsible) > 0)
                                                           <ul class="" style="padding-left:25px;font-size:14px;">
                                                              @foreach($experience->responsible as $res)
                                                                  <li>{{ $res->responsibility }}</li>
                                                              @endforeach
                                                           </ul>
                                                      @endif
                                                </td>
                                              </tr>
                                            </table>
                                        @else
                                            <table style="width: 100%;">
                                              <tr>
                                                <td style="width:20%;vertical-align:top">
                                                  {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                                </td>
                                                <td style="width: 80%;">
                                                  <p class="font-bold " style="margin-bottom:0px;margin-top:0px;text-align:left!important;font-size:14px;">{{ $experience->designation }}</p>
                                                  <p class="text" style="margin-bottom:0px;margin-top:5px;font-size:14px;"><b>{{ $experience->company }} </b> - {{ $experience->company_location }}</p>
                                                      @if(count($experience->responsible) > 0)
                                                           <ul class="" style="padding-left:25px;font-size:14px;">
                                                              @foreach($experience->responsible as $res)
                                                                  <li>{{ $res->responsibility }}</li>
                                                              @endforeach
                                                           </ul>
                                                      @endif
                                                </td>
                                              </tr>
                                            </table>

                                        @endif
                                    @endforeach
                                    </div>
                                @endif
                                 <div class="mb-4" style="width:100%;">
                                  <h5 class="side-head">education and training</h5>
                                    @foreach($educations as $education)
                                    @if($loop->first)
                                        <table style="width: 100%;">
                                          <tr>
                                            <td rowspan="2" style="vertical-align: top;width:20%;font-weight:bold">{{ $education->year }}</td>
                                            <td style="width:80%;font-weight:bold">{{ $education->qualification }}</td>
                                          </tr>
                                          <tr>
                                            <td><span style="font-weight:bold">{{ $education->university }}</span>, {{ $education->location }}</td>
                                          </tr>
                                        </table>
                                    @else
                                        <table style="width: 100%;">
                                          <tr>
                                            <td rowspan="2" style="vertical-align: top;width:20%;font-weight:bold">{{ $education->year }}</td>
                                            <td style="width:80%;font-weight:bold">{{ $education->qualification }}</td>
                                          </tr>
                                          <tr>
                                            <td><span style="font-weight:bold">{{ $education->university }}</span>, {{ $education->location }}</td>
                                          </tr>
                                        </table>
                                      @endif  
                                    @endforeach
                                 </div>
                                <div class="mb-4" style="width:100%;padding-bottom: 40px;">
                                    <h5 class="side-head">language</h5>
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