@extends('admin.layouts.app')
@section('title')
    {{ __('job_role_list') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title line-height-36">{{ __('job_role_list') }} ({{ count($jobRoles) }})</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('jobs') }}</th>
                                    @if (userCan('job_role.update') || userCan('job_role.delete'))
                                        <th width="10%">{{ __('action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobRoles as $key => $jobrole)
                                    <tr>
                                        <td>
                                            <h5>{{ $jobrole->name }}</h5>
                                            <div>
                                                @foreach ($jobrole->translations as $translation)
                                                    <span class="d-block"><b>{{ getLanguageByCode($translation->locale) }}</b>: {{ $translation->name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>{{ $jobrole->jobs_count }} {{ __('jobs') }}</td>
                                        <td>
                                            @if (userCan('job_role.update'))
                                                <a href="{{ route('jobRole.edit', $jobrole->id) }}" class="btn bg-info"><i
                                                        class="fas fa-edit"></i></a>
                                            @endif
                                            @if (userCan('job_role.delete'))
                                                <form action="{{ route('jobRole.destroy', $jobrole->id) }}"
                                                    method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button
                                                        onclick="return confirm('are_you_sure_you_want_to_delete_this_item');"
                                                        class="btn bg-danger"><i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            {{ __('no_data_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if (!empty($jobRole) && userCan('job_role.update'))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title line-height-36">{{ __('edit') }} {{ __('job_role') }}</h3>
                            <a href="{{ route('jobRole.index') }}"
                                class="btn bg-primary float-right d-flex align-items-center justify-content-center"><i
                                    class="fas fa-plus mr-1"></i>{{ __('create') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="pt-3 pb-4">
                                <form class="form-horizontal" action="{{ route('jobRole.update', $jobRole->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($app_language as $key => $language)
                                        @php
                                            $label = __('name')." ".getLanguageByCode($language->code);
                                            $name = "name_{$language->code}";
                                           // $code = $jobRole->translations[$key]['locale'] ?? '';
                                           // $value = $code == $language->code ? $jobRole->translations[$key]['name']: '';
                                                if(isset($jobRole->translations[$language->code])){
                                                    $code = $jobRole->translations[$language->code]['locale'];
                                                    $value = $jobRole->translations[$language->code]['name'];
                                                } else {
                                                    $code = '';
                                                    $value = '';

                                                }
                                        @endphp
                                        <div class="form-group">
                                            <x-forms.label :name="$label" for="name" :required="true" />
                                            <input id="name" type="text" name="{{ $name }}"
                                                placeholder="{{ __('name') }}" value="{{ $value }}"
                                                class="form-control @if($errors->has($name)) is-invalid @endif">
                                            @if($errors->has($name))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first($name) }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus mr-1"></i>
                                            {{ __('save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @if (empty($jobRole) && userCan('job_role.create'))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title line-height-36">{{ __('create') }} {{ __('job_role') }}</h3>
                        </div>
                        <div class="card-body">
                            @if (userCan('job_role.create'))
                                <form class="form-horizontal" action="{{ route('jobRole.store') }}" method="POST">
                                    @csrf
                                    @foreach ($app_language as $key => $language)
                                        @php
                                            $label = __('name')." ".getLanguageByCode($language->code);
                                            $name = "name_{$language->code}";
                                        @endphp
                                        <div class="form-group">
                                            <x-forms.label :name="$label" for="name" :required="true" />
                                            <input id="name" type="text" name="{{ $name }}"
                                                placeholder="{{ __('name') }}" value="{{ old('name') }}"
                                                class="form-control @if($errors->has($name)) is-invalid @endif">
                                            @if($errors->has($name))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first($name) }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus mr-1"></i>
                                            {{ __('save') }}
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p>{{ __('dont_have_permission') }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
