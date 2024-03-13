@extends('admin.layouts.admin-layout')

@section('title', 'D A S H B O A R D')

@section('content')

<div class="pagetitle">
    <h1>{{ trans('label.dashboard')}}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">{{ trans('label.dashboard')}}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        @if (session()->has('errors'))
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')  }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-center">Profile Image</h5>
                            <div class="text-center">
                                <img src="{{asset('public/images/uploads/user_images/'.auth()->user()->image)}}"
                                    class="img-fluid rounded-circle" style="max-height: 150px;">
                                <br><br>
                                <strong>{{auth()->user()->name}}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{ route('users') }}" style="text-decoration: none; color: inherit;">
                                <h5 class="card-title text-center">Users</h5>
                                <div class="text-center">
                                    <img src="{{ asset('public/admin_images/userlogo.png') }}"
                                        class="img-fluid rounded-circle" style="max-height: 118px;">
                                    <br><br>
                                    <h1>{{ $users_count }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-center">Hy...Naveli..</h5>
                            <div class="text-center">
                                <img src="{{asset('public/admin_images/17.png')}}" class="img-fluid"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-center">Can You Filling Greety.. Our Periods Time ?</h5>
                            <div class="text-center">
                                <img src="{{asset('public/admin_images/14.png')}}" class="img-fluid"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-center">You Can Follow Our Suggesion !!</h5>
                            <div class="text-center">
                                <img src="{{asset('public/admin_images/18.png')}}" class="img-fluid"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-center">You Can Feel Big Change In Our Life</h5>
                            <div class="text-center">
                                <img src="{{asset('public/admin_images/16 (1).png')}}" class="img-fluid"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
