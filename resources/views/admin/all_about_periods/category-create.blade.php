@extends('admin.layouts.admin-layout')

@section('title', 'All About Periods Types')

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
                        <li class="breadcrumb-item">{{ trans('label.all_about_periods') }}</li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('aap.category.index') }}">{{ trans('label.forums_category') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="{{ route('aap.category.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>Category Of {{ trans('label.all_about_periods') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="title"
                                                class="form-label"><strong>{{ trans('label.Name') }}</strong>
                                                <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="media"
                                                class="form-label"><strong>{{ trans('label.icon') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="file" name="icon" id="icon" value="{{ old('icon') }}"
                                                class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('icon'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('icon') }}
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
       
    </script>


@endsection
