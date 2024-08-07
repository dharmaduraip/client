@extends('admin.layouts.app')
@section('title')
    {{ __('industry_types_list') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title line-height-36">{{ __('industry_types_list') }}
                            ({{ $industrytypes ? count($industrytypes) : '0' }})</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('name') }}</th>
                                    @if (userCan('industry_types.update') || userCan('industry_types.delete'))
                                        <th width="10%">{{ __('action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($industrytypes as $key => $industrytype)
                                    <tr>
                                        <td>
                                            <h5>{{ $industrytype->name }}</h5>
                                            <div>
                                                @foreach ($industrytype->translations as $translation)
                                                    <span class="d-block"><b>{{ getLanguageByCode($translation->locale) }}</b>: {{ $translation->name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @if (userCan('industry_types.update'))
                                                <a href="{{ route('industryType.edit', $industrytype->id) }}" class="btn bg-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (userCan('industry_types.delete'))
                                                <form action="{{ route('industryType.destroy', $industrytype->id) }}"
                                                    method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button
                                                        onclick="return confirm('{{ __('are_you_sure_you_want_to_delete_this_item') }}');"
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
                @if (!empty($industryType) && userCan('industry_types.update'))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title line-height-36">{{ __('edit') }} {{ __('industry_type') }}</h3>
                            <a href="{{ route('industryType.index') }}"
                                class="btn bg-primary float-right d-flex align-items-center justify-content-center"><i
                                    class="fas fa-plus mr-1"></i>{{ __('create') }}
                            </a>
                        </div>
                        <div class="card-body">
                             <form class="form-horizontal" action="{{ route('industryType.update', $industryType->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @foreach ($app_language as $key => $language)
                                    @php
                                        $label = __('name')." ".getLanguageByCode($language->code);
                                        $name = "name_{$language->code}";
                                        // $code = $industryType->translations[$key]['locale'] ?? '';
                                        //$value = $code == $language->code ? $industryType->translations[$key]['name']: '';
                                        if(isset($industryType->translations[$language->code])){
                                                    $code = $industryType->translations[$language->code]['locale'];
                                                    $value = $industryType->translations[$language->code]['name'];
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
                @endif
                @if (empty($industryType) && userCan('industry_types.create'))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title line-height-36">{{ __('create') }} {{ __('industry_type') }}</h3>
                        </div>
                        <div class="card-body">
                            @if (userCan('industry_types.create'))
                                <form class="form-horizontal" action="{{ route('industryType.store') }}" method="POST">
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
