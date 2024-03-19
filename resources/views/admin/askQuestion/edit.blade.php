@extends('admin.layouts.admin-layout')

@section('title', 'Ask Your question')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.askquestion') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('userAskQuestion.index') }}">{{ trans('label.askquestion') }}</a> </li>
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
                    <form class="form" action="{{ route('userAskQuestion.update') }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ encrypt($askQuestion->id) }}">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.askquestion') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label"><strong>{{ trans('label.Name') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        value="{{ $askQuestion->name }}"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" readonly>
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="user_question"
                                                        class="form-label"><strong>{{ trans('label.askquestion') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="user_question" id="user_question"
                                                        value="{{ $askQuestion->user_question }}"
                                                        class="form-control {{ $errors->has('user_question') ? 'is-invalid' : '' }}" readonly>
                                                    @if ($errors->has('user_question'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('user_question') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="file_type"
                                                        class="form-label"><strong>{{ trans('label.filetype') }}
                                                        </strong><span class="text-danger">*</span></label>
                                                    <select name="file_type" id="file_type" class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }}">
                                                        <option value="">-- select type --</option>
                                                        <option
                                                            value="link"{{ $askQuestion->file_type == 'link' ? 'selected' : '' }}>
                                                            Link</option>
                                                        <option value="image"
                                                            {{ $askQuestion->file_type == 'image' ? 'selected' : '' }}>
                                                            Image</option>
                                                    </select>
                                                    @if ($errors->has('file_type'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('file_type') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div id="linkInput" class="form-group" style="display: none;">
                                                    <label for="image"
                                                        class="form-label"><strong>{{ trans('label.enterlink') }}</strong><span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="image" id="link"
                                                        value="{{ $askQuestion->file_type == 'link' ? $askQuestion->image : '' }}"
                                                        placeholder="Enter Media Link" class="form-control">
                                                    <div id="linkError" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group imageInput" style="display: none;">
                                                    <label for="image"
                                                        class="form-label"><strong>{{ trans('label.image') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="file" name="image" id="imageid"
                                                        value="{{ $askQuestion->image }}"
                                                        class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                                    <div class="imageError"></div>
                                                    @if ($errors->has('image'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('image') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3 p-4 imageInput" style="display: none;">
                                                <div class="form-group">
                                                    @if (
                                                        $askQuestion->file_type == 'image' &&
                                                            file_exists(public_path('/images/uploads/askQuestion/' . $askQuestion->image)))
                                                        <img style="height:50px; width:50px;"
                                                            src="{{ asset('/public/images/uploads/askQuestion/' . $askQuestion->image) }}" />
                                                    @else
                                                        <img src="{{ asset('/public/images/uploads/general_image/noImage.png') }}"
                                                            alt="no_image" class="img-thumbnail" style="max-width: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="question_answer"
                                                        class="form-label"><strong>{{ trans('label.adminanswer') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="question_answer" id="question_answer"
                                                        class="form-control {{ $errors->has('question_answer') ? 'is-invalid' : '' }}">{{ $askQuestion->question_answer }}</textarea>
                                                    @if ($errors->has('question_answer'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('question_answer') }}
                                                        </div>
                                                    @endif
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
            $('#imageid').change(function() {
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

            var selectedFileType = '{{ $askQuestion->file_type }}';
            if (selectedFileType === 'link') {
                $('#linkInput').show();
                $('.imageInput').hide();
            } else if (selectedFileType === 'image') {
                $('#linkInput').hide();
                $('.imageInput').show();
            }

            $('#file_type').val(selectedFileType);

            $('#file_type').change(function() {
                var file_type = $(this).val();

                // Show input field based on selected option
                if (file_type === 'link') {
                    $('#linkInput').show();
                    $('.imageInput').hide();
                } else if (file_type === 'image') {
                    $('.imageInput').show();
                    $('#linkInput').hide();
                } else if (file_type === '') {
                    $('.imageInput').hide();
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
