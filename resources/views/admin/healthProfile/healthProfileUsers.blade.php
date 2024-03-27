@extends('admin.layouts.admin-layout')
@section('title', 'Health Profile - Users')
@section('content')

<div class="pagetitle">
    <h1>Health Profile</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('healthProfile') }}">Health Profile</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section dashboard">
    <div class="row">
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
                                    <table class="table w-100 nowrap" id="healthProfileUsers">
                                        <thead>
                                            <tr>
                                                <th>UID</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Location</th>
                                                <th>Joined On</th>
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
    var healthProfileUsersTable = null;
    var user_ids = @json($user_ids);

    $(document).ready(function() {
        getHealthDataUsers(user_ids);
    });

    // Get Health Data Function
    function getHealthDataUsers(user_ids) {
        if (healthProfileUsersTable !== null) {
            healthProfileUsersTable.destroy();
        }
        healthProfileUsersTable = $('#healthProfileUsers').DataTable({
            processing: true
            , serverSide: true
            , ajax: {
                url: "{{ route('healthProfile.users.load') }}"
                , data: {
                    user_ids: user_ids
                , }
            }
            , columns: [{
                    data: 'uid'
                    , name: 'uid'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'name'
                    , name: 'name'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'age'
                    , name: 'age'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'phone'
                    , name: 'phone'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'email'
                    , name: 'email'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'gender'
                    , name: 'gender'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'location'
                    , name: 'location'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'joined_on'
                    , name: 'joined_on'
                    , orderable: false
                    , searchable: false
                }
            , ]
        });
    }

</script>

@endsection
