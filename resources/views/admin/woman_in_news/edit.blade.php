@extends('admin.layouts.admin-layout')
@section('title', 'Women In News - Edit')
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
                    <li class="breadcrumb-item active">{{ trans('label.edit') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <form class="form" action="{{ route('woman-in-news.update') }}" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ encrypt($woman_in_news->id) }}">
                <div class="form_box">
                    <div class="form_box_inr">
                        <div class="box_title">
                            <h2>{{ trans('label.news') }}</h2>
                        </div>
                        <div class="form_box_info">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="title" class="form-label"><strong>{{ trans('label.title') }} <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="title" id="title" value="{{ old('title', $woman_in_news->title) }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('title'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('title') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description" class="form-label"><strong>{{ trans('label.description') }} <span class="text-danger">*</span></strong></label>
                                        <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="8">{{ old('description', $woman_in_news->description) }}</textarea>
                                        @if ($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="media_type" class="form-label"><strong>Media Type</strong></label>
                                        <select name="media_type" id="media_type" class="form-select">
                                            <option value="link" {{ (old('media_type', $woman_in_news->file_type) == 'link') ? 'selected' : '' }}>Link</option>
                                            <option value="image" {{ (old('media_type', $woman_in_news->file_type) == 'image') ? 'selected' : '' }}>Image</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3" id="link-div" style="display: none;">
                                    @php
                                        $link_val = ($woman_in_news->file_type == 'link') ? $woman_in_news->posts : "";
                                    @endphp
                                    <div class="form-group">
                                        <label for="link" class="form-label"><strong>Link <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="link" id="link" class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" value="{{ old('link', $link_val) }}">
                                        @if ($errors->has('link'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('link') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3" id="image-div" style="display: none;">
                                    <div class="form-group">
                                        <label for="image" class="form-label"><strong>Image </strong></label>
                                        <input type="file" name="image" id="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('image'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                    </div>
                                    @if($woman_in_news->file_type == 'image' && !empty($woman_in_news->posts) && file_exists('public/images/uploads/newsPosts/'.$woman_in_news->posts))
                                        <div class="form-group mt-2">
                                            <img src="{{ asset('public/images/uploads/newsPosts/'.$woman_in_news->posts) }}" width="70" />
                                        </div>
                                    @endif
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn form_button">{{ trans('label.Update') }}</button>
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
