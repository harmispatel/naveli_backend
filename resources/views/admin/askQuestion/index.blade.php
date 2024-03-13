@extends('admin.layouts.admin-layout')

@section('title', 'Ask Your question')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.askquestion') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.askquestion') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    {{-- <div class="add_age_data text-end mb-3">
         <a href="{{ route('userAskQuestion.create') }}" class="btn btn-sm new-category custom-btn">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div> --}}
    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>{{ trans('label.askquestion') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="AskQuestionTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.username') }}</th>
                                                    <th>{{ trans('label.userquestion') }}</th>
                                                    <th>{{ trans('label.adminanswer')}}</th>
                                                    <th>{{ trans('label.media')}}</th>
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

            var table = $('#AskQuestionTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: "{{ route('userAskQuestion.index') }}",
                columns: [
                    {
                        data: 'id',
                        name:'id',
                        'searchable': false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'user_question',
                        name: 'user_question',
                        orderable: false,
                        searchable:false
                    },
                    {
                        data: 'question_answer',
                        name: 'question_answer',
                        orderable: false,
                        searchable:false
                    },
                    {
                        data: 'file_type',
                        name: 'file_type',
                        orderable: false,
                        searchable:false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable:false
                    },
                ]
            });
        });
    </script>
@endsection
