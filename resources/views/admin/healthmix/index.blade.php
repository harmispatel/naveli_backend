@extends('admin.layouts.admin-layout')

@section('title', 'Health Group')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.HealthMix') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.healthmix_group') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="add_news_data text-end mb-3">
        <a href="{{ route('healthMix.create') }}" class="btn btn-sm new-category custom-btn">
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
                                    <h2>{{ trans('label.healthmix_group') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="healthTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.healthtype') }}</th>
                                                    <th>{{ trans('label.media_type') }}</th>
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

            var table = $('#healthTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: "{{ route('healthMix.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'health_type',
                        name: 'health_type',
                        'orderable': false, 
                    },
                    {
                        data: 'media_type',
                        name: 'media_type',
                        'orderable': false, 
                        'searchable': false
                    },
                    {
                        data: 'description',
                        name: 'description',
                        'orderable': false, 
                        'searchable': false
                    },
                    {

                        data : 'actions',
                        name : 'actions',
                        'orderable': false, 
                        'searchable': false
                    }
                ]
            });

        });
    </script>
@endsection
