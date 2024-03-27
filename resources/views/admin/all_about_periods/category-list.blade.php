@extends('admin.layouts.admin-layout')

@section('title', 'All About Periods Types')

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
                        <li class="breadcrumb-item active">{{ trans('label.forums_category') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="add_news_data text-end mb-3">
        <a href="{{ route('aap.category.create') }}" class="btn btn-sm new-category custom-btn">
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
                                    <h2>{{ trans('label.all_about_periods') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="AllAboutPeriodCategoryTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.Name') }}</th>
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
        $(function() {

            var table = $('#AllAboutPeriodCategoryTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{{ route('aap.category.index') }}",
                columns: [
                    { data: 'id',
                      name: 'id',
                      searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'icon',
                        name: 'icon',
                        orderable: false,
                        searchable:false
                    },
                    {

                        data : 'actions',
                        name : 'actions',
                        orderable: false,
                        searchable:false
                    }
                ]
            });

        });
    </script>
@endsection
