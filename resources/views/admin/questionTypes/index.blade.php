@extends('admin.layouts.admin-layout')

@section('title', 'Question Types')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.questionType') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.questionType') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="add_news_data text-end mb-3">
        <a href="{{ route('questionType.create') }}" class="btn btn-sm new-category custom-btn">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>
    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>{{ trans('label.questionType') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="QuestionTypeTable"
                                            aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.Name') }}</th>
                                                    <th>{{ trans('label.icon') }}</th>
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

            var table = $('#QuestionTypeTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: "{{ route('questionType.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        searchable: false
                    },
                    {
                        data: 'name_en',
                        name: 'name_en'
                    },
                    {
                        data: 'icon',
                        name: 'icon',
                        orderable: false,
                        searchable: false
                    },
                    {

                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        });

        // Function for Delete Table
        function deleteUsers(questionTypeId) {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDeleteUsers) => {
                    if (willDeleteUsers) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('questionType.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': questionTypeId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                    // toastr.success(response.message);
                                    swal(response.message, "", "success");
                                    $('#QuestionTypeTable').DataTable().ajax.reload();
                                } else {
                                    swal(response.message, "", "error");
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        }
    </script>
@endsection
