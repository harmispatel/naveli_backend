@extends('admin.layouts.admin-layout')

@section('title', 'Forums Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.forums') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('forums.index') }}">{{ trans('label.forums_group') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row" id="form-pills">
                    <div class="col-md-12 mt-3">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('forums.edit', [encrypt($forumRecord->id), 'en']) }}" class="nav-link {{ ($def_locale == 'en') ? 'active' : '' }}" id="pills-en-tab">English</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('forums.edit', [encrypt($forumRecord->id), 'hi']) }}" class="nav-link {{ ($def_locale == 'hi') ? 'active' : '' }}" id="pills-hi-tab">Hindi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active">
                                <form class="form" action="{{ route('forums.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="language_code" id="language_code" value="{{ $def_locale }}">
                                    <input type="hidden" name="id" id="id" value="{{ encrypt($forumRecord->id) }}">

                                    <div class="form_box">
                                        <div class="form_box_inr">
                                            <div class="box_title">
                                                <h2>{{ trans('label.forums_group') }}</h2>
                                            </div>
                                            <div class="form_box_info">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                class="form-label"><strong>{{ trans('label.forums_category') }}</strong>
                                                                <span class="text-danger">*</span></label>
                                                            <select name="forums_category" id="forums_category" class="form-control {{ $errors->has('forums_category') ? 'is-invalid' : '' }}">
                                                                <option value="" >-- Select Category Type --</option>
                                                                @foreach ($mainCategories as $category)
                                                                <option value="{{$category->id}}" {{ $category->id == $forumRecord->forum_category_id ? 'selected' : '' }}>{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('forums_category'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('forums_category') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                class="form-label"><strong>{{ trans('label.forums_subcategory') }}</strong>
                                                                <span class="text-danger"></span></label>

                                                                <select name="forums_subcategory" id="forums_subcategory" class="form-control {{ $errors->has('forums_subcategory') ? 'is-invalid' : '' }}">
                                                                    @foreach ($childCategories as $category)
                                                                    <option value="{{$category->id}}" {{ $category->id == $forumRecord->forum_subcategory_id ? 'selected' : '' }}>{{$category->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('forums_subcategory'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('forums_subcategory') }}
                                                                    </div>
                                                                @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                class="form-label"><strong>{{ trans('label.title') }} <span class="text-uppercase">({{$def_locale}})</span></strong>
                                                                <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $forumRecord['title_'.$def_locale] }}"
                                                        name="title" id="title" placeholder="Enter Forums Title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
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
                                                                class="form-label"><strong>{{ trans('label.description') }} <span class="text-uppercase">({{$def_locale}})</span></strong>
                                                                <span class="text-danger"></span></label>
                                                            <textarea name="description" id="description" placeholder="Enter Forums Description (Optional)" rows="5"
                                                                class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $forumRecord['description_'.$def_locale] }}</textarea>
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
                                    <div class="card-footer text-center">
                                        <button class="btn form_button">{{ trans('label.Update') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>

@endsection


@section('page-js')
<script>

    // $(document).ready(function() {
    //     $('#forums_category').change(function() {
    //         var categoryId = $(this).val();
    //         var subcategoriesSelect = $('#forums_subcategory');
    //         subcategoriesSelect.empty();

    //         if (categoryId) {
    //             $.ajax({
    //                 url: '{{ route("forums.getsubcategory", ":categoryId") }}'.replace(':categoryId', categoryId),
    //                 type: 'GET',
    //                 dataType: 'json',
    //                 success: function(response) {
    //                     console.log(response);
    //                     if (response && response.length > 0) {
    //                         $('#forums_subcategory').show();
    //                         $.each(response, function(index, subcategory) {
    //                             subcategoriesSelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
    //                         });
    //                     } else {

    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.error(xhr.responseText);
    //                 }
    //             });
    //         } else {
    //             $('#forums_subcategory').hide();
    //         }
    //     });
    // });

    $(document).ready(function() {
    $('#forums_category').change(function() {
        var categoryId = $(this).val();
        var subcategoriesSelect = $('#forums_subcategory');
        subcategoriesSelect.empty();

        if (categoryId) {
            $.ajax({
                url: '{{ route("forums.getsubcategory", ":categoryId") }}'.replace(':categoryId', categoryId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response && response.length > 0) {
                        $('#forums_subcategory').show();
                        $.each(response, function(index, subcategory) {
                            subcategoriesSelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    } else {
                        // If no subcategories, show readable format
                        subcategoriesSelect.empty().append('<option value="">No subcategories available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            // If no parent category selected, show readable format
            subcategoriesSelect.empty().append('<option value="">Please select a parent category first</option>');
        }
    });
});

</script>
@endsection
