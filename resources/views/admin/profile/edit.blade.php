@extends('admin.layouts.admin-layout')

@section('title', 'Edit User-Profile')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{trans('label.profile')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{trans('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active">{{trans('label.profile')}}</li>
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
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{trans('label.User_Details')}}</h2>
                                    </div>
                                  
                                    <div class="form_box_info">
                                        <div class="row">
                                            <input type="hidden" name="id" id="id" value="{{ encrypt($data->id) }}">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{trans('label.Name')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="name" value="{{isset($data->name) ? $data->name : old('name')}}" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter First Name">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">{{trans('label.email')}}<span class="text-danger">*</span></label>
                                                    <input type="email" name="email" value="{{isset($data->email) ? $data->email : old('email')}}" id="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" placeholder="Enter Email">
                                                    @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">{{trans('label.password')}}</label>
                                                    <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Enter Password">
                                                    @if ($errors->has('password'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="confirm_password" class="form-label">{{trans('label.Confirm_Password')}}</label>
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : ''}}" placeholder="Enter Confirm Password">
                                                    @if ($errors->has('confirm_password'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('confirm_password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="role_id" class="form-label">{{trans('label.User_Role')}}<span class="text-danger">*</span></label>
                                                <input type="text" value="{{ isset($roles->name) ? $roles->name : ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{trans('label.User')}}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form_group">
                                                    <label for="image" class="form-label">{{trans('label.image')}}<span class="text-danger">*</span></label>
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                                    <div class="mt-2">
                                                        @if($data->image)
                                                        <img src="{{ asset('public/images/uploads/user_images/' . $data->image) }}"
                                                            alt="" width="100" height="100">
                                                            @else
                                                            <img src="{{asset('public/images/uploads/user_images/no-image.png')}}" alt="" width="100" height="100">
                                                        @endif
                                                    </div>
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
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">{{trans('label.Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
