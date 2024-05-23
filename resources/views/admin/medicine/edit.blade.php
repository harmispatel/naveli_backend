@extends('admin.layouts.admin-layout')

@section('title', 'Medicine Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.Medicine') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('medicine.index') }}">{{ trans('label.Medicine_group') }}</a> </li>
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
                    <div class="card-body">
                        <div class="row" id="form-pills">
                            <div class="col-md-12 mt-3">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="{{ route('medicine.edit', [encrypt($medicine->id), 'en']) }}" class="nav-link {{ ($def_locale == 'en') ? 'active' : '' }}" id="pills-en-tab">English</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="{{ route('medicine.edit', [encrypt($medicine->id), 'hi']) }}" class="nav-link {{ ($def_locale == 'hi') ? 'active' : '' }}" id="pills-hi-tab">Hindi</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active">
                                        <form class="form" action="{{ route('medicine.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ encrypt($medicine->id) }}">
                                            <input type="hidden" name="language_code" id="language_code" value="{{ $def_locale }}">
                                            <div class="form_box">
                                                <div class="form_box_inr">
                                                    <div class="box_title">
                                                        <h2>{{ trans('label.Medicine_group') }}</h2>
                                                    </div>
                                                    <div class="form_box_info">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="form-label">
                                                                        <strong>{{ trans('label.Name') }}
                                                                            <span class="text-uppercase">({{$def_locale}})</span>
                                                                        </strong>
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    <input type="text" name="{{ 'name_' . $def_locale }}" id="{{ 'name_' . $def_locale }}"
                                                                        value="{{ old('name_' . $def_locale , $medicine['name_' . $def_locale]) }}"
                                                                        class="form-control @error('name_' . $def_locale) is-invalid @enderror">
                                                                        @error('name_' . $def_locale)
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                        @enderror
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

    <script></script>


@endsection
