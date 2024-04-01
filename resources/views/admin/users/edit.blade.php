@extends('admin.layouts.admin-layout')

@section('title', 'New Users')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.Users') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('users') }}">{{ trans('label.Users') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('label.User_Details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- New Category add Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.User_Details') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <input type="hidden" name="id" id="id"
                                                value="{{ encrypt($data->id) }}">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label"><strong>{{ trans('label.Name') }}</strong><span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name"
                                                        value="{{ isset($data->name) ? $data->name : old('name') }}"
                                                        id="name"
                                                        class="form-control"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="email"
                                                        class="form-label"><strong>{{ trans('label.email') }}</strong><span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" name="email"
                                                        value="{{ isset($data->email) ? $data->email : old('email') }}"
                                                        id="email"
                                                        class="form-control"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="role_id"
                                                    class="form-label"><strong>{{ trans('label.User_Role') }}</strong><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="role_id" name="role_id" class="form-control" value="{{ $roles->name }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.User_Image') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form_group">
                                                    <label for="image"
                                                        class="form-label"><strong>{{ trans('label.image') }}</strong><span
                                                            class="text-danger">*</span></label>
                                                    {{-- <input type="file" name="image"
                                                        class="form-control @error('image') is-invalid @enderror"> --}}
                                                    <div class="mt-2">
                                                        @if ($data->image)
                                                            <img src="{{ asset('public/images/uploads/user_images/' . $data->image) }}"
                                                                alt="" width="100" height="100">
                                                        @else
                                                            <img src="{{ asset('public/images/uploads/user_images/no-image.png') }}"
                                                                alt="" width="100" height="100">
                                                        @endif
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">{{ trans('label.Back') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
