@extends('admin.layouts.master')
@section('title','Push Notification Setting')
@section('breadcum')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Push Notification') }}
@endslot
@slot('menu1')
{{ __('Push Notification') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
        <div class="col-md-8">
            <div class="card m-b-30">
                <div class="card-header">
                    <form action="{{ route('admin.push.notif') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ __('Select User Group') }}: <span
                                    class="text-danger">*</span> </label>
                            <select required data-placeholder="Please select user group" name="user_group" id=""
                                class="select2 form-control">
                                <option value="" disabled selected>{{ __('Select User Group') }}</option>
                                <option {{ old('user_group') == 'all_users' ? "selected" : "" }} value="all_customers">
                                    {{ __('All') }} {{ __('Users') }} </option>
                                <option {{ old('user_group') == 'all_instructors' ? "selected" : "" }}
                                    value="all_sellers">
                                    {{ __('All') }} {{ __('Instructors') }} </option>
                                <option {{ old('user_group') == 'all_admins' ? "selected" : "" }} value="all_admins">
                                    {{ __('All') }} {{ __('Admin') }} </option>
                                <option {{ old('user_group') == 'all' ? "selected" : "" }} value="all">
                                    {{ __('All') }}
                                    ({{ __('Users') }} + {{ __('Instructors') }} +
                                    {{ __('Admin') }})</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Subject') }}: <span
                                    class="text-danger">*</span></label>
                            <input placeholder="" type="text" class="form-control" required name="subject"
                                value="{{ old('subject') }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Notification Body') }} : <span
                                    class="text-danger">*</span> </label>
                            <textarea required placeholder="" class="form-control" name="message" id="" cols="3"
                                rows="5">{{ old('message') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Target URL') }} : </label>
                            <input value="{{ old('target_url') }}" class="form-control" name="target_url" type="url"
                                placeholder="{{ url('/') }}">
                            <small class="text-info">
                                <i class="fa fa-question-circle"></i> {{ __('On click of notification where you want to
                                redirect the user') }}.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Notification Icon') }} : </label>
                            <input value="{{ old('icon') }}" name="icon" class="form-control" type="url"
                                placeholder="https://someurl/icon.png">
                            <small class="text-info">
                                <i class="fa fa-question-circle"></i>{{ __('If not enter than default icon will use which you
                                upload at time
                                of create one signal app') }} .
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('Image') }}: </label>
                            <input value="{{ old('image') }}" class="form-control" name="image" type="url"
                                placeholder="https://someurl/image.png">
                            <small class="text-info">
                                <i class="fa fa-question-circle"></i> <b>{{ __('RecommnadedSize') }}:
                                    450x228 px.</b>
                            </small>
                        </div>
                        <div class="from-group">
                            <label for="">{{ __('Show Button') }}: </label>
                            <br>
                            <label class="switch">
                                <input type="checkbox" class="push" name="show_button"  {{ old('show_button') ? "checked" : "" }} />
                                <span class="knob"></span>
                            </label>
                        </div>
                        <div style="display: {{ old('show_button') ? 'block' : 'none' }};" id="buttonBox">
                            <div class="form-group">
                                <label for="">{{ __('Button Text') }}: <span
                                        class="text-danger">*</span></label>
                                <input value="{{ old('btn_text') }}" class="form-control" name="btn_text" type="text"
                                    placeholder="Grab Now !">
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('Button Target URL') }} : </label>
                                <input value="{{ old('btn_url') }}" class="form-control" name="btn_url" type="url"
                                    placeholder="https://someurl/image.png">
                                <small class="text-muted text-info">
                                    <i class="fa fa-question-circle"></i> {{ __('On click of button where you want to redirect
                                    the user') }}.
                                </small>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __('Send') }}</button>
                        </div>
                    </form>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card m-b-30">
                <div class="card-header">
                    <a title="Get one signal keys" href="https://onesignal.com/" class="pull-right" target="__blank">
                        <i class="fa fa-key"></i> {{ __('Get your keys from here') }}
                    </a>
                    <br>
                     <form action="{{ route('onesignal.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="ONESIGNAL_APP_ID">{{ __('ONE SIGNAL APP ID') }}: <span
                                    class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input id="password-field"  value="{{ env('ONESIGNAL_APP_ID') }}" type="password"  name="ONESIGNAL_APP_ID" class="form-control" placeholder="Enter ONESIGNAL APP ID">
                                <div class="input-group-prepend text-center">
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ONESIGNAL_REST_API_KEY"> {{ __('ONE SIGNAL REST API KEY') }}: <span
                                class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input id="password-fieldscds"  value="{{ env('ONESIGNAL_REST_API_KEY') }}" type="password"  name="ONESIGNAL_REST_API_KEY" class="form-control" placeholder="Enter ONESIGNAL REST API KEY">
                                <div class="input-group-prepend text-center">
                                <span toggle="#password-fieldscds" class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                              {{__('Reset')}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                              {{ __('Update') }}</button>
                        </div>
                    </form>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script>
    $('.push').on('change', function () {
        if ($(this).is(":checked")) {
            $('input[name=btn_text]').attr('required', 'required');
            $('#buttonBox').show('fast');
        } else {
            $('input[name=btn_text]').removeAttr('required');
            $('#buttonBox').hide('fast');
        }
    });
</script>
@endsection