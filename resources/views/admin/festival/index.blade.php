@extends('admin.layouts.admin-layout')

@section('title', 'Festival')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.festival') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.festival') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="add_age_data text-end mb-3">
        <a href="{{ route('festival.create') }}" class="btn btn-sm new-category custom-btn">
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
                                    <h2>{{ trans('label.festival') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="FestivalTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.date') }}</th>
                                                    <th>{{ trans('label.festival_name') }}</th>
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
        $('#FestivalTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            pageLength: 50,
            ajax: "{{ route('festival.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'date',
                    name: 'date',
                    orderable: false
                },
                {
                    data: 'festival_name',
                    name: 'festival_name',
                    orderable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false
                }
            ]
        });
    </script>
@endsection
