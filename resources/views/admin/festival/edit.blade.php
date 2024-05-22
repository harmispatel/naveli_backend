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
                        <li class="breadcrumb-item active">{{ trans('label.edit') }}</li>
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
                                <a href="{{ route('festival.edit', [encrypt($festival->id), 'en']) }}" class="nav-link {{ ($def_locale == 'en') ? 'active' : '' }}" id="pills-en-tab">English</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('festival.edit', [encrypt($festival->id), 'hi']) }}" class="nav-link {{ ($def_locale == 'hi') ? 'active' : '' }}" id="pills-hi-tab">Hindi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active">
                                <form class="form" action="{{ route('festival.update') }}" method="POST" id="festivalForm">
                                    @csrf
                                    <input type="hidden" name="language_code" id="language_code" value="{{ $def_locale }}">
                                    <input type="hidden" name="id" id="id" value="{{ encrypt($festival->id) }}">
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
                                                                value="{{ $festival->date }}"
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
                                                            <label for="festival_name" class="form-label"><strong>{{ trans('label.festival_name') }} <span class="text-uppercase">({{$def_locale}})</span></strong>
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" name="festival_name" id="festival_name"
                                                                value="{{ $festival['festival_name_'.$def_locale] }}"
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>                                                                                   
            <div class="card-footer text-center">
                <button class="btn form_button">{{ trans('label.Update') }}</button>
            </div>
        </div>
    </div>
    </div>
    </section>

@endsection


@section('page-js')
    <script>
        $('.form_button').on('click', function(){
            $('#festivalForm').submit();
        });
    </script>
@endsection
