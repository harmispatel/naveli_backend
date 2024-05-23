@extends('admin.layouts.admin-layout')

@section('title', 'Health Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.HealthMix') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('healthMix.index') }}">{{ trans('label.healthmix_group') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="{{ route('healthMix.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.healthmix_group') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="title"
                                                class="form-label"><strong>{{ trans('label.healthtype') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <select name="health_type" id="health_type" class="form-control {{ $errors->has('health_type') ? 'is-invalid' : '' }}">
                                                <option value="" >-- select type --</option>
                                                <option value="1" {{ old('health_type') == 1 ? 'selected' :''}} >Expert Advice</option>
                                                <option value="2" {{  old('health_type') == 2 ? 'selected' :''}} >Cycle Wisdom</option>
                                                <option value="3" {{ old('health_type') == 3 ? 'selected' :''}} >Groove With Neow</option>
                                                <option value="4" {{  old('health_type') == 4 ? 'selected' :''}} >Celebs Speak</option>
                                                <option value="5" {{  old('health_type') == 5 ? 'selected' :''}} >Testimonials</option>
                                                <option value="6" {{  old('health_type') == 6 ? 'selected' :''}} >Fun Corner</option>
                                                <option value="8" {{  old('health_type') == 8 ? 'selected' :''}} >Empowher</option>
                                            </select>
                                            @if ($errors->has('health_type'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('health_type') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="file_type" class="form-label"><strong>
                                                {{ trans('label.mediatype')}}
                                                </strong><span class="text-danger">*</span></label>
                                            <select name="file_type" id="file_type" class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }} ">
                                                <option value="">-- select type --</option>
                                                <option value="link"{{ old('file_type') == 'link' ? 'selected' : '' }}>
                                                    Link</option>
                                                <option value="image" {{ old('file_type') == 'image' ? 'selected' : '' }}>
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
                                            <label for="media" class="form-label"><strong>{{ trans('label.enterlink')}}</strong></label>
                                            <input type="text" name="media" id="posts" value="{{old('media')}}"
                                                placeholder="Enter Media Link" class="form-control {{ $errors->has('media') ? 'is-invalid' : '' }} ">
                                            @if ($errors->has('media'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('media') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group posts" style="display: none;">
                                            <label for="media"
                                                class="form-label"><strong>{{ trans('label.media') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="file" name="media" id="media" value="{{ old('media') }}"
                                                class="form-control {{ $errors->has('media') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('media'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('media') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="hashtags"
                                                class="form-label"><strong>{{ trans('label.hashtags') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <textarea name="hashtags" id="hashtags"
                                                class="form-control {{ $errors->has('hashtags') ? 'is-invalid' : '' }}">{{ old('hashtags') }}</textarea>
                                            @if ($errors->has('hashtags'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('hashtags') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="description_en"
                                                class="form-label"><strong>{{ trans('label.description') }} (EN)</strong>
                                                <span class="text-danger">*</span></label>
                                            <textarea name="description_en" id="description_en" rows="5"
                                                class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}">{{ old('description_en') }}</textarea>
                                            @if ($errors->has('description_en'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('description_en') }}
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
                </div>
            </form>
        </div>
    </div>
    </div>
    </section>

@endsection


@section('page-js')

    <script>
        // $(document).ready(function() {
        //     $('#posts').change(function() {
        //         var fileExstenstion = $(this).val().split('.').pop().toLowerCase();

        //         if ($.inArray(fileExstenstion, ['mp4', 'avi', 'mov', 'mkv']) !== -1) {
        //             $('#file_type').val('video');
        //             $('.file_type').val('video');
        //         }
        //         else if($.inArray(fileExstenstion, ['jpg', 'jpeg', 'png', 'gif']) !== -1) {
        //             $('#file_type').val('image');
        //             $('.file_type').val('image');
        //         } else {
        //             $('#file_type').val('');
        //             $('.file_type').val('');
        //         }

        //         $('#file_type').prop('disabled', false);
        //     });
        // });
        $(document).ready(function() {
            var initialFileType = $('#file_type').val();
                if (initialFileType === 'link') {
                    $('#linkInput').show();
                } else if (initialFileType === 'image') {
                    $('.posts').show();
                }
            $('#file_type').change(function() {
                var file_type = $(this).val();

                // Hide all input fields
                $('#linkInput, .posts').hide();

                // Show input field based on selected option
                if (file_type === 'link') {
                    $('#linkInput').show();
                } else if (file_type === 'image') {
                    $('.posts').show();
                }
            });
        });
    </script>


@endsection
