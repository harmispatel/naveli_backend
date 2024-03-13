@extends('admin.layouts.admin-layout')

@section('title', 'Question Types')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.questionType') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('questionType.index') }}">{{ trans('label.questionType') }}</a> </li>
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
                    <form class="form" action="{{ route('questionType.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ encrypt($questionType->id) }}">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.questionType') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="Name"
                                                        class="form-label"><strong>{{ trans('label.Name') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" id="name"
                                                        value="{{ $questionType->name }}"
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
                                                    <label for="icon"
                                                        class="form-label"><strong>{{ trans('label.icon') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="file" name="icon" id="icon" value=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mt-3 pt-2">
                                                <div class="form-group">
                                                    <img style="height:50px; width:50px;"
                                                        src="{{ asset('/public/images/uploads/QuestionType/' . $questionType->icon) }}" />
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
