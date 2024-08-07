<!DOCTYPE html>
<html>
<head>
  <title>{{ $user->name }} - Resume</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      color: #2A2A2A;
    }
    .fi-se {
      background-color: #FFC047;
      border-radius: 15px;
      padding: 25px;
      padding-left: 40px;
    }
    table {
      page-break-inside: avoid;
    }
    .des {
      font-size: 20px;
      padding: 0px;
      margin: 0px;
    }
    .contact {
      float: right;
      position: relative;
      width: 100%;
      height: 50px;
    }
    .contact span {
      margin: 40px 20px;
      display: inline-block;
    }
    .border-div {
      height: 58px;
      width: 50px;
      top: -102%;
      left: -2.6%;
      position: absolute;
      /*border-radius: 0px 0px 90px 0px;
      background-color: #FFC047;*/
      background-image: url('uploads/templates/temp2img.png');
    }
    .table_2 ul,
    .table_3 ul {
      padding-left: 13px;
    }
  </style>
</head>
<body style="padding:15px">
  <div class="fi-se">
    <h2 style="margin-top:0px;margin-bottom:0px;padding-bottom:0px;font-size:33px;">Hi, I am {{ $user->name }}.</h2>
  </div>
  <div class="contact">
    <span class="border-div"></span>
    <div style="float:right">
      <span>{{ $user->mobile_num }}</span>
      <span>{{ $user->email }}</span>
      <span>{{ $user->city }}, {{ $user->country }} {{ $user->pin_code }}</span>
    </div>
  </div>
  <div style="height:80px"></div>
  <table style="width:100%;margin:20px 0px;">
    <tr>
      <td style="width:20%;vertical-align: top;font-weight:bold">
        SUMMARY
      </td>
      <td style="width:80%">
          {{ $user->summary }}
      </td>
    </tr>
  </table>
  <table style="width:100%;margin:20px 0px;" class="table_2">
    <tr>
      <td style="width:20%;vertical-align: top;font-weight:bold">
        SKILLS
      </td>
      @php
        $skillcount = count($candidate_skills);
        $equal = (round($skillcount/2));
      @endphp
      @if($skillcount == "1")
          <td style="width:40%">
            <ul>
                @foreach($candidate_skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>
          </td>
      @else
          <td style="width:40%">
            <ul>
                @foreach($candidate_skills as $skill)
                  @if($loop->iteration <= $equal)
                    <li>{{ $skill->name }}</li>
                  @endif
                @endforeach
                                     
            </ul>
          </td>
          <td style="width:40%">
            <ul>
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
  @foreach($experiences as $experience)
      @if($loop->first)
          <table style="width:100%;margin:20px 0px;" class="table_3">
            <tr>
              <td style="width:20%;vertical-align:top;font-weight:bold" rowspan="3">EXPERIENCE</td>

              <td style="width:40%">{{ $experience->designation }} | {{ $experience->company }}</td>
              <td style="width:40%;vertical-align:top" rowspan="2">{{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif</td>
            </tr>
            <tr>
              <td>{{ $experience->company_location }}</td>
            </tr>
            @if(count($experience->responsible) > 0)
                <tr>
                  <td colspan="2">
                    <ul>
                        @foreach($experience->responsible as $res)
                            <li>{{ $res->responsibility }}</li>
                        @endforeach
                    </ul>
                  </td>
                </tr>
            @endif
          </table>
      @else
          <table style="width:100%;margin:20px 0px;" class="table_3">
            <tr>
              <td style="width:20%;vertical-align:top" rowspan="3"></td>
              <td style="width:40%">{{ $experience->designation }} | {{ $experience->company }}</td>
              <td style="width:40%;vertical-align:top" rowspan="2">{{ date('F Y', strtotime($experience->start)) }} @if($experience->currently_working == "1")- {{__('current')}} @else - {{ date('F Y', strtotime($experience->end)) }} @endif</td>
            </tr>
            <tr>
              <td>{{ $experience->company_location }}</td>
            </tr>
            @if(count($experience->responsible) > 0)
                <tr>
                  <td colspan="2">
                    <ul>
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
  <table style="width:100%;margin:20px 0px;">
    @foreach($educations as $education)
        @if($loop->first)
          <tr>
            <td style="width:20%;font-weight:bold">
              EDUCATION
            </td>
            <td style="width:70%">
              {{ $education->qualification }}
            </td>
            <td style="width:10%">
              {{ $education->year }}
            </td>
          </tr> 
          <tr>
            <td style="width:20%;font-weight:bold">
              AND TRAINING
            </td>
            <td style="width:70%">
              {{ $education->university }}, {{ $education->location }}
            </td>
            <td style="width:10%"></td>
          </tr>
       
        @else
            <!-- second -->
            <tr>
              <td rowspan="2" style="width:20%"></td>
              <td style="width:70%">
                  {{ $education->qualification }}
              </td>
              <td style="width:10%" rowspan="2">
                  {{ $education->year }}
              </td>
            </tr>
         
            <tr>
              <td>{{ $education->university }}, {{ $education->location }}</td>
            </tr>
        @endif
    @endforeach
  </table>
  <table style="width:100%;margin:20px 0px;">
    <tr>
      <td style="width: 20%;vertical-align:top;font-weight:bold">LANGUAGES</td>

      <td style="width:40%;vertical-align:top;">
        <ul style="padding-left:13px;">
            @foreach($candidate->languages as $user_lang)
              @if(fmod($loop->iteration,2) == "1")
                <li>{{ $user_lang->name  }}</li>
              @endif
            @endforeach
        </ul>
      </td>
      <td style="width:40%;vertical-align:top">
        <ul style="padding-left:13px;">
            @foreach($candidate->languages as $user_lang)
                @if(fmod($loop->iteration,2) == "0")
                   <li>{{ $user_lang->name  }}</li>
                @endif
            @endforeach
        </ul>
      </td>
    </tr>
  </table>
</body>
</html>