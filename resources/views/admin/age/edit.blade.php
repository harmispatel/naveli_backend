@extends('admin.layouts.admin-layout')

@section('title', 'Age Group')

@section('content')

  {{-- Page Title --}}
  <div class="pagetitle">
    <h1>{{trans('label.Age_Group')}}</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"> <a href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                    <li class="breadcrumb-item active"> <a href="{{ route('age.index') }}">{{ trans('label.Age_Group') }}</a> </li>
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
                    <form class="form" action="{{ route('age.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ encrypt($ageEdit->id) }}">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.Age_Group') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <div class="form-group">
                                                    <label for="min_age" class="form-label"><strong>{{ trans('label.Min_Age') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="min_age" min="0" id="min_age"
                                                        value="{{ $ageEdit->min_age }}"
                                                        class="form-control {{ $errors->has('min_age') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('min_age'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('min_age') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <div class="form-group">
                                                    <label for="max_age" class="form-label"><strong>{{ trans('label.Max_Age') }}</strong>
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="max_age" min="0" id="max_age"
                                                        value="{{ $ageEdit->max_age }}"
                                                        class="form-control {{ $errors->has('max_age') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('max_age'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('max_age') }}
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

    <script>
        //min age
        $(document).ready(function() {
            $('#min_age').on('input', function() {

                var inputVal = $(this).val().replace(/\D/g, '');
                $(this).val(inputVal);

                var minAge = $('#min_age').val();
                var maxAge = $('#max_age').val();

                // Check if minAge is greater than maxAge
                if (minAge !== '' && maxAge !== '' && parseInt(minAge) >= parseInt(maxAge)) {
                    // Display an error message
                    alert('Min Age should be less than or equal to Max Age');

                    // Clear the values of both fields
                    $('#min_age').val('');
                    $('#max_age').val('');
                }
            });
        });

        //max age
        $(document).ready(function() {
            $('#max_age').on('input', function() {
                var inputVal = $(this).val().replace(/\D/g, '');
                $(this).val(inputVal);
            });

            $('#max_age').change('input', function() {
                var minAge = $('#min_age').val();
                var maxAge = $('#max_age').val();

                // Check if minAge is greater than maxAge
                if (minAge !== '' && maxAge !== '' && parseInt(minAge) >= parseInt(maxAge)) {
                    // Display an error message
                    alert('Min Age should be less than or equal to Max Age');

                    // Clear the values of both fields
                    $('#min_age').val('');
                    $('#max_age').val('');
                }
            });
        });
    </script>


@endsection

