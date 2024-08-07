@extends('admin.layouts.app')
@section('title')
    {{ __('create_post') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title line-height-36">{{ __('create') }}</h3>
                        <a href="{{ route('module.blog.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center"><i
                                class="fas fa-arrow-left"></i>&nbsp;{{ __('back') }}
                        </a>
                    </div>
                    <div class="container">
                        <form class="row mt-4" action="{{ route('module.blog.store') }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div>
                                    <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                                    <div class="">
                                        <div class="">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-lebel">
                                                    {{ __('title') }}
                                                    <small class="text-danger">*</small>
                                                </label>
                                                <input value="{{ old('title') }}" name="title" type="text"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="{{ __('enter') }} {{ __('title') }}">
                                                @error('title')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-lebel">
                                                    {{ __('category') }}
                                                    <small class="text-danger">*</small>
                                                </label>
                                                <select name="category_id"
                                                    class="select2bs4 @error('category_id') is-invalid @enderror w-100-p">
                                                    <option value="">{{ __('select_one') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option {{ old('category_id') == $category->id ? 'selected' : '' }}
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-lebel">
                                                    {{ __('thumbnail_image') }}
                                                    <small class="text-danger">*</small>
                                                </label>
                                                <div class="upload-btn-wrapper">
                                                    <input type="file" class="form-control dropify" data-default-file=""
                                                        name="image" accept="image/png, image/jpg, image/jpeg, image/gif"
                                                        data-allowed-file-extensions='["jpg", "jpeg","png", "gif"]'
                                                        data-max-file-size="3M">
                                                </div>
                                                @error('image')
                                                    <span class="invalid-feedback d-block"
                                                        role="alert"><strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-lebel">
                                        {{ __('short_description') }}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <textarea rows="5" type="text" class="form-control height-124px" name="short_description"
                                        placeholder="{{ __('enter') }} {{ __('short_description') }}">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <span class="text-danger font-size-13"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-lebel">
                                        {{ __('description') }}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <textarea id="editor2" type="text" class="form-control" name="description"
                                        placeholder="{{ __('enter') }}  {{ __('description') }}">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger font-size-13"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <div class=""></div>
                                    <div class="text-center">
                                        <button type="submit" value="draft" name="status" class="btn btn-secondary">
                                            <i class="fas fa-archive"></i>&nbsp;{{ __('save_as_draft') }}
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus"></i>&nbsp;{{ __('published') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend/plugins/dropify/css/dropify.min.css') }}">
    <style>
        .ck-editor__editable_inline {
            min-height: 160px;
        }

        .select2-results__option[aria-selected=true] {
            display: none;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            color: #fff;
            border: 1px solid #fff;
            background: #007bff;
            border-radius: 30px;
        }

        .height-124px {
            height: 124px !important
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }

        .align-items-center {
            -ms-flex-align: center !important;
            align-items: center !important;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        // dropify
        $('.dropify').dropify();

        ClassicEditor
            .create(document.querySelector('#editor2'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
