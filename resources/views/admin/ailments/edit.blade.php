@extends('admin.layouts.admin-layout')

@section('title', 'Ailments Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.ailments') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('ailments.index') }}">{{ trans('label.ailments_group') }}</a> </li>
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
                    <form class="form" action="{{ route('ailments.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ encrypt($ailments->id) }}">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.ailments_group') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{ trans('label.Name') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        value="{{ $ailments->name }}"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
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
    </section>


@endsection

@section('page-js')

    <script></script>


@endsection
