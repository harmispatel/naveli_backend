@extends('admin.layouts.admin-layout')

@section('title', 'All About Periods Posts')

@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>{{ trans('label.all_about_periods') }}</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"> <a
                            href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                    <li class="breadcrumb-item">{{ trans('label.all_about_periods') }}</li>
                    <li class="breadcrumb-item active"> <a
                            href="{{ route('aap.posts.index') }}">{{ trans('label.posts') }}</a> </li>
                    <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
{{-- Clients Card --}}
<div class="col-md-12">
    <div class="card">

        <form class="form" action="{{ route('aap.posts.store') }}" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <div class="form_box">
                    <div class="form_box_inr">
                        <div class="box_title">
                            <h2>{{ trans('label.all_about_periods') }} {{ trans('label.posts') }}</h2>
                        </div>
                        <div class="form_box_info">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="title"
                                            class="form-label"><strong>{{ trans('label.forums_category') }}</strong><span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="category_name"
                                            class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}"
                                            value="{{ old('category_name') }}">
                                        @if ($errors->has('category_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category_name') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            <!--<div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="title"
                                            class="form-label"><strong>{{ trans('label.forums_category') }}</strong><span
                                                class="text-danger">*</span></label>
                                        <select name="category_type" id="category_type"
                                            class="form-control {{ $errors->has('category_type') ? 'is-invalid' : '' }}">
                                            <option value="">-- select type --</option>
                                            @foreach($getCategories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_type') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_type'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category_type') }}
                                        </div>
                                        @endif
                               
                                    </div>
                                </div> -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="media" class="form-label"><strong>{{ trans('label.icon') }}</strong>
                                            <span class="text-danger">*</span></label>
                                        <input type="file" name="icon" id="icon" value="{{ old('icon') }}"
                                            class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('icon'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('icon') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="file_type"
                                            class="form-label"><strong>{{ trans('label.mediatype')}}</strong><span
                                                class="text-danger">*</span></label>
                                        <select name="file_types[]" id="file_type"
                                            class="form-control {{ $errors->has('file_types') ? 'is-invalid' : '' }} ">
                                            <option value="">{{ trans('label.select_file_type')}}</option>
                                            <option value="link" {{ old('file_type') == 'link' ? 'selected' : '' }}>Link
                                            </option>
                                            <option value="image" {{ old('file_type') == 'image' ? 'selected' : '' }}>
                                                Image</option>
                                        </select>
                                        @if ($errors->has('file_types'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('file_types') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div id="linkInput" class="form-group" style="display: none;">
                                        <label for="media"
                                            class="form-label"><strong>{{ trans('label.enterlink')}}</strong></label>
                                        <input type="text" name="media_links[]" id="media_link"
                                            placeholder="Enter Media Link"
                                            class="form-control {{ $errors->has('media_links') ? 'is-invalid' : '' }} ">
                                        @if ($errors->has('media_links'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('media_links') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group" id="mediaInput" style="display: none;">
                                        <label for="media"
                                            class="form-label"><strong>{{ trans('label.media') }}</strong><span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="media_files[]" id="media_file"
                                            class="form-control {{ $errors->has('media_files') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('media_files'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('media_files') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description"
                                            class="form-label"><strong>{{ trans('label.description') }}</strong>
                                            <span class="text-danger">*</span></label>
                                        <textarea name="descriptions[]" id="description" rows="5"
                                            class="form-control {{ $errors->has('descriptions') ? 'is-invalid' : '' }}"></textarea>
                                        @if ($errors->has('descriptions'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('descriptions') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="media-container">
                                </div>
                                <div class="col-md-12 text-end mb-3">
                                    <button type="button" id="add-media" class="btn btn-sm new-category custom-btn">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn form_button">{{ trans('label.Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</section>

@endsection

@section('page-js')

<script>
$(document).ready(function() {
    var initialFileType = $('#file_type').val();
    if (initialFileType === 'link') {
        $('#linkInput').show();
        $('#mediaInput').hide();
    } else if (initialFileType === 'image') {
        $('#mediaInput').show();
        $('#linkInput').hide();
    }
    $('#file_type').change(function() {
        var file_type = $(this).val();
        // Hide all input fields
        $('#linkInput, #mediaInput').hide();
        // Show input field based on selected option
        if (file_type === 'link') {
            $('#linkInput').show();
            $('#mediaInput').hide();
        } else if (file_type === 'image') {
            $('#mediaInput').show();
            $('#linkInput').hide();
        }
    });
});

$(document).on('click', '#add-media', function() {
    var html = `
        <div class="row media-row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="file_type" class="form-label"><strong>{{ trans('label.mediatype')}}</strong></label>
                    <select name="file_types[]" class="form-control file_type">
                        <option value="link">Link</option>
                        <option value="image">Image</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group linkInput">
                    <label for="media" class="form-label"><strong>{{ trans('label.enterlink')}}</strong></label>
                    <input type="text" name="media_links[]" class="form-control media_link">
                </div>
                <div class="form-group posts" style="display: none;">
                    <label for="media" class="form-label"><strong>{{ trans('label.media') }}</strong></label>
                    <input type="file" name="media_files[]" class="form-control media_file">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group descriptions">
                    <label for="description"
                        class="form-label"><strong>{{ trans('label.description') }}</strong>
                       </label>
                    <textarea name="descriptions[]" id="description" rows="5"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="col-md-12 text-end mb-3">
                <button type="button" class="btn btn-sm new-category btn-danger remove-media"><i class="bi bi-trash"></i></button>
            </div>
        </div>`;
    $('.media-container').append(html);
});

$(document).on('click', '.remove-media', function() {
    $(this).closest('.media-row').remove();
});

$(document).on('change', '.file_type', function() {
    var $parent = $(this).closest('.media-row');
    var fileType = $(this).val();
    if (fileType === 'link') {
        $parent.find('.linkInput').show();
        $parent.find('.posts').hide();
    } else if (fileType === 'image') {
        $parent.find('.linkInput').hide();
        $parent.find('.posts').show();
    }
});
</script>


@endsection