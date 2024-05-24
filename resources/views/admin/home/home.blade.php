@extends('admin.layouts.admin-layout')

@section('title', 'Home Page')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.home') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('label.home') }}</li>
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
                                <a href="{{ route('home.index','en') }}" class="nav-link {{ ($def_locale == 'en') ? 'active' : '' }}" id="pills-en-tab">English</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('home.index', 'hi') }}" class="nav-link {{ ($def_locale == 'hi') ? 'active' : '' }}" id="pills-hi-tab">Hindi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active">
                                <form class="form" action="{{ route('home.create') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="language_code" id="language_code" value="{{ $def_locale }}">
                                    <div class="form_box">
                                        <div class="form_box_inr">
                                            <div class="box_title">
                                                <h2>{{ trans('label.home') }}</h2>
                                            </div>
                                            <div class="form_box_info">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                class="form-label"><strong>{{ trans('label.title') }}</strong>
                                                                <span class="text-uppercase">({{$def_locale}})</span>
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" name="title" id="title"
                                                                value="{{ old('title' , $home['title_' . $def_locale]) }}"
                                                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                                            @if ($errors->has('title'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('title') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="link"
                                                                class="form-label"><strong>{{ trans('label.link') }}</strong><span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="link"
                                                                class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                                                                placeholder="Enter Media Link" value="{{ $home->link ?? '' }}" id="link">
                                                                <div id="linkError" class="text-danger"></div>
                                                            @if ($errors->has('link'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('link') }}
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
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>

@endsection

@section('page-js')

    <script>
        // Validate the link input when the form is submitted
        $('form').submit(function(e) {

            var linkValue = $('#link').val();
                var urlPattern =
                    /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|shorts\/)|youtu\.be\/)[\w-]+(\?\S*)?$/;
                if (!urlPattern.test(linkValue)) {
                    e.preventDefault(); // Prevent form submission
                    $('#linkError').html('Please enter a valid URL'); // Show error message
                }

        });
    </script>
@endsection
