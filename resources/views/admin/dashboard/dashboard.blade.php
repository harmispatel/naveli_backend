@extends('admin.layouts.admin-layout')

@section('title', 'D A S H B O A R D')

@section('content')

<div class="pagetitle">
    <h1>{{ trans('label.dashboard') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">{{ trans('label.dashboard') }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">

    @if (session()->has('errors'))
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <div class="form-group text-end">
                        <label for="daterange"><strong>Date Range</strong></label>
                        <input type="text" name="daterange" id="daterange" class="form-control"
                            value="01/01/2024 - 02/01/2024" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Users - {{ $users_count }}</h5>
                    <!-- <a href="{{ route('users') }}" style="text-decoration: none; color: inherit;">
                        </a> -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Neow</h5>
                                    <h3>{{ $total_neow }}</h3>
                                    <div class="p-3 text-start">
                                        <li>
                                            Neow Female : {{ $total_neow_female}}
                                        </li>
                                        <li>
                                            Neow Transgender : {{ $total_neow_trans}}
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Buddy</h5>
                                    <h3>{{ $total_buddy }}</h3>
                                    <div class="p-3 text-start">
                                        <li>
                                            Buddy Male : {{ $total_buddy_male}}
                                        </li>
                                        <li>
                                            Buddy Female : {{ $total_buddy_female}}
                                        </li>
                                        <li>
                                            Buddy Transgender : {{ $total_buddy_trans}}
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Cycle Explorer</h5>
                                    <h3>{{ $total_cycleExplorer }}</h3>
                                    <div class="p-3 text-start">
                                        <li>
                                            Cycle-Explorer Male : {{ $total_cycleExplorer_male}}
                                        </li>
                                        <li>
                                            Cycle-Explorer Female : {{ $total_cycleExplorer_female}}
                                        </li>
                                        <li>
                                            Cycle-Explorer Transgender : {{ $total_cycleExplorer_trans}}
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Users(Gender Wise)</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Total Male</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_male }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Total Female</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_female }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Total Trans.</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_trans }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Users(Relation Wise)</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Solo</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_solo }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Tied</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_tied }}</h1>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">OFS</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_ofs }}</h1>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Active Users</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Total Male</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_neow_female }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Total Female</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_neow_female }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Total Trans.</h5>
                                    <div class="text-center">
                                        <h1>{{ $total_neow_trans }}</h1>
                                        <br>
                                        <!-- <strong>{{ auth()->user()->name }}</strong> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Age Groups</h5>
                    <select name="selectBox" id="selectBox" class="form-control w-50 mb-5"
                        onchange="getCount(this.value)">
                        <option value="0">-- select age groups --</option>
                        <option value="all">All</option>
                        @foreach ($age_groups as $age_group)
                        <option value="{{$age_group->id}}">{{$age_group->name}}</option>
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Neow</h5>
                                    <h3>{{ $total_neow }}</h3>
                                    <div class="p-3 text-start">
                                        <li>
                                            Neow Female : <span class="totalCount"></span>
                                        </li>
                                        <li>
                                            Neow Transgender : <span class="totalTransCount"></span>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Buddy</h5>
                                    <h3>{{ $total_buddy }}</h3>
                                    <div class="p-3 text-start">
                                        <li>
                                            Buddy Male : {{ $total_buddy_male}}
                                        </li>
                                        <li>
                                            Buddy Female : {{ $total_buddy_female}}
                                        </li>
                                        <li>
                                            Buddy Transgender : {{ $total_buddy_trans}}
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Cycle Explorer</h5>
                                    <h3>{{ $total_cycleExplorer }}</h3>
                                    <div class="p-3 text-start">
                                        <li>
                                            Cycle-Explorer Male : {{ $total_cycleExplorer_male}}
                                        </li>
                                        <li>
                                            Cycle-Explorer Female : {{ $total_cycleExplorer_female}}
                                        </li>
                                        <li>
                                            Cycle-Explorer Transgender : {{ $total_cycleExplorer_trans}}
                                        </li>
                                    </div>
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


@section('page-js')
<script>
function getCount(ageGroupId) {

    if (ageGroupId) {

        $.ajax({
            url: '{{ route("users.count", ":ageGroupId") }}'.replace(':ageGroupId', ageGroupId),
            type: 'GET',
            success: function(response) {

                // Update the total count dynamically
                $('.totalCount').text(response.totalCount);
                $('.totalFemaleCount').text(response.totalFemaleCount);
                $('.totalTransCount').text(response.totalTransCount);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
}
</script>
<script>
 $(function() {
    $('#daterange').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        var startDate = start.format('YYYY-MM-DD');
        var endDate = end.format('YYYY-MM-DD');

        // Make AJAX request
        $.ajax({
            url: '{{ route("dashboard") }}', // Replace with your route name
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                // Handle success response
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });
    });
});

</script>

@endsection