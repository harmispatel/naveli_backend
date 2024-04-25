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
                        <li class="breadcrumb-item active">{{ trans('label.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('question.update') }} " method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="id" value="{{ encrypt($question->id) }}">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.Question') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="questionType_id"
                                                class="form-label"><strong>{{ trans('label.questionType') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="hidden" class="form-control" name="questionType_id"
                                                id="questionType_id" value="{{ $question->questionType_id }}">
                                            @if (isset($question->questionType_id))
                                                @foreach ($questionTypes as $questionType)
                                                    @if ($questionType->id == $question->questionType_id)
                                                        <input type="text" class="form-control"
                                                            value="{{ $questionType->name }}" readonly>
                                                    @endif
                                                @endforeach
                                            @endif

                                            {{-- <select type="text" name="questionType_id" id="cc"
                                                class="form-control {{ $errors->has('questionType_id') ? 'is-invalid' : '' }}" readonly>
                                                <option value="">-- Select Question Type</option>
                                                @foreach ($questionTypes as $questionType)
                                                    <option value="{{ $questionType->id }}"
                                                        {{ old('questionType_id', $question->questionType_id == $questionType->id) ? 'selected' : '' }}>
                                                        {{ $questionType->name }}   
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('questionType_id'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('questionType_id') }}
                                                </div>
                                            @endif --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="ageHide" style="display: none">
                                        <div class="form-group">
                                            <label for="age_group_id"
                                                class="form-label"><strong>{{ trans('label.ageType') }}</strong></label>
                                            <input type="hidden" class="form-control" name="age_group_id" id="age_group_id"
                                                value="{{ $question->age_group_id }}">
                                            @if (isset($question->age_group_id))
                                                @foreach ($ageTypes as $ageType)
                                                    @if ($ageType->id == $question->age_group_id)
                                                        <input type="text" class="form-control"
                                                            value="{{ $ageType->name }}" readonly>
                                                    @endif
                                                @endforeach
                                            @endif
                                            {{-- <select type="text" name="age_group_id" id="age_group_id"
                                                class="form-control" readonly>
                                                <option value="">-- Select Age Type --</option>
                                                @foreach ($ageTypes as $ageType)
                                                    <option value="{{ $ageType->id }}"
                                                        {{ old('age_group_id', $question->age_group_id == $ageType->id) ? 'selected' : '' }}>
                                                        {{ $ageType->name }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="question_name"
                                                class="form-label"><strong>{{ trans('label.question_name') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="question_name" id="question_name"
                                                value="{{ old('question_name', $question->question_name) }}"
                                                class="form-control {{ $errors->has('question_name') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('question_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('question_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3 additional-info text-end">
                                        {{-- <a class="btn btn-sm new-category custom-btn" id="addOption"><i
                                                class="bi bi-plus-lg"></i></a> --}}
                                    </div>
                                    {{-- <div class="row"> --}}
                                        <!-- Populate options -->
                                        @foreach ($options as $option)
                                            <div class="col-md-6">
                                                {{-- <div class="row align-items-end added-option"> --}}
                                                    <!-- Populate option_name and icon if they exist in your Option model -->
                                                    {{-- <div class="col-md-12 mb-3 additional-info"> --}}
                                                        <label for="option_name"
                                                            class="form-label"><strong>{{ trans('label.option_name') }}</strong></label>
                                                        <input type="text" name="option_name[]" id="option_name1"
                                                            value="{{ $option->option_name }}" class="form-control"
                                                            readonly />
                                                        <div id="option_name1_error" class="invalid-feedback"></div>
                                                    {{-- </div> --}}
                                                    {{-- <div class="col-md-2 mb-3 pt-2 additional-info">
                                                        <button class="btn btn-sm btn-danger cancel-option"
                                                            onclick="removeOption(this)"><i class="bi bi-trash"
                                                                aria-hidden="true"></i></button>
                                                    </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                        @endforeach
                                    {{-- </div> --}}
                                    <div class="appending_div row"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn form_button">{{ trans('label.Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('page-js')

    <script>
        // question option 
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

        //add buttons

        $(document).ready(function() {
            $('#addOption').on('click', function(e) {
                e.preventDefault();

                var field = '<div class="col-md-6 added-option align-content-center">' +
                    '<div class="row  align-items-end">' +
                    '<div class="col-md-10 mb-3 additional-info">' +
                    '<div class="form-group">' +
                    '<label for="option_name" class="form-label">' +
                    '<strong>{{ trans('label.option_name') }}</strong>' +
                    '</label>' +
                    '<input type="text" name="option_name[]" class="form-control" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 mb-3 pt-2 additional-info">' +
                    '<div class="form-group">' +
                    '<button class="btn btn-sm  btn-danger cancel-option"><i class="bi bi-trash" aria-hidden="true"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('.appending_div').append(field);
            });

            // Event delegation for the cancel button
            $('.appending_div').on('click', '.cancel-option', function(e) {
                e.preventDefault();

                // Hide only the specific row containing the "Option Name" and "Icon" fields
                $(this).closest('.added-option').remove();
            });

            if ($('#questionType_id').val() == 3) {
                $('#ageHide').show();
            }
            $('#questionType_id').change(function() {
                if ($(this).val() == 3) {
                    $('#ageHide').show();
                } else {
                    $('#ageHide').hide();
                }
            });
        });

        // remove line
        function removeOption(button) {
            // Get the parent div of the clicked button and remove it
            $(button).closest('.added-option').remove();
        }

        // question_id and question_name required

        $('form').submit(function(e) {
            var filledFields = 0;

            // Loop through each input field
            $('input[name="option_name[]"]').each(function() {
                if ($(this).val() !== '') {
                    filledFields++;
                }
            });

            // Check if at least two fields are filled
            if (filledFields < 2) {
                e.preventDefault(); // Prevent form submission
                alert('Please fill out at least two fields.');
            }
        });
    </script>

@endsection
