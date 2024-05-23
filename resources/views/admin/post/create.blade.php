@extends('admin.layouts.admin-layout')

@section('title', 'Posts Section')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.posts') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('posts.index') }}">{{ trans('label.posts') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.Posts Detail') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="post_category_selection" class="form-label">
                                                <strong>{{ trans('label.parent_title') }}</strong>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select
                                                class="form-control {{ $errors->has('parent_title') ? 'is-invalid' : '' }}"
                                                id="post_category_selection" name="parent_title">

                                                <option value="">{{ trans('label.select_post_category') }}</option>
                                                <option value="1" {{ old('parent_title') == 1 ? 'selected' : '' }}>
                                                    {{ trans('label.do_you_know') }}</option>
                                                <option value="2" {{ old('parent_title') == 2 ? 'selected' : '' }}>
                                                    {{ trans('label.myth_vs_facts') }}</option>
                                                <!-- <option value="3" {{ old('parent_title') == 3 ? 'selected' : '' }}>
                                                    {{ trans('label.all_about_periods') }}</option> -->
                                                <option value="4" {{ old('parent_title') == 4 ? 'selected' : '' }}>
                                                    {{ trans('label.nutrition') }}</option>
                                            </select>
                                            @if ($errors->has('parent_title'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('parent_title') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="file_type" class="form-label"><strong>{{ trans('label.mediatype') }}
                                                    </strong><span class="text-danger">*</span></label>
                                            <select name="file_type" id="file_type" class="form-control">
                                                <option value="">-- select type --</option>
                                                <option value="link"{{ old('file_type') == 'link' ? 'selected' : '' }}>
                                                    Link</option>
                                                <option value="image" {{ old('file_type') == 'image' ? 'selected' : '' }}>
                                                    Image</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div id="linkInput" class="form-group" style="display: none;">
                                            <label for="posts" class="form-label"><strong>{{ trans('label.enterlink') }}</strong><span class="text-danger"> *</span></label>
                                            <input type="text" name="posts" id="link" value="{{ old('posts') }}"
                                                placeholder="Enter Media Link"
                                                class="form-control">
                                            <div id="linkError" class="text-danger"></div>
                                        </div>
                                        <div class="form-group" id="postInput" style="display: none;">
                                            <label for="posts"
                                                class="form-label"><strong>{{ trans('label.posts') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="file" name="posts" id="postsid" value="{{ old('posts') }}"
                                                class="form-control {{ $errors->has('posts') ? 'is-invalid' : '' }}">
                                            <div class="imageError"></div>
                                            @if ($errors->has('posts'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('posts') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="description_en"
                                                class="form-label"><strong>{{ trans('label.description') }} (EN)</strong>
                                                <span class="text-danger">*</span></label>
                                            <textarea name="description_en" id="description_en" rows="5" cols="100"
                                                class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}">{{ old('description_en') }}</textarea>
                                            @if ($errors->has('description_en'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('description_en') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="file_type"
                                                class="form-label"><strong>{{ trans('label.file_type') }}</strong></label>
                                            <input type="hidden" name="file_type"
                                                class="form-control file_type {{ $errors->has('file_type') ? 'is-invalid' : '' }}"
                                                value="{{ old('file_type') }}">
                                            <select class="form-control file_type" id="file_type" disabled>
                                                <option value="">{{ trans('') }}</option>
                                                <option value="video">
                                                    {{ trans('label.Video') }}</option>
                                                <option value="image">
                                                    {{ trans('label.Image') }}</option>
                                            </select>
                                            @if ($errors->has('file_type'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('file_type') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div> --}}
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
            $('#postsid').change(function() {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.svg|\.webp)$/i;
                var fileName = $(this).val();
                if (fileName && !allowedExtensions.exec(fileName)) {
                    $('.imageError').html(
                        '<span class="text-danger">Only jpg, jpeg, png, svg, and webp files are allowed</span>'
                    );
                    $(this).val('');
                    return false;
                } else {
                    $('.imageError').empty();
                }
            });
        });

        $(document).ready(function() {

            var selectedFileType = '{{ old('file_type') }}';
            if (selectedFileType === 'link') {
                $('#linkInput').show();
                $('#postInput').hide();
            } else if (selectedFileType === 'image') {
                $('#linkInput').hide();
                $('#postInput').show();
            }

            $('#file_type').val(selectedFileType);

            $('#file_type').change(function() {
                var file_type = $(this).val();

                // Show input field based on selected option
                if (file_type === 'link') {
                    $('#linkInput').show();
                    $('#postInput').hide();
                } else if (file_type === 'image') {
                    $('#postInput').show();
                    $('#linkInput').hide();
                } else if (file_type === '') {
                    // If blank option selected, hide both inputs
                    $('#linkInput').hide();
                    $('#postInput').hide();
                }
            });

            // Validate the link input when the form is submitted
            $('form').submit(function(e) {
                var file_type = $('#file_type').val();
                if (file_type === 'link') {
                    var linkValue = $('#link').val();
                    var urlPattern =
                /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|shorts\/)|youtu\.be\/)[\w-]+(\?\S*)?$/;
                    if (!urlPattern.test(linkValue)) {
                        e.preventDefault(); // Prevent form submission
                        $('#linkError').html('Please enter a valid URL'); // Show error message
                    } else {
                        // If no file type selected, hide both inputs
                        $('#linkInput').hide();
                        $('#postInput').hide();
                    }
                }
            });
        });
    </script>


@endsection
