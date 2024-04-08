@extends('admin.layouts.admin-layout')

@section('title', 'Forum Comments Group')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.forum_comments') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.forum_comments') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <!-- <div class="add_news_data text-end mb-3">
        <a href="{{ route('forums.create') }}" class="btn btn-sm new-category custom-btn">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div> -->
    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>{{ trans('label.forum_comments_group') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="ForumCommentsTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.forum_title') }}</th>
                                                    <th>{{ trans('label.users') }}</th>
                                                    <th>{{ trans('label.comments')}}</th>
                                                    <th>{{ trans('label.admin_reply')}}</th>
                                                    <th>{{ trans('label.comment_time')}}</th>
                                                    <th>{{ trans('label.actions')}}</th>
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

            var table = $('#ForumCommentsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: "{{ route('forumcomments.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true,
                    },
                    {
                        data: 'forum_title',
                        name: 'forum_title',
                    },
                    {
                        data: 'user',
                        name: 'user',
                    },
                    {
                        data: 'comment',
                        name: 'comment',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'admin_reply',
                        name: 'admin_reply',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'comment_time',
                        name: 'comment_time'
                    },
                    {

                        data : 'actions',
                        name : 'actions',
                        searchable: false,
                        orderable:false,
                    }
                ]
            });
        });

        // Function for Delete Table
        function deleteUsers(forumCommentId) {
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
                            url: '{{ route('forumcomments.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': forumCommentId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                   //    toastr.success(response.message);
                                   swal(response.message, "", "success");
                                    $('#ForumCommentsTable').DataTable().ajax.reload();
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
