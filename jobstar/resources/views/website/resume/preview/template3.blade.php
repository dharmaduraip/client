@extends('website.layouts.app')

@section('title')
    {{ __('Resume') }}
@endsection

@section('css')
       <style type="text/css">
        .build-resume{
          padding:30px;
          background: #fff;
          display: block;
          margin: auto;
          max-width:900px;
          width:100%;
          box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        .initial-text{
          width: 80px;
          height: 80px;
          border: 2px solid #000000db;
          border-radius: 50%;
          margin-left: auto;
          margin-right: auto;
          text-align: center;
          position: relative;
          margin-bottom:15px;
        }
        .initial-text p {
          text-align: center;
          margin-bottom: 0px;
          margin-top:0px;
          position: absolute;
          top: 26px;
          left: 0;
          right: 0;
          font-weight: bold;
          font-size: 25px;
        }
        .line-text {
           position:relative;
           margin-top:40px;
           margin-bottom: 20px;
        }
        .line-text:after {
          border:1px solid #ccc;
          content:"";
          display:block;

        }
        .left-aligned {
          display: inline-block;
          position: absolute;
          top: -40px;
          font-size: 18px;
          text-transform: capitalize;
          background-color: #fff;
          padding-right:10px;
          font-weight:600;
        }
        .mail {
          list-style: none;
          text-align: center;
          font-size:14px;
        }
        .mail li:nth-child(1) {
          display: inline-block;
          border-right: 1px solid black;
          padding-right: 10px;
          padding-left: 10px;
        }
        .mail li:nth-child(2) {
          display: inline-block;
          border-right: 1px solid black;
          padding-right: 10px;
          padding-left: 10px;
        }
        .mail li:nth-child(3) {
          display: inline-block;
          padding-right: 10px;
          padding-left: 10px;
          text-transform: capitalize;
        }
        .dummy {
          margin-top:30px;
        }
        .list {
          margin-top: 30px;
          width: 100%;
        }
        .list ul {
          text-transform: capitalize;

        }
        .left ul {
          list-style:none;
          margin-bottom: 0px;
          padding-left: 0px;
        }
        .left ul li {
          display:inline-block;
        }
        .left p {
          margin-bottom: 0px;
        }
        .left ul li:nth-child(1) {
          border-right: 1px solid black;
          padding-right: 10px;
          text-transform: uppercase;
        }
        .left ul li:nth-child(2) {
          padding-left: 10px;
          padding-right: 10px;
        }
        .last-text {
          list-style: none;
          margin-top:4px;
          text-transform: capitalize;
          margin-bottom: 0px;
          padding-left: 0px;
        }
        .last-text li {
          display: inline-block;
        }
        .last-text li:nth-child(1) {
          border-right: 1px solid black;
          padding-right: 10px;
          
        }
        .last-text li:nth-child(2) {
          padding-left: 10px;
          padding-right: 10px;
        }
        .bold {
          font-weight: 600;
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
          background: #576d7b;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display:inline-block;
          margin-right:25px;
        }
        .skill_progress1 {
          width: 47%;
          height: 6px;
          background: #ccc;
          position: relative;
          margin-bottom: 34px;
          margin-top: 25px;
          display:inline-block;
       }
       .skill_progress1 .progress {
          position: absolute;
          top: 0;
          left: 0;
          height: 100%;
          background: #576d7b;
       }
       table{
        page-break-inside: avoid;
       }
       .last-text p{
          line-height: 0px!important;
          margin: 0px!important;
          padding: 0px!important;
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
                          @if($section == "header")
                            <a href="{{ route('candidate.section.header') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg"></i> Back</a>
                          @elseif($section == "experiences")
                            <a href="{{ route('candidate.section.experience') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left fa-lg" style="color:white;"></i> Back</a>
                          @elseif($section == "education")
                            <a href="{{ route('candidate.section.education') }}" class="btn btn-primary" ><i class="fas fa-arrow-circle-left fa-lg" style="color:white;"></i> Back</a>
                          @elseif($section == "skills")
                            <a href="{{ route('candidate.section.skills') }}" class="btn btn-primary" ><i class="fas fa-arrow-circle-left fa-lg" style="color:white;"></i> Back</a>
                          @endif
                        </div>
                        <div class="build-resume">
                          @if($section == "header")
                            <div class="initial-text">
                              @php
                                $sname = substr($user->name, 0, 2);
                              @endphp
                              <p>{{ $sname }}</p>
                            </div>
                            <ul class="mail">
                              <li>{{ $user->name }}</li>
                              <li>{{ $user->email }}</li>
                              <li>{{ $user->mobile_num }}</li>
                              <li>@if($user->city != "" || $user->city != NULL){{ $user->city }}, @endif{{ $user->country }} {{ $user->pin_code }}</li>
                            </ul>
                          @elseif($section == "summary")
                            <div class="line-text">
                              <h1 class="left-aligned">summary</h1>
                            </div>
                            <p class="dummy">
                                {{ $user->summary }}
                            </p>
                          @elseif($section == "skills")
                            <div class="line-text">
                              <h1 class="left-aligned">skills</h1>
                            </div>
                            <div class="list">
                              @php
                                $skillcount = count($candidate_skills);
                                $equal = (round($skillcount/2));
                              @endphp
                              @if($skillcount == "1")
                                  <ul style="width:47%;display:inline-block;padding-left:15px;">
                                      @foreach($candidate_skills as $skill)
                                          <li>{{ $skill->name }}</li>
                                      @endforeach
                                  </ul>
                              @else
                                  <ul style="width:47%;display:inline-block;padding-left:15px;">
                                    @foreach($candidate_skills as $skill)
                                        @if($loop->iteration <= $equal)
                                            <li>{{ $skill->name }}</li>
                                        @endif
                                    @endforeach
                                  </ul>
                                  <ul style="width:47%;display:inline-block;padding-left:15px;">
                                      @foreach($candidate_skills as $skill)
                                          @if($loop->iteration > $equal)
                                            <li>{{ $skill->name }}</li>
                                          @endif
                                      @endforeach
                                  </ul>
                              @endif
                            </div>
                          @elseif($section == "experiences")
                            @if($user->fresher != "1" || count($experiences) > 0)
                              <div class="line-text">
                                <h1 class="left-aligned">experience</h1>
                              </div>
                                  @foreach($experiences as $experience)
                                      @if($loop->first)
                                        <table style="width:100%">
                                          <tr>
                                            <td style="vertical-align: top;width: 40%;">{{ $experience->designation }} <br> {{ $experience->company }} <br>
                                              {{ $experience->company_location }}<br>
                                              {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                            </td>
                                            <td style="width:60%">
                                              @if(count($experience->responsible) > 0)
                                                  <ul>
                                                      @foreach($experience->responsible as $res)
                                                            <li>{{ $res->responsibility }}</li>
                                                        @endforeach
                                                  </ul>
                                                @endif
                                            </td>
                                          </tr>
                                        </table>
                                      @else
                                        <table style="width:100%">
                                          <tr>
                                             <td style="vertical-align: top;width: 40%">{{ $experience->designation }} <br> {{ $experience->company }} <br>
                                              {{ $experience->company_location }}<br>
                                              {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                            </td>
                                            <td style="width:60%">
                                                @if(count($experience->responsible) > 0)
                                                  <ul>
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
                            @endif
                          @elseif($section == "education")
                            <div class="line-text">
                              <h1 class="left-aligned">education and training</h1>
                            </div>
                            @foreach($educations as $education)
                                <div class="" style="margin-bottom: 20px;">
                                   <span class="bold mb-0">{{ $education->qualification }}</span> | 
                                    <span class="" >{{ $education->year }}</span>
                                    <ul class="last-text">
                                      <li>{{ $education->university }}</li>
                                      <li>{{ $education->location }}</li>
                                    </ul>
                                </div>
                            @endforeach
                          @elseif($section == "summary")
                            <div class="line-text ">
                              <h1 class="left-aligned">language</h1>
                            </div>
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
                          @endif      
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