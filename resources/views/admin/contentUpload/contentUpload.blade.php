@extends('admin.layouts.admin-layout')

@section('title', 'Content Upload')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.ContentUpload') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('label.ContentUpload') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('ContentUpload.store') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $contentupload->id ?? '' }}">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.ContentUpload') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="title"
                                                class="form-label"><strong>{{ trans('label.title') }}</strong><span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title"
                                                value="{{ $contentupload->title ?? '' }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('title'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('title') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="description"
                                                class="form-label"><strong>{{ trans('label.description') }}</strong><span class="text-danger">*</span></label>
                                            <textarea class="ckeditor form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" placeholder="Enter the Description" name="description">{{ $contentupload->description ?? '' }}</textarea>
                                            @if ($errors->has('description'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('description') }}
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="user_id"
                                                class="form-label"><strong>{{ trans('label.user_id') }}</strong><span class="text-danger">*</span></label>
                                            <input type="hidden" class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" id="user_id" name="user_id">
                                            <input type="text" class="form-control" id="user_name" disabled>
                                            @if ($errors->has('user_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('user_id') }}
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="media_type"
                                                class="form-label"><strong>{{ trans('label.media_type') }}</strong><span class="text-danger">*</span></label>
                                            <input type="hidden" name="media_type" class="form-control {{ $errors->has('media_type') ? 'is-invalid' : '' }}"
                                                value="{{ $contentupload->media_type ?? '' }}">
                                            <select class="form-control media_type" id="media_type" disabled>
                                                <option value="">{{ trans('label.select_media_type') }}</option>
                                                <option value="video" @if (isset($contentupload) && $contentupload->media_type == 'video') selected @endif>
                                                    {{ trans('label.Video') }}</option>
                                                <option value="image" @if (isset($contentupload) && $contentupload->media_type == 'image') selected @endif>
                                                    {{ trans('label.Image') }}</option>
                                            </select>
                                            @if ($errors->has('media_type'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('media_type') }}
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="file"
                                                class="form-label"><strong>{{ trans('label.file') }}</strong></label>
                                            <input type="file" class="form-control" id="file" name="file">
                                            
                                            @if (
                                                $contentupload &&
                                                    $contentupload->file &&
                                                    $contentupload->media_type == 'video' &&
                                                    file_exists(public_path('/images/uploads/contentUpload/' . $contentupload->file)))
                                                <div class="mt-2">
                                                    <video
                                                        src="{{ asset('/public/images/uploads/contentUpload/' . $contentupload->file) }}"
                                                        width="320" id="image" height="240" type="video/mp4"
                                                        controls>
                                                    </video>
                                                </div>
                                            @elseif(
                                                $contentupload &&
                                                    $contentupload->file &&
                                                    $contentupload->media_type == 'image' &&
                                                    file_exists(public_path('/images/uploads/contentUpload/' . $contentupload->file)))
                                                <div class="mt-2">
                                                    <img src="{{ asset('/public/images/uploads/contentUpload/' . $contentupload->file) }}"
                                                        alt="no_image" id="image" class="img-thumbnail"
                                                        style="max-width: 100px;">
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <img src="{{ asset('/public/images/uploads/general_image/noImage.png') }}"
                                                        alt="no_image" class="img-thumbnail" style="max-width: 100px;">
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
        //ajax_image

        // mdeia type

        $(document).ready(function() {
            // Update the value of the hidden input when the dropdown changes
            $('#media_type').change(function() {
                $('input[name="media_type"]').val($(this).val());
            });

            // Update media type based on file type
            $('#file').change(function() {
                var fileInput = $(this);
                var selectedFileType = fileInput.val().split('.').pop().toLowerCase();

                if ($.inArray(selectedFileType, ['mp4', 'avi', 'mov']) !== -1) {
                    $('#media_type').val('video');
                } else if ($.inArray(selectedFileType, ['jpg', 'jpeg', 'png', 'gif']) !== -1) {
                    $('#media_type').val('image');
                } else {
                    // If it's neither video nor image, you may handle it accordingly.
                }

                $('#media_type').trigger('change');
            });
        });

        // user_id  

        $(document).ready(function() {
            $.ajax({
                url: '{{ route('getUserID') }}',
                method: 'GET',
                success: function(data) {
                    $('#user_id').val(data.user_id);
                    $('#user_name').val(data.user_name);
                }
            });

        });

        //   text-editor

        // CKEditor for term_and_condition
        CKEDITOR.ClassicEditor.create(document.getElementById("term_and_condition"), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                    'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
                    '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            'height': 500,
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                        '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                        '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                        '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType'
            ]
        });

        // CKEditor for term_and_condition
        CKEDITOR.ClassicEditor.create(document.getElementById("Contact_us_Page"), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                    'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
                    '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            'height': 500,
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                        '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                        '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                        '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType'
            ]
        });

        // CKEditor for description
        CKEDITOR.ClassicEditor.create(document.getElementById("description"), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                    'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
                    '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            'height': 500,
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                        '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                        '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                        '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType'
            ]
        });
    </script>


@endsection
