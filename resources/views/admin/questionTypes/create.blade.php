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
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="{{ route('questionType.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.questionType') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="title"
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
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="media"
                                                class="form-label"><strong>{{ trans('label.icon') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="file" name="icon" id="icon" value="{{ old('icon') }}"
                                                class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('icon'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('icon') }}
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
        // $(document).ready(function() {
        //     $('#posts').change(function() {
        //         var fileExstenstion = $(this).val().split('.').pop().toLowerCase();

        //         if ($.inArray(fileExstenstion, ['mp4', 'avi', 'mov', 'mkv']) !== -1) {
        //             $('#file_type').val('video');
        //             $('.file_type').val('video');
        //         }
        //         else if($.inArray(fileExstenstion, ['jpg', 'jpeg', 'png', 'gif']) !== -1) {
        //             $('#file_type').val('image');
        //             $('.file_type').val('image');
        //         } else {
        //             $('#file_type').val('');
        //             $('.file_type').val('');
        //         }

        //         $('#file_type').prop('disabled', false);
        //     });
        // });
    </script>


@endsection
