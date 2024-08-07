@if(file_exists(public_path().'/images/user_img/'.$user_img) && $user_img != NULL)
    <img @error('photo') is-invalid @enderror
        src="{{ url('images/user_img/'.$user_img) }}" alt="profilephoto"
        class="img-responsive img-circle" data-toggle="modal"
        data-target="#exampleStandardModal{{ $id }}">
@else
<img @error('photo') is-invalid @enderror
        src="{{ Avatar::create($fname)->toBase64() }}" alt="profilephoto"
        class="img-responsive img-circle" data-toggle="modal"
        data-target="#exampleStandardModal{{ $id }}">

@endif
<div class="modal fade" id="exampleStandardModal{{$id}}" tabindex="-1"
        role="dialog" aria-labelledby="exampleStandardModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleStandardModalLabel">
                        {{ $fname }}</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body py-5">
<div class="row">
<div class="user-modal">
@if($image =
@file_get_contents('../public/images/user_img/'.$user_img))
<img @error('photo') is-invalid @enderror
src="{{ url('images/user_img/'.$user_img) }}"
alt="profilephoto"
class="img-responsive img-circle">
@else
<img @error('photo') is-invalid @enderror
src="{{ Avatar::create($fname)->toBase64() }}"
alt="profilephoto"
class="img-responsive img-circle">
@endif
</div>
<div class="col-lg-12">
<h4 class="text-center">
{{ $fname }}{{ $lname }}
</h4>
<div class="button-list mt-4 mb-3">
<button type="button" class="btn btn-primary-rgba">
    <a href = "mailto: {{ $email }}"><i class="feather icon-email mr-2"></i>{{ $email }}</a>
</button>
@if($mobile != "")
    <button type="button" class="btn btn-success-rgba">
        <a @if($phone_code != "") href="tel: {{ $phone_code }}{{ $mobile }}" @else href="tel: {{ $mobile }}" @endif ><i class="feather icon-phone mr-2"></i>{{ $mobile }}</a>
    </button>
@endif
</div>
<div class="table-responsive">
<table
class="table table-borderless mb-0 user-table">
<tbody>
@isset($dob)
<tr>
    <th scope="row" class="p-1">
        Date Of Birth :</th>
    <td class="p-1">
        {{ $dob }}</td>
</tr>
@endisset
@isset($address)
    <div class="d-flex">
        <label class="text-dark">Address :</label> 
        <span>&emsp;{{ $address}}</span>
    </div>
@endisset
@isset($gender)
    <div class="d-flex">
        <label class="text-dark">Gender :</label> 
        <span>&emsp;{{ $gender}}</span>
    </div>
@endisset
    <div class="d-flex">
        <label class="text-dark">Role :</label> 
        <span>&emsp;{{ $role}}</span>
    </div>
@if($youtube_url != '' & $youtube_url != NULL)
    <div class="d-flex">
        <label class="text-dark">Youtube Url :</label> 
        &emsp;<a href="{{$youtube_url}}">{{str_limit($youtube_url, '30')}}</a>
    </div>
@endif

@isset($fb_url)
    <div class="d-flex">
        <label class="text-dark">Facebook Url :</label> 
        &emsp;<a href="{{$fb_url}}">{{str_limit($fb_url, '30')}}</a>
    </div>
@endisset

@isset($twitter_url)
    <div class="d-flex">
        <label class="text-dark">Twitter Url :</label> 
        &emsp;<a href="{{$twitter_url}}">{{str_limit($twitter_url, '30')}}</a>
    </div>
@endisset

@isset($linkedin_url)
    <div class="d-flex">
        <label class="text-dark">Linkedin Url :</label> 
        &emsp;<a href="{{$linkedin_url}}">{{str_limit($linkedin_url, '30')}}</a>
    </div>
@endisset

</tbody>
</table>
</div>
</div>
</div>
</div>