@extends('admin.layouts.admin-layout')

@section('title', 'Question')

@section('content')

    @php
        $roles = getRoleList();
    @endphp

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
                        <li class="breadcrumb-item active">{{ trans('label.create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('question.store') }} " method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.Question') }}</h2>
                            </div>
                            <div class="form_box_info csm_que">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="questionType_id"
                                                class="form-label"><strong>{{ trans('label.questionType') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <select type="text" name="questionType_id" id="questionType_id"
                                                class="form-control">
                                                <option value="">-- Select Question Type --</option>
                                                @foreach ($questionTypes as $questionType)
                                                    <option value="{{ $questionType->id }}"
                                                        {{ old('questionType_id') == $questionType->id ? 'selected' : '' }}>
                                                        {{ $questionType->name_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="questionType_id_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="ageHide" style="display: none">
                                        <div class="form-group">
                                            <label for="age_group_id"
                                                class="form-label"><strong>{{ trans('label.ageType') }}</strong></label>
                                            <select type="text" name="age_group_id" id="age_group_id"
                                                class="form-control">
                                                <option value="">-- Select Age Type --</option>
                                                @foreach ($ageTypes as $ageType)
                                                    <option value="{{ $ageType->id }}"
                                                        {{ old('age_group_id') == $ageType->id ? 'selected' : '' }}>
                                                        {{ $ageType->name }} Year
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="question_name"
                                                class="form-label"><strong>{{ trans('label.question_name') }} (EN)</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="question_name_en" id="question_name_en"
                                                value="{{ old('question_name_en') }}"
                                                class="form-control">
                                            <div id="question_name_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 additional-info text-end">
                                        <a href="" class="btn btn-sm new-category custom-btn" id="addOption"><i
                                                class="bi bi-plus-lg"></i></a>
                                    </div>
                                    <div class="col-md-6 additional-info">
                                        <div class="form-group">
                                            <label for="option_name"
                                                class="form-label"><strong>{{ trans('label.option_name') }} (EN)</strong></label>
                                            <input type="text" name="option_name[]" id="option_name1"
                                                class="form-control" />
                                                <div id="option_name1_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 additional-info">
                                        <div class="form-group">
                                            <label for="option_name"
                                                class="form-label"><strong>{{ trans('label.option_name') }} (EN)</strong></label>
                                            <input type="text" name="option_name[]" id="option_name2"
                                                class="form-control" />
                                                <div id="option_name2_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row appending_div">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn form_button">{{ trans('label.Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('page-js')

    <script>
        // // question option 
        // $(document).ready(function() {
        //     // Attach a change event listener to the radio buttons
        //     $('.is-available-radio').change(function() {
        //         // Get the selected value
        //         var selectedValue = $(this).val();

        //         // Show or hide the additional-info div based on the selected value
        //         if (selectedValue == 1) {
        //             $('.additional-info').show();
        //         } else {
        //             $('.additional-info').hide();
        //         }
        //     });
        // });


        // **  multiple option_name  **

        $(document).ready(function() {
            var optionIndex = 2; // Start index from 1

            $('#addOption').on('click', function(e) {
                e.preventDefault();

                var field = '<div class="col-md-6 added-option align-content-center">' +
                    '<div class="row align-items-end">' +
                    '<div class="col-md-10 additional-info">' +
                    '<div class="form-group">' +
                    '<label for="option_name" class="form-label">' +
                    '<strong>{{ trans('label.option_name') }} (EN)</strong>' +
                    '</label>' +
                    '<input type="text" name="option_name[' + optionIndex + ']" class="form-control" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 additional-info">' +
                    '<div class="form-group">' +
                    '<button class="btn btn-sm  btn-danger cancel-option"><i class="bi bi-x" aria-hidden="true"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('.appending_div').append(field);

                optionIndex++; // Increment index for the next option
            });

            // Event delegation for the cancel button
            $('.appending_div').on('click', '.cancel-option', function(e) {
                e.preventDefault();

                // Hide only the specific row containing the "Option Name" and "Icon" fields
                $(this).closest('.added-option').remove();
            });
        
             $('#questionType_id').change(function (){
                   if($(this).val() == 3){
                    $('#addOption').hide();
                    $('#ageHide').show();
                   }else{
                    $('#ageHide').hide();
                    $('#addOption').show();
                   }
             });
        });


        // question_id and question_name required

        $(document).ready(function() {
            $('form').submit(function(e) {
                var questionType = $('#questionType_id').val().trim();
                var questionName = $('#question_name').val().trim();
                var optionName1 = $('#option_name1').val().trim();
                var optionName2 = $('#option_name2').val().trim();

                //questionType
                if (questionType === '') {
                    $('#questionType_id').addClass('is-invalid');
                    $('#questionType_id_error').text('Question Type is required.');
                    e.preventDefault();
                } else {
                    $('#questionType_id').removeClass('is-invalid');
                    $('#questionType_id_error').text('');
                }

                //questionName
                if (questionName === '') {
                    $('#question_name').addClass('is-invalid');
                    $('#question_name_error').text('Question Name is required.');
                    e.preventDefault();
                } else {
                    $('#question_name').removeClass('is-invalid');
                    $('#question_name_error').text('');
                }

                //optionName1
                if (optionName1 === '') {
                    $('#option_name1').addClass('is-invalid');
                    $('#option_name1_error').text('Option Name is required.');
                    e.preventDefault();
                } else {
                    $('#option_name1').removeClass('is-invalid');
                    $('#option_name1_error').text('');
                }

                //optionName2
                if (optionName2 === '') {
                    $('#option_name2').addClass('is-invalid');
                    $('#option_name2_error').text('Option Name is required.');
                    e.preventDefault();
                } else {
                    $('#option_name2').removeClass('is-invalid');
                    $('#option_name2_error').text('');
                }
            });
        });
    </script>

@endsection
