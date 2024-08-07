@extends('website.layouts.app')

@section('title')
    {{ __('Resume') }}
@endsection

@section('css')
    <style>
        .border-30 {
          border: 20px solid #FFCA71;
        }
        .center {
          text-align: center;
        }
        h2.center span {
          padding: 0px 10px;
          color: #666;
        }
        h2 {
          color: #300;
          font-size: 35px;
          margin: 10px 0px;
        }
        h3 {
          color: #300;
          margin-bottom: 0px;
          font-size: 25px;
        }
        .bd-bt {
          border-bottom: 1px solid #DADADA;
          margin-top: 20px;
        }
        .black-resume{
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            padding:25px;
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
                        <div class="black-resume">
                             <div class="border-30"></div>
                                  <h2 class="center">{{ $user->name }}</h2>
                                  <p class="center">{{ $user->email }} | {{ $user->mobile_num }} | {{ $user->city }}, {{ $user->country }} {{ $user->pin_code }}</p>
                                  <div class="bd-bt">
                                    <h3>Summary</h3>
                                  </div>
                                  <table style="width: 100%;">
                                    <tr>
                                      <td style="width:20%"></td>
                                      <td style="width:80%">{{ $user->summary }}</td>
                                    </tr>
                                  </table>
                                  <div class="bd-bt">
                                    <h3>Skills</h3>
                                  </div>
                                  <table style="width: 100%;">
                                    <tr>
                                      <td style="width:20%"></td>
                                       @php
                                        $skillcount = count($candidate_skills);
                                        $equal = (round($skillcount/2));
                                      @endphp
                                      @if($skillcount == "1")
                                        <td style="width:40%;vertical-align:top;">
                                            <ul style="padding-left: 0px;margin-top:0px;">
                                                @foreach($candidate_skills as $skill)
                                                  <li>{{ $skill->name }}</li>
                                                @endforeach
                                            </ul>
                                          </td>

                                      @else
                                          <td style="width:40%;vertical-align:top;">
                                            <ul style="padding-left: 0px;margin-top:0px;">
                                                @foreach($candidate_skills as $skill)
                                                  @if($loop->iteration <= $equal)
                                                    <li>{{ $skill->name }}</li>
                                                  @endif
                                                @endforeach
                                            </ul>
                                          </td>
                                          <td style="width:40%;vertical-align:top;">
                                            <ul style="padding-left: 0px;margin-top:0px;">
                                                @foreach($candidate_skills as $skill)
                                                  @if($loop->iteration > $equal)
                                                    <li>{{ $skill->name }}</li>
                                                  @endif
                                                @endforeach
                                            </ul>
                                          </td>
                                      @endif
                                    </tr>
                                  </table>
                                  @if($user->fresher != "1" || count($experiences) > 0)
                                  <div class="bd-bt">
                                    <h3>Experience</h3>
                                  </div>
                                  @foreach($experiences as $experience)
                                      @if($loop->first)
                                          <table style="width: 100%;">
                                            <tr>
                                              <td style="width: 20%;" rowspan="3"></td>
                                              <td style="width:60%">
                                                {{ $experience->designation }} | {{ $experience->company }}
                                              </td>
                                              <td style="width:20%">
                                                {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="width:80%">
                                                {{ $experience->company_location }}
                                              </td>
                                            </tr>
                                            @if(count($experience->responsible) > 0)
                                                <tr>
                                                  <td style="width:80%">
                                                    <ul style="padding-top:0px;margin-top:0px">
                                                        @foreach($experience->responsible as $res)
                                                            <li>{{ $res->responsibility }}</li>
                                                        @endforeach
                                                    </ul>
                                                  </td>
                                                </tr>
                                            @endif
                                          </table>
                                        @else
                                         <table style="width: 100%;">
                                            <tr>
                                              <td style="width: 20%;" rowspan="3"></td>
                                              <td style="width:60%">
                                                {{ $experience->designation }} | {{ $experience->company }}
                                              </td>
                                              <td style="width:20%">
                                                    {{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="width:80%">
                                                    {{ $experience->company_location }}
                                              </td>
                                            </tr>
                                            @if(count($experience->responsible) > 0)
                                            <tr>
                                              <td style="width:80%">
                                                <ul style="padding-top:0px;margin-top:0px">
                                                    @foreach($experience->responsible as $res)
                                                        <li>{{ $res->responsibility }}</li>
                                                    @endforeach
                                                </ul>
                                              </td>
                                            </tr>
                                            @endif
                                        </table>
                                        @endif
                                  @endforeach
                                  @endif
                                  <div class="bd-bt">
                                    <h3>Education and Training</h3>
                                  </div>
                                    @foreach($educations as $education)
                                      <table style="width:100%">
                                        <tr>
                                          <td style="width:20%" rowspan="2"></td>
                                          <td style="width: 50%;">
                                            {{ $education->qualification }}
                                          </td>
                                          <td style="width: 30%;">
                                            {{ $education->year }}
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="width: 80%;" colspan="2">
                                            {{ $education->university }}, {{ $education->location }}
                                          </td>
                                        </tr>
                                      </table>
                                    @endforeach
                                  <div class="bd-bt">
                                    <h3>Language</h3>
                                  </div>
                                  <table style="width:100%">
                                    <tr>
                                      <td style="width:20%"></td>
                                      <td style="width:80%">
                                        <ul style="padding-left:0px;margin-top:0px">
                                            @foreach($candidate->languages as $user_lang)
                                              <li>{{ $user_lang->name  }}</li>
                                            @endforeach
                                        </ul>
                                      </td>
                                    </tr>
                                  </table>
                             
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