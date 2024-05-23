@extends('admin.layouts.admin-layout')
@section('title', 'Women In News - Create')
@section('content')

{{-- Page Title --}}
<div class="pagetitle">
    <h1>{{ trans('label.news') }}</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"> <a href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                    <li class="breadcrumb-item active"> <a href="{{ route('woman-in-news.index') }}">{{ trans('label.news') }}</a> </li>
                    <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <form class="form" action="{{ route('woman-in-news.store') }}" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <div class="form_box">
                    <div class="form_box_inr">
                        <div class="box_title">
                            <h2>{{ trans('label.news') }}</h2>
                        </div>
                        <div class="form_box_info">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="title_en" class="form-label"><strong>{{ trans('label.title') }} (EN)<span class="text-danger">*</span></strong></label>
                                        <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" class="form-control {{ $errors->has('title_en') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('title_en'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('title_en') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description_en" class="form-label"><strong>{{ trans('label.description') }} (EN)<span class="text-danger">*</span></strong></label>
                                        <textarea name="description_en" id="description_en" class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}" rows="8">{{ old('description_en') }}</textarea>
                                        @if ($errors->has('description_en'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description_en') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="media_type" class="form-label"><strong>Media Type</strong></label>
                                        <select name="media_type" id="media_type" class="form-select">
                                            <option value="link" {{ (old('media_type') == 'link') ? 'selected' : '' }}>Link</option>
                                            <option value="image" {{ (old('media_type') == 'image') ? 'selected' : '' }}>Image</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3" id="link-div" style="display: none;">
                                    <div class="form-group">
                                        <label for="link" class="form-label"><strong>Link <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="link" id="link" class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" value="{{ old('link') }}">
                                        @if ($errors->has('link'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('link') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3" id="image-div" style="display: none;">
                                    <div class="form-group">
                                        <label for="image" class="form-label"><strong>Image <span class="text-danger">*</span></strong></label>
                                        <input type="file" name="image" id="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('image'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('image') }}
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
    $(document).ready(function() {
        var media_type = $('#media_type :selected').val();
        if(media_type == 'link'){
            $('#link-div').show();
            $('#image-div').hide();
        }else{
            $('#link-div').hide();
            $('#image-div').show();
        }
    });

    $('#media_type').on('change', function () {
        if($(this).val() == 'link'){
            $('#link-div').show();
            $('#image-div').hide();
        }else{
            $('#link-div').hide();
            $('#image-div').show();
        }
    });

</script>


@endsection
