@extends('admin.layouts.admin-layout')
@section('title', 'All About Periods Posts')
@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.all_about_periods') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ trans('label.all_about_periods') }}</li>
                        <li class="breadcrumb-item active">{{ trans('label.posts') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="add_news_data text-end mb-3">
        <a href="{{ route('aap.posts.create') }}" class="btn btn-sm new-category custom-btn">
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
                                    <h2>{{ trans('label.all_about_periods') }} {{ trans('label.posts') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100" id="AllAboutPeriodPostsTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.forums_category') }}</th>
                                                    <th>{{ trans('label.icon') }}</th>
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

        $('#AllAboutPeriodPostsTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: "{{ route('aap.posts.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'category',
                    name: 'category',
                },
                {
                    data: 'icon',
                    name: 'icon',
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

    </script>
@endsection
