@extends('admin.layouts.app')
@section('title')
    {{ __('job_list') }}
@endsection
@section('content')
    @php
        $userr = auth()->user();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title line-height-36">{{ __('job_list') }}</h3>
                        <div>
                            <a href="{{ route('admin.job.edited.index') }}" class="btn bg-secondary"><i
                                    class="fas fa-hourglass-start"></i>
                                {{ __('pending_edited_jobs') }}
                                <span class="badge badge-info right">
                                    {{ $edited_jobs }}
                                </span>
                            </a>
                            <a href="{{ route('job.create') }}" class="btn bg-primary"><i class="fas fa-plus mr-1"></i>
                                {{ __('create') }}
                            </a>
                            @if (request('title') ||
                                    request('job_category') ||
                                    request('job_type') ||
                                    request('experience') ||
                                    request('sort_by') ||
                                    request('filter_by'))
                                <a href="{{ route('job.index') }}" class="btn bg-danger"><i class="fas fa-times"></i>
                                    &nbsp;{{ __('clear') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Filter  --}}
                <form id="formSubmit" action="{{ route('job.index') }}" method="GET" onchange="this.submit();">
                    <div class="card-body border-bottom row">
                        <div class="col-2">
                            <label>{{ __('search') }}</label>
                            <input name="title" type="text" placeholder="{{ __('search') }}" class="form-control"
                                value="{{ request('title') }}">
                        </div>
                        <div class="col-2">
                            <label>{{ __('job_category') }}</label>
                            <select name="job_category" class="form-control w-100-p">
                                <option value="">
                                    {{ __('all') }}
                                </option>
                                @foreach ($job_categories as $job_category)
                                    <option {{ request('job_category') == $job_category->id ? 'selected' : '' }}
                                        value="{{ $job_category->id }}">
                                        {{ $job_category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label>{{ __('job_type') }}</label>
                            <select name="job_type" class="form-control w-100-p">
                                <option value="">
                                    {{ __('all') }}
                                </option>
                                @foreach ($job_types as $job_type)
                                    <option {{ request('job_type') == $job_type->slug ? 'selected' : '' }}
                                        value="{{ $job_type->slug }}">
                                        {{ $job_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label>{{ __('experience') }}</label>
                            <select name="experience" class="form-control w-100-p">
                                <option value="">
                                    {{ __('all') }}
                                </option>
                                @foreach ($experiences as $experience)
                                    <option {{ request('experience') == $experience->slug ? 'selected' : '' }}
                                        value="{{ $experience->slug }}">
                                        {{ $experience->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label>{{ __('sort_by') }}</label>
                            <select name="sort_by" class="form-control w-100-p">
                                <option {{ !request('sort_by') || request('sort_by') == 'latest' ? 'selected' : '' }}
                                    value="latest" selected>
                                    {{ __('latest') }}
                                </option>
                                <option {{ request('sort_by') == 'oldest' ? 'selected' : '' }} value="oldest">
                                    {{ __('oldest') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label>{{ __('filter_by') }}</label>
                            <select name="filter_by" class="form-control w-100-p">
                                <option {{ request('filter_by') ? '' : 'selected' }} value="">
                                    {{ __('all') }}
                                </option>
                                <option {{ request('filter_by') == 'active' ? 'selected' : '' }} value="active">
                                    {{ __('active') }}
                                </option>
                                <option {{ request('filter_by') == 'pending' ? 'selected' : '' }} value="pending">
                                    {{ __('pending') }}
                                </option>
                                <option {{ request('filter_by') == 'expired' ? 'selected' : '' }} value="expired">
                                    {{ __('expired') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0 m-0">
                    @include('admin.layouts.partials.message')
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="ll-table table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th width="5%">{{__('job')}}</th>
                                        <th width="10%">{{ __('category') }}/{{ __('role') }}</th>
                                        <th width="10%">{{ __('salary') }}</th>
                                        <th width="10%">{{ __('deadline') }}</th>
                                        <th width="10%">{{ __('status') }}</th>
                                        @if (userCan('job.update') || userCan('job.delete'))
                                            <th width="10%">{{ __('action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($jobs->count() > 0)
                                        @foreach ($jobs as $job)
                                            <tr>
                                                <td tabindex="0">
                                                    <a href="{{ route('job.show', $job->id) }}"  class="company">
                                                        <img src="{{ asset($job->company->logo_url) }}" alt="image">
                                                        <div>
                                                            <h2>{{ $job->title }}</h2>
                                                            <p>
                                                                <span>{{ $job->company && $job->company->user ?$job->company->user->name:'-'  }}</span>
                                                                <span>·</span>
                                                                <span>{{ $job->job_type->name ?? '' }}</span>
                                                                @if ($job->is_remote)
                                                                <span>·</span>
                                                                <span>{{ __('remote') }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td tabindex="0">
                                                    <div class="category">
                                                        <x-svg.table-layer />
                                                        <div>
                                                            <h3>{{ $job->category->name }}</h3>
                                                            <p>{{ $job->role->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td tabindex="0">
                                                    <div class="category">
                                                        <x-svg.table-money />
                                                        <div>
                                                            @if ($job->salary_mode == 'range')
                                                            <h3 class='bold'>{{ getFormattedNumber($job->min_salary) }} - {{ getFormattedNumber($job->max_salary) }} {{ currentCurrencyCode() }}</h3>
                                                            @else
                                                            <h3 class="bold">{{ $job->custom_salary }}</h3>
                                                            @endif
                                                            <p>{{ $job->salary_type->name }} </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td tabindex="0">
                                                    {{ date('j F, Y', strtotime($job->deadline)) }}
                                                </td>
                                                @if (userCan('job.update'))
                                                    <td tabindex="0">
                                                        <div class="d-flex">
                                                            @if ($job->status == 'pending')
                                                            <form action="{{ route('admin.job.status.change', $job->id) }}" method="POST" id="job_status_pending_form_{{ $job->id }}">
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input onclick="$('#job_status_pending_form_{{ $job->id }}').submit()" type="radio" id="status_input_pending_{{ $job->id }}" name="status"
                                                                            class="plan_type_selection custom-control-input" value="pending"
                                                                            {{ $job->status == 'pending' ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="status_input_pending_{{ $job->id }}">{{__('pending')}}</label>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                            <form action="{{ route('admin.job.status.change', $job->id) }}" method="POST" id="job_status_publish_form_{{ $job->id }}">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input onclick="$('#job_status_publish_form_{{ $job->id }}').submit()" type="radio" id="status_input_publish_{{ $job->id }}" name="status"
                                                                        class="plan_type_selection custom-control-input" value="active"
                                                                        {{ $job->status == 'active' ? 'checked' : '' }}>
                                                                    <label class="custom-control-label" for="status_input_publish_{{ $job->id }}">{{__('publish')}}</label>
                                                                </div>
                                                            </form>
                                                            @if ($job->status == 'active' || $job->status == 'expired')
                                                            <form action="{{ route('admin.job.status.change', $job->id) }}" method="POST" id="job_status_unpublish_form_{{ $job->id }}">
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input onclick="$('#job_status_unpublish_form_{{ $job->id }}').submit()" type="radio" id="status_input_unpublish_{{ $job->id }}" name="status"
                                                                            class="plan_type_selection custom-control-input" value="expired"
                                                                            {{ $job->status == 'expired' ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="status_input_unpublish_{{ $job->id }}">{{__('unpublish')}}</label>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('details') }}"
                                                        href="{{ route('job.show', $job->id) }}"
                                                        class="btn ll-btn ll-border-none">{{ __('view_details') }}<x-svg.table-btn-arrow />
                                                    </a>
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('clone') }}"
                                                        href="{{ route('admin.job.clone', $job->slug) }}"
                                                        class="btn ll-mr-4 ll-p-0"><x-svg.table-clone /> {{ __('clone') }}
                                                    </a>

                                                    <a target="_blank" data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('view_frontend') }}"
                                                        href="{{ route('website.job.details', $job->slug) }}"
                                                        class="btn ll-mr-4 ll-p-0"><x-svg.table-link />
                                                    </a>
                                                    @if (userCan('job.update'))
                                                        <a data-toggle="tooltip" data-placement="top"
                                                            title="{{ __('edit') }}"
                                                            href="{{ route('job.edit', $job->id) }}"
                                                            class="btn ll-mr-4 ll-p-0"><x-svg.table-edit />
                                                        </a>
                                                    @endif
                                                    @if (userCan('job.delete'))
                                                        <form action="{{ route('job.destroy', $job->id) }}"
                                                            method="POST" class="d-inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button data-toggle="tooltip" data-placement="top"
                                                                title="{{ __('delete') }}"
                                                                onclick="return confirm('{{ __('are_you_sure_you_want_to_delete_this_item') }}');"
                                                                class="btn ll-p-0"><x-svg.table-delete />
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">{{ __('no_data_found') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($jobs->total() > $jobs->perPage())
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            validate();
            $('#title').keyup(validate);
        });

        function validate() {
            if (
                $('#title').val().length > 0) {
                $('#crossB').removeClass('d-none');
            } else {
                $('#crossB').addClass('d-none');
            }
        }

        function RemoveFilter(id) {
            $('#' + id).val('');
            $('#formSubmit').submit();
        }
    </script>
@endsection
