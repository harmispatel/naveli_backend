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
                        <li class="breadcrumb-item active">{{ trans('label.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('posts.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ encrypt($postsEdit->id) }}">
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
                                                        <option value="">{{ trans('label.select_post_category') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ $postsEdit->parent_title == 1 ? 'selected' : '' }}>
                                                            {{ trans('label.do_you_know') }}</option>
                                                        <option value="2"
                                                            {{ $postsEdit->parent_title == 2 ? 'selected' : '' }}>
                                                            {{ trans('label.myth_vs_facts') }}</option>
                                                        <option value="3"
                                                            {{ $postsEdit->parent_title == 3 ? 'selected' : '' }}>
                                                            {{ trans('label.all_about_periods') }}</option>
                                                        <option value="4"
                                                            {{ $postsEdit->parent_title == 4 ? 'selected' : '' }}>
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
                                                        <option value="link"{{ ($postsEdit->file_type == 'link') ? 'selected' : '' }}>
                                                            Link</option>
                                                        <option value="image" {{ ($postsEdit->file_type == 'image') ? 'selected' : '' }}>
                                                            Image</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div id="linkInput" class="form-group" style="display: none;">
                                                    <label for="posts" class="form-label"><strong>{{ trans('label.enterlink') }}</strong><span class="text-danger">*</span></label>
                                                    <input type="text" name="posts" id="link" value="{{ $postsEdit->file_type == 'link' ? $postsEdit->posts : '' }}"
                                                        placeholder="Enter Media Link" class="form-control">
                                                        <div id="linkError" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <div class="form-group postInput" style="display: none;">
                                                    <label for="posts"
                                                        class="form-label"><strong>{{ trans('label.posts') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="file" name="posts" id="postsid" value="{{ $postsEdit->posts }}"
                                                        class="form-control {{ $errors->has('posts') ? 'is-invalid' : '' }}">
                                                    <div class="imageError"></div>
                                                    @if ($errors->has('posts'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('posts') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3 p-4 postInput" style="display: none;">
                                                <div class="form-group">
                                                    @if ($postsEdit->file_type == 'image' && file_exists(public_path('/images/uploads/newsPosts/' . $postsEdit->posts)))
                                                        <img style="height:50px; width:50px;"
                                                            src="{{ asset('/public/images/uploads/newsPosts/' . $postsEdit->posts) }}" />
                                                    @else
                                                        <img src="{{ asset('/public/images/uploads/general_image/noImage.png') }}"
                                                            alt="no_image" class="img-thumbnail" style="max-width: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="description"
                                                        class="form-label"><strong>{{ trans('label.description') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="description" min="0" id="description" rows="4" cols="50"
                                                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $postsEdit->description ?? '' }}</textarea>
                                                    @if ($errors->has('description'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('description') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                         
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">{{ trans('label.Save') }}</button>
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

            var selectedFileType = '{{ $postsEdit->file_type }}';
            if (selectedFileType === 'link') {
                $('#linkInput').show();
                $('.postInput').hide();
            } else if (selectedFileType === 'image') {
                $('#linkInput').hide();
                $('.postInput').show();
            }

            $('#file_type').val(selectedFileType);

            $('#file_type').change(function() {
                var file_type = $(this).val();

                // Show input field based on selected option
                if (file_type === 'link') {
                    $('#linkInput').show();
                    $('.postInput').hide();
                } else if (file_type === 'image') {
                    $('.postInput').show();
                    $('#linkInput').hide();
                } else if (file_type === '') {
                    $('.postInput').hide();
                    $('#linkInput').hide();
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
                    }
                }
            });
        });
    </script>


@endsection
