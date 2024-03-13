@extends('admin.layouts.admin-layout')

@section('title', 'Question')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.Question') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('question.index') }}">{{ trans('label.Question') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.Question_option') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form_box">
                    <div class="form_box_inr">
                        <div class="box_title">
                            <h2>{{ trans('label.Question') }}</h2>
                        </div>
                        <div class="form_box_info">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="option_name"
                                                class="form-label"><strong>*  {{ $question->question_name }} ?</strong></label>
                                  
                                </div>
                                @foreach ($options as $option)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <!-- Populate option_name and icon if they exist in your Option model -->
                                            <label for="option_name"
                                                class="form-label"><strong>{{ trans('label.option_name') }}</strong></label>
                                            <input type="text" name="option_name[]" value="{{ $option->option_name }}"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
