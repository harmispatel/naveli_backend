@extends('admin.layouts.admin-layout')

@section('title', 'Posts Section')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.posts') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.posts') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="add_age_data text-end mb-3">
        <a href="{{ route('posts.create') }}" class="btn btn-sm new-category custom-btn">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>
    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                        <div class="form_box">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <select class="form-control mt-2" id="option_view_filter">
                                            <option value="">{{ trans('label.view_posts_category_wise') }}</option>
                                            <option value="1">{{ trans('label.do_you_know') }}</option>
                                            <option value="2">{{ trans('label.myth_vs_facts') }}</option>
                                            <!-- <option value="3">{{ trans('label.all_about_periods') }}</option> -->
                                            <option value="4">{{ trans('label.nutrition') }}</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>Posts Listing</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="PostsTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.posts_category') }}</th>
                                                    <th>{{ trans('label.file_type')}}</th>
                                                    <th>{{ trans('label.description') }}</th>
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

            var table = $('#PostsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax:{
                    url : "{{ route('posts.index') }}",
                    data : function(d) {
                        d.parent_title_filter = $('#option_view_filter').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name:'id',
                        searchable: false
                    },
                    {
                        data: 'posts_category',
                        name: 'posts_category',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'file_type',
                        name: 'file_type',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'description',
                        name: 'description',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#option_view_filter').change(function() {
               table.draw();
           });

        });

        // Function for Delete Table
        function deleteUsers(postId) {
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
                            url: '{{ route('posts.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': postId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                    // toastr.success(response.message);
                                    swal(response.message, "", "success");
                                    $('#PostsTable').DataTable().ajax.reload();
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
