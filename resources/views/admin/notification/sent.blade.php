@extends('admin.layouts.admin-layout')

@section('title', 'Age Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.Age_Group') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> {{ trans('label.notification') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="" >
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.notification') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="message"
                                                class="form-label"><strong>{{ trans('label.message') }}</strong></label>
                                            <textarea name="message" id="message" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="user_list"
                                                class="form-label"><strong>{{ trans('label.user_list') }}</strong></label>
                                            <select type="text" name="user_list[]" id="user_list"
                                                class="js-example-basic-multiple form-control" multiple="multiple">
                                                <option value="">{{ trans('label.Select_User') }}</option>
                                                @foreach ($userLists as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('user_list') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn form_button">{{ trans('label.Send') }}</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
    </section>

@endsection


@section('page-js')

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
