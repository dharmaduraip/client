@component('mail::message')
Hi {{ $instructor_name }} !!
<br>


{{ $req_user_name }} like to involve for your course ({{ $course_title }}).
<br>
For more details please login and check in our website.
<br>
<br>
@component('mail::button', ['url' => config('app.url')])
Click Here
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent