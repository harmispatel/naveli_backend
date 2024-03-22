@extends('admin.layouts.admin-layout')

@section('title', 'Question')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.Question') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.Question') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('question.create') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <select class="form-control" id="age_group_filter">
                                        <option value="">{{ trans('label.Select_Age') }}</option>
                                        @foreach ($ageGroups as $ageGroup)
                                            <option value="{{ $ageGroup->id }}">{{ $ageGroup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <select class="form-control" id="question_type_filter">
                                        <option value="">{{ trans('label.select_option_view_type') }}</option>
                                        @foreach ($questionTypes as $questionType)
                                            <option value="{{ $questionType->id }}">{{ $questionType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.Question') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="QuestionTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('label.Id') }}</th>
                                                        <th>{{ trans('label.question_name') }}</th>
                                                        <th>{{ trans('label.questionType') }}</th>
                                                        <th>{{ trans('label.ageType') }}</th>
                                                        <th>{{ trans('label.actions') }}</th>
                                                    </tr>
                                            </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection

{{-- Custom Script --}}
@section('page-js')

    <script type="text/javascript">
        $(function() {
            var table = $('#QuestionTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax:{
                    url : "{{ route('question.index') }}",
                    data : function(d) {
                        d.age_group_filter = $('#age_group_filter').val();
                        d.question_type_filter = $('#question_type_filter').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',

                    },
                    {
                        data: 'question_name',
                        name: 'question_name',

                    },
                    {
                        data: 'questionType_id',
                        name: 'questionType_id',


                    },
                    {
                        data: 'age_group_id',
                        name: 'age_group_id',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        'searchable': false,
                        'orderable': false,
                    },

                ]
            });

            $('#question_type_filter').change(function() {
               table.draw();
            });
            $('#age_group_filter').change(function() {
               table.draw();
            });
        });
    </script>
@endsection
