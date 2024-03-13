@extends('admin.layouts.admin-layout')

@section('title', 'Ask Your question')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.askquestion') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('userAskQuestion.index') }}">{{ trans('label.askquestion') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="{{ route('userAskQuestion.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.askquestion') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name"
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
                                    <div class="col-md-8 mb-3">
                                        <div class="form-group">
                                            <label for="user_question"
                                                class="form-label"><strong>{{ trans('label.askquestion') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="user_question" id="user_question" value="{{ old('user_question') }}"
                                                class="form-control {{ $errors->has('user_question') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('user_question'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('user_question') }}
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
