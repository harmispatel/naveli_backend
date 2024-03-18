@extends('admin.layouts.admin-layout')

@section('title', 'Health Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.healthmix_group') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('healthMix.index') }}">{{ trans('label.healthmix_group') }}</a> </li>
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
                    <form class="form" action="{{ route('healthMix.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ encrypt($healthMix->id) }}">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.healthmix_group') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <!-- health Type -->
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="title" class="form-label">{{ trans('label.healthtype') }}
                                                        <span class="text-danger">*</span></label>
                                                        <select name="health_type" id="health_type" class="form-control {{ $errors->has('health_type') ? 'is-invalid' : '' }}">
                                                            <option value="">-- select type --</option>
                                                            <option value="1" {{ $healthMix->health_type == "1" ? 'Selected' : ''  }} >Expert Advice</option>
                                                            <option value="2" {{ $healthMix->health_type == "2" ? 'Selected' : ''  }} >Cycle Wisdom</option>
                                                            <option value="3" {{ $healthMix->health_type == "3" ? 'Selected' : ''  }} >Groove With Neow</option>
                                                            <option value="4" {{ $healthMix->health_type == "4" ? 'Selected' : ''  }} >Celebs Speak</option>
                                                            <option value="5" {{ $healthMix->health_type == "5" ? 'Selected' : ''  }} >Testimonials</option>
                                                            <option value="6" {{ $healthMix->health_type == "6" ? 'Selected' : ''  }} >Fun Corner</option>
                                                            <option value="8" {{ $healthMix->health_type == "8" ? 'Selected' : ''  }} >Empowher</option>
                                                        </select>
                                                        @if ($errors->has('health_type'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('health_type') }}
                                                            </div>
                                                        @endif
                                                </div>
                                            </div>

                                            <!-- media type -->
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="file_type" class="form-label"><strong>{{ trans('label.mediatype') }}</strong></label>
                                                    <select name="file_type" id="file_type" class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }} ">
                                                        <option value="">-- select type --</option>
                                                        <option value="link"{{ ($healthMix->media_type == 'link') ? 'selected' : '' }}>
                                                            Link</option>
                                                        <option value="image" {{ ($healthMix->media_type == 'image') ? 'selected' : '' }}>
                                                            Image</option>
                                                    </select>
                                                    @if ($errors->has('file_type'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('file_type') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- link input -->
                                            <div class="col-md-7 mb-3">
                                                <div id="linkInput" class="form-group" style="display:none;">
                                                    <label for="media" class="form-label"><strong>{{ trans('label.enterlink') }}</strong></label>
                                                    <input type="text" name="media" id="posts" value="{{ $healthMix->media_type == 'link' ? $healthMix->media : '' }}"
                                                        placeholder="Enter Media Link" class="form-control {{ $errors->has('media') ? 'is-invalid' : '' }} ">
                                                    @if ($errors->has('media'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('media') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- hashtags -->
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="hashtags"
                                                        class="form-label"><strong>{{ trans('label.hashtags') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="hashtags" id="hashtags"
                                                        class="form-control {{ $errors->has('hashtags') ? 'is-invalid' : '' }}">{{ $healthMix->hashtags ?? '' }}</textarea>
                                                    @if ($errors->has('hashtags'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('hashtags') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- description -->
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="description"
                                                        class="form-label"><strong>{{ trans('label.description') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="description" min="0" id="description" rows="5"
                                                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $healthMix->description ?? '' }}</textarea>
                                                    @if ($errors->has('description'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('description') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- file input -->
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group posts" style="display:none;">
                                                    <label for="media"
                                                        class="form-label"><strong>{{ trans('label.media') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="file" name="media" id="media" value=""
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <!-- file show image or video -->
                                            <div class="col-md-2 mt-2 pt-2">
                                                <div class="form-group posts" style="display:none;">
                                                    @if ($healthMix->media_type == 'image' && file_exists(public_path('/images/uploads/healthmix/' . $healthMix->media)))
                                                        <img style="height:50px; width:50px;"
                                                            src="{{ asset('/public/images/uploads/healthmix/' . $healthMix->media) }}" />
                                                    @elseif($healthMix->media_type == 'video' && file_exists(public_path('/images/uploads/healthmix/' . $healthMix->media)))
                                                        <video
                                                            src="{{ asset('/public/images/uploads/healthmix/' . $healthMix->media) }}"
                                                            width="320" id="image" height="240" type="video/mp4"
                                                            controls>
                                                        </video>
                                                    @else
                                                        <img src="{{ asset('/public/images/uploads/general_image/noImage.png') }}"
                                                            alt="no_image" class="img-thumbnail" style="max-width: 100px;">
                                                </div>
                                                @endif
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
