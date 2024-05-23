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
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <select class="form-control mt-2" id="option_view_filter">
                                            <option value="">{{ trans('label.view_healthmix_category_wise') }}</option>
                                            <option value="1" >Expert Advice</option>
                                            <option value="2" >Cycle Wisdom</option>
                                            <option value="3" >Groove With Neow</option>
                                            <option value="4" >Celebs Speak</option>
                                            <option value="5" >Testimonials</option>
                                            <option value="6" >Fun Corner</option>
                                            <option value="8" >Empowher</option>
                                        </select>
                                    </div>
                                </div>
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
                ajax:{
                    url : "{{ route('healthMix.index') }}",
                    data : function(d) {
                        d.healthmix_type_filter = $('#option_view_filter').val();
                    }
                },
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
                        data: 'description_en',
                        name: 'description_en',
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

            $('#option_view_filter').change(function() {
               table.draw();
            });


        });

        // Function for Delete Table
        function deleteUsers(healthMixId) {
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
                            url: '{{ route('healthMix.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': healthMixId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success == 1) {
                                    // toastr.success(response.message);
                                    swal(response.message, "", "success");
                                    $('#healthTable').DataTable().ajax.reload();
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
