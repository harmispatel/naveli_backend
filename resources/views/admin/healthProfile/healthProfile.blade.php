@extends('admin.layouts.admin-layout')

@section('title', 'Health Profile')

@section('content')

    <div class="pagetitle">
        <h1>{{ trans('label.healthProfile') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('label.healthProfile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form_box">
                            <div class="form_box_inr">
                                <div class="box_title">
                                    <h2>{{ trans('label.healthProfile') }}</h2>
                                </div>
                                <div class="form_box_info">
                                    <div class="table-responsive">
                                        <table class="table w-100 dataTable no-footer" id="healthProfileTable" aria-describedby="UsersTable_info" style="width: 948px;">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('label.Id') }}</th>
                                                    <th>{{ trans('label.lengthcycle') }}</th>
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
