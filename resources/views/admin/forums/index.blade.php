@extends('admin.layouts.admin-layout')

@section('title', 'Forums Group')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.forums') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.forums') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="add_news_data text-end mb-3">
        <a href="{{ route('forums.create') }}" class="btn btn-sm new-category custom-btn">
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
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <select class="form-control mt-2" id="option_view_filter">
                                            <option value="">{{ trans('label.view_forums_category_wise') }}</option>
                                            @foreach ( $forum_categories as $forum_category)
                                            <option value="{{$forum_category->id}}">{{ $forum_category->name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>{{ trans('label.forums') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="ForumTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.forums_category') }}</th>
                                                    <th>{{ trans('label.forums_subcategory') }}</th>
                                                    <th>{{ trans('label.title') }}</th>
                                                    <th>{{ trans('label.description')}}</th>
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

            var table = $('#ForumTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax:{
                    url : "{{ route('forums.index') }}",
                    data : function(d) {
                        d.category_filter = $('#option_view_filter').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name:'id',
                    },
                    {
                        data: 'forums_category',
                        name: 'forums_category',
                    },
                    {
                        data: 'forums_subcategory',
                        name: 'forums_subcategory',
                    },
                    {
                        data: 'title',
                        name: 'title',
                        searchable: false,
                        orderable:false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        searchable: false,
                        orderable:false,
                    },
                    {

                        data : 'actions',
                        name : 'actions',
                        searchable: false,
                        orderable:false,
                    }
                ]
            });

            $('#option_view_filter').change(function() {
               table.draw();
            });

        });

        // Function for Delete Table
        function deleteUsers(forumId) {
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
                            url: '{{ route('forums.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': forumId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                     //    toastr.success(response.message);
                                     swal(response.message, "", "success");
                                    $('#ForumTable').DataTable().ajax.reload();
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
