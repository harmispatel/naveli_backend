@extends('admin.layouts.admin-layout')

@section('title', 'Festival')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.festival') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a href="{{ route('festival.index') }}">{{ trans('label.festival') }}</a> </li>
                      
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="{{ route('festival.store') }}" method="POST">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.festival') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="date" class="form-label"><strong>{{ trans('label.date') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="date" name="date"  id="date"
                                                value="{{ old('date') }}"
                                                class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('date'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('date') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="festival_name" class="form-label"><strong>{{ trans('label.festival_name') }} (EN)</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="festival_name" id="festival_name"
                                                value="{{ old('festival_name') }}"
                                                class="form-control {{ $errors->has('festival_name') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('festival_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('festival_name') }}
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
