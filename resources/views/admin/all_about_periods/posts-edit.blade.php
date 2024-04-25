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
                    <li class="breadcrumb-item active"> <a
                            href="{{ route('aap.posts.index') }}">{{ trans('label.all_about_periods') }}</a> </li>
                    <li class="breadcrumb-item active">{{ trans('label.edit') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
{{-- Clients Card --}}
<div class="col-md-12">
    <div class="card">

        <form class="form" action="{{ route('aap.posts.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="form_box">
                    <div class="form_box_inr">
                        <div class="box_title">
                            <h2>{{ trans('label.all_about_periods') }} {{ trans('label.posts') }}</h2>
                        </div>
                        <div class="form_box_info">
                            <input type="hidden" name="id" value="{{encrypt($findedPost->id)}}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="title"
                                            class="form-label"><strong>{{ trans('label.forums_category') }}</strong><span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="category_name"
                                            class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}"
                                            value="{{ old('category_name') ?? $findedPost->category_name }}">
                                        @if ($errors->has('category_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category_name') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
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
                                        <div class="mt-2 text-end">
                                            @if ($findedPost->category_icon)
                                                <img src="{{ asset('public/images/uploads/all_about_periods/category_icons/' . $findedPost->category_icon) }}"
                                                    alt="" width="60" height="60">
                                            @else
                                                <img src="{{ asset('public/images/uploads/user_images/no-image.png') }}"
                                                    alt="" width="60" height="60">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @foreach($findedPost->media as $media)
                                    @php
                                        $allMediaStore[] = $media;
                                    @endphp
                                @endforeach
                                @if(isset($allMediaStore))
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="file_type"
                                            class="form-label"><strong>{{ trans('label.mediatype')}}</strong><span
                                                class="text-danger">*</span></label>
                                        <select name="file_types[]" id="file_type"
                                            class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }} ">
                                            <option value="link" {{ ($allMediaStore[0]->media_type == 'link') ? 'selected' : '' }}>Link</option>
                                            <option value="image" {{ ($allMediaStore[0]->media_type == 'image') ? 'selected' : '' }}>Image</option>
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
                                            placeholder="Enter Media Link" value="{{ ($allMediaStore[0]->media_type === 'link') ? $allMediaStore[0]->media : ''}}"
                                            class="form-control {{ $errors->has('media_link') ? 'is-invalid' : '' }} ">
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
                                            class="form-control {{ $errors->has('media_file') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('media_files'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('media_file') }}
                                        </div>
                                        @endif
                                        <div class="mt-2 text-end">
                                            @if ($allMediaStore[0]->media_type === 'image' )
                                                <img src="{{ asset('public/images/uploads/all_about_periods/posts_media/' . $allMediaStore[0]->media) }}"
                                                    alt="" width="60" height="60">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="description"
                                            class="form-label"><strong>{{ trans('label.description') }}</strong>
                                            <span class="text-danger">*</span></label>
                                        <textarea name="descriptions[]" id="description" rows="5"
                                            class="form-control {{ $errors->has('descriptions') ? 'is-invalid' : '' }}">{{$allMediaStore[0]->description ?? ''}}</textarea>
                                        @if ($errors->has('descriptions'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('descriptions') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
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


$(document).ready(function(){
    // Assuming `allMediaStore` is an array passed from PHP containing media data
    var allMediaStore = <?php echo isset($allMediaStore) ? json_encode($allMediaStore) : 0 ; ?>;
    var mediaCount = allMediaStore.length; // Get the number of media items

    if (mediaCount > 1) {
        // Start the loop from index 1 to skip the first media item
        for (var i = 1; i < mediaCount; i++) {
            var media = allMediaStore[i]; // Get the current media item
            var html = `
            <div class="row media-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="file_type" class="form-label"><strong>{{ trans('label.mediatype')}}</strong></label>
                        <select name="file_types[]" class="form-control file_type">
                            <option value="link" ${media.media_type === 'link' ? 'selected' : ''}>Link</option>
                            <option value="image" ${media.media_type === 'image' ? 'selected' : ''}>Image</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group linkInput" style="${media.media_type === 'link' ? 'display: block;' : 'display: none;'}">
                        <label for="media" class="form-label"><strong>{{ trans('label.enterlink')}}</strong></label>
                        <input type="text" name="media_links[]" class="form-control media_link" value="${media.media_type === 'link' ? media.media : ''}">
                    </div>
                    <div class="form-group posts" style="${media.media_type === 'image' ? 'display: block;' : 'display: none;'}">
                        <label for="media" class="form-label"><strong>{{ trans('label.media') }}</strong></label>
                        <input type="file" name="media_files[]" class="form-control media_file">
                        ${media.media_type === 'image' ? `<div class="mt-2 text-end">
                                <img src="{{ asset('public/images/uploads/all_about_periods/posts_media/') }}/${(media.media) ? media.media : ''}" alt="" width="60" height="60">
                            </div>` : ''}
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group descriptions">
                        <label for="description" class="form-label"><strong>{{ trans('label.description') }}</strong></label>
                        <textarea name="descriptions[]" id="description" rows="5" class="form-control">${((media.description) ? media.description : '' )}</textarea>
                    </div>
                </div>
                <div class="col-md-12 text-end mb-3">
                    <button type="button" class="btn btn-sm new-category btn-danger remove-media"><i class="bi bi-trash"></i></button>
                </div>
            </div>`;

            $('.media-container').append(html);
        }
    }
});




$(document).ready(function() {
    var media_type = $('#file_type :selected').val();
    if(media_type == 'link'){
        $('#linkInput').show();
        $('#mediaInput').hide();
    }else{
        $('#mediaInput').show();
        $('#linkInput').hide();
    }
});

$('#file_type').on('change', function () {
    if($(this).val() == 'link'){
        $('#linkInput').show();
        $('#mediaInput').hide();
    }else{
        $('#mediaInput').show();
        $('#linkInput').hide();
    }
});

$(document).ready(function() {
    // Event handler for adding new media
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
                        <label for="description" class="form-label"><strong>{{ trans('label.description') }}</strong></label>
                        <textarea name="descriptions[]" id="description" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-end mb-3">
                    <button type="button" class="btn btn-sm new-category btn-danger remove-media"><i class="bi bi-trash"></i></button>
                </div>
            </div>`;
        $('.media-container').append(html);
    });

    // Event handler for removing media
    $(document).on('click', '.remove-media', function() {
        $(this).closest('.media-row').remove();
    });

    // // Retrieve the stored HTML from localStorage when the document is ready
    // var storedHtml = localStorage.getItem('appendedHtml');
    // // If stored HTML exists, append it to the media container
    // if (storedHtml) {
    //     $('.media-container').append(storedHtml);
    // }

    // // Store the updated HTML in localStorage whenever a media row is added or removed
    // $(document).on('click', '#add-media, .remove-media', function() {
    //     localStorage.setItem('appendedHtml', $('.media-container').html());
    // });
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
