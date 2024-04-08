@extends('admin.layouts.admin-layout')
@section('title', 'Women In News')
@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.news') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.news') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="add_news_data text-end mb-3">
        <a href="{{ route('woman-in-news.create') }}" class="btn btn-sm new-category custom-btn">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>{{ trans('label.news_group') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100" id="WomanInNewsTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.title') }}</th>
                                                    <th>{{ trans('label.description') }}</th>
                                                    <th>{{ trans('label.posts') }}</th>
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

        $('#WomanInNewsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: "{{ route('woman-in-news.load') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'title',
                    name: 'title',
                    orderable: false
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false,
                    searchable:false
                },
                {
                    data: 'post',
                    name: 'post',
                    orderable: false,
                    searchable:false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable:false,
                }
            ]
        });

        // Function for Delete Table
        function deleteUsers(womenInNewsId) {
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
                            url: '{{ route('woman-in-news.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': womenInNewsId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                     //    toastr.success(response.message);
                                     swal(response.message, "", "success");
                                    $('#WomanInNewsTable').DataTable().ajax.reload();
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
