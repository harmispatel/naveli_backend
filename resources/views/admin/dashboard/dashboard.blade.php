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

        @if (auth()->user()->role_id == 1)
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="row justify-content-end">
                        <div class="col-md-1 text-end"> <!-- Adjusted this div -->
                            <div class="form-group  pt-4">
                                <a class="btn btn-sm btn-primary me-2" id="downloadButton"><i
                                        class="bi bi-download"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="daterange"><strong>Date Range</strong></label>
                                <input type="text" name="daterange" id="daterange" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div style="display: flex; justify-content: center;">
                                    <h5 class="card-title">Total Users - </h5>
                                    <h5 class="users_count ms-2 card-title" id="userCount"></h5>
                                    <a class="btn btn-sm btn-primary m-3" id="downloadusersButton"><i
                                            class="bi bi-download"></i></a>
                                </div>
                            </div>

                            <!-- <a href="{{ route('users') }}" style="text-decoration: none; color: inherit;"> </a> -->
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Neow</h5>
                                            <h3 class="total_neow"></h3>
                                            <div class="p-3 text-start">
                                                <li>
                                                    Female : <span class="total_neow_female"></span>
                                                </li>
                                                <li>
                                                    Transgender : <span class="total_neow_trans"></span>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Buddy</h5>
                                            <h3 class="total_buddy"></h3>
                                            <div class="p-3 text-start">
                                                <li>
                                                    Male : <span class="total_buddy_male"></span>
                                                </li>
                                                <li>
                                                    Female : <span class="total_buddy_female"></span>
                                                </li>
                                                <li>
                                                    Transgender : <span class="total_buddy_trans"></span>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Cycle Explorer</h5>
                                            <h3 class="total_cycleExplorer"></h3>
                                            <div class="p-3 text-start">
                                                <li>
                                                    Male : <span class="total_cycleExplorer_male"></span>
                                                </li>
                                                <li>
                                                    Female : <span class="total_cycleExplorer_female"></span>
                                                </li>
                                                <li>
                                                    Transgender : <span class="total_cycleExplorer_trans"></span>
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
                            <div class="d-flex justify-content align-items-center mb-3">
                                <h5 class="card-title text-center mb-0">Total Users(Gender Wise)</h5>
                                <a class="btn btn-sm btn-primary ms-3" id="downloadGenderUserButton"><i
                                        class="bi bi-download"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Total Male</h5>
                                            <div class="text-center">
                                                <h1 class="total_male"></h1>
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
                                                <h1 class="total_female"></h1>
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
                                                <h1 class="total_trans"></h1>
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
                            <div class="d-flex justify-content align-items-center mb-3">
                                <h5 class="card-title text-center mb-0">Total Users(Relation Wise)</h5>
                                <a class="btn btn-sm btn-primary ms-3" id="downloadRelationUserButton"><i
                                        class="bi bi-download"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Solo</h5>
                                            <div class="text-center">
                                                <h1 class="total_solo"></h1>
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
                                                <h1 class="total_tied"></h1>
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
                                                <h1 class="total_ofs"></h1>
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
                            <div style="display: flex; justify-content: center;">
                                <h5 class="card-title text-center">Total Active Users</h5>
                                <a class="btn btn-sm btn-primary m-3" id="downloadActiveUserButton"><i
                                        class="bi bi-download"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Total Male</h5>
                                            <div class="text-center">
                                                <h1 class="totalMaleActiveUsers"></h1>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Total Female</h5>
                                            <div class="text-center">
                                                <h1 class="totalFemaleActiveUsers"></h1>
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
                                                <h1 class="totalTransActiveUsers"></h1>
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
                            <div class="row">
                                <div style="display: flex;">
                                    <h5 class="card-title">Age Groups - </h5>
                                    <h5 class="card-title totalAgeGroupCount ms-2"></h5>
                                    <a class="btn btn-sm btn-primary m-3" id="downloadAgeGroupButton"><i
                                            class="bi bi-download"></i></a>
                                </div>
                            </div>
                            <select name="selectBox" id="selectBox" class="form-control w-50 mb-5">
                                <option value="all" selected>All</option>
                                @foreach ($age_groups as $age_group)
                                    <option value="{{ $age_group->id }}">{{ $age_group->name }} Year</option>
                                @endforeach
                            </select>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Neow</h5>
                                            <h3 class="totalNeowCount"></h3>
                                            <div class="p-3 text-start">
                                                <li>
                                                    Female : <span class="totalFemaleNeowCount"></span>
                                                </li>
                                                <li>
                                                    Transgender : <span class="totalTransNeowCount"></span>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Buddy</h5>
                                            <h3 class="totalBuddyCount"></h3>
                                            <div class="p-3 text-start">
                                                <li>
                                                    Male : <span class="totalMaleBuddyCount"></span>
                                                </li>
                                                <li>
                                                    Female : <span class="totalFemaleBuddyCount"></span>
                                                </li>
                                                <li>
                                                    Transgender : <span class="totalTransBuddyCount"></span>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Cycle Explorer</h5>
                                            <h3 class="totalExplorerCount"></h3>
                                            <div class="p-3 text-start">
                                                <li>
                                                    Male : <span class="totalMaleExplorerCount"></span>
                                                </li>
                                                <li>
                                                    Female : <span class="totalFemaleExplorerCount"></span>
                                                </li>
                                                <li>
                                                    Transgender : <span class="totalTransExplorerCount"></span>
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
        @endif

    </section>

@endsection


@section('page-js')

    <script>
        $(document).ready(function() {
            // Calculate the start and end dates
            var currentDate = moment(); // Current date

            // Initialize date range picker with the same start and end dates
            $('#daterange').daterangepicker({
                opens: 'left',
                startDate: currentDate,
                endDate: currentDate
            });

            // Trigger counting process when page loads
            getCount('all', currentDate, currentDate);

            // Event listener for age group selection change
            $('#selectBox').change(function() {
                var ageGroupId = $(this).val();
                var startDate = $('#daterange').data('daterangepicker').startDate;
                var endDate = $('#daterange').data('daterangepicker').endDate;

                // Trigger counting process when age group selection changes
                getCount(ageGroupId, startDate, endDate);
            });

            // Event listener for date range selection change
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                var ageGroupId = $('#selectBox').val();
                var startDate = picker.startDate;
                var endDate = picker.endDate;

                // Trigger counting process when date range selection changes
                getCount(ageGroupId, startDate, endDate);
            });

        });

        // Function to get count based on age group and date range
        function getCount(ageGroupId, startDate, endDate) {
            // Format the dates as YYYY-MM-DD
            var formattedStartDate = startDate.format('YYYY-MM-DD');
            var formattedEndDate = endDate.format('YYYY-MM-DD');

            // Call the server to get the counts based on the date range and age group
            $.ajax({
                url: '{{ route('users.count', ':ageGroupId') }}'.replace(':ageGroupId', ageGroupId),
                type: 'GET',
                data: {
                    age_group_id: ageGroupId,
                    start_date: formattedStartDate,
                    end_date: formattedEndDate
                },
                success: function(response) {
                    // Update counts based on the response
                    updateCounts(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Function to update counts
        function updateCounts(response) {
            // Update the total counts dynamically
            $('.users_count').text(response.users_count);
            $('.total_neow').text(response.total_neow);
            $('.total_buddy').text(response.total_buddy);
            $('.total_cycleExplorer').text(response.total_cycleExplorer);
            $('.total_male').text(response.total_male);
            $('.total_female').text(response.total_female);
            $('.total_trans').text(response.total_trans);
            $('.total_neow_female').text(response.total_neow_female);
            $('.total_neow_trans').text(response.total_neow_trans);
            $('.total_buddy_male').text(response.total_buddy_male);
            $('.total_buddy_female').text(response.total_buddy_female);
            $('.total_buddy_trans').text(response.total_buddy_trans);
            $('.total_cycleExplorer_male').text(response.total_cycleExplorer_male);
            $('.total_cycleExplorer_female').text(response.total_cycleExplorer_female);
            $('.total_cycleExplorer_trans').text(response.total_cycleExplorer_trans);
            $('.total_solo').text(response.total_solo);
            $('.total_tied').text(response.total_tied);
            $('.total_ofs').text(response.total_ofs);
            $('.totalNeowCount').text(response.totalNeowCount);
            $('.totalFemaleNeowCount').text(response.totalFemaleNeowCount);
            $('.totalTransNeowCount').text(response.totalTransNeowCount);
            $('.totalBuddyCount').text(response.totalBuddyCount);
            $('.totalMaleBuddyCount').text(response.totalMaleBuddyCount);
            $('.totalFemaleBuddyCount').text(response.totalFemaleBuddyCount);
            $('.totalTransBuddyCount').text(response.totalTransBuddyCount);
            $('.totalExplorerCount').text(response.totalExplorerCount);
            $('.totalMaleExplorerCount').text(response.totalMaleExplorerCount);
            $('.totalFemaleExplorerCount').text(response.totalFemaleExplorerCount);
            $('.totalTransExplorerCount').text(response.totalTransExplorerCount);
            $('.totalAgeGroupCount').text(response.totalAgeGroupCount);
            $('.totalMaleActiveUsers').text(response.totalMaleActiveUsers);
            $('.totalFemaleActiveUsers').text(response.totalFemaleActiveUsers);
            $('.totalTransActiveUsers').text(response.totalTransActiveUsers);

        }

        //dowload all data
        $(document).ready(function() {
            $('#downloadButton').click(function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var userCount = $('#userCount').text();
                var ageGroupId = $('#selectBox').val();
                //neow
                var ageTotalNeow = $('.totalNeowCount').text();
                var ageNeowFemale = $('.totalFemaleNeowCount').text();
                var ageNeowTrans = $('.totalTransNeowCount').text();
                //buddy
                var ageTotalBuddy = $('.totalBuddyCount').text();
                var ageBuddyMale = $('.totalMaleBuddyCount').text();
                var ageBuddyFemale = $('.totalFemaleBuddyCount').text();
                var ageBuddyTrans = $('.totalTransBuddyCount').text();
                //cycleExplore
                var ageTotalExplore = $('.totalExplorerCount').text();
                var ageExploreMale = $('.totalMaleExplorerCount').text();
                var ageExploreFemale = $('.totalFemaleExplorerCount').text();
                var ageExploreTrans = $('.totalTransExplorerCount').text();

                //TotalAgeCount
                var totalAgeGroupCount = $('.totalAgeGroupCount').text();

                $.ajax({
                    url: '{{ route('download.users') }}',
                    type: 'post',
                    cache: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_count: userCount,
                        ageGroupId: ageGroupId,

                        ageTotalNeow: ageTotalNeow,
                        ageNeowFemale: ageNeowFemale,
                        ageNeowTrans: ageNeowTrans,

                        ageTotalBuddy: ageTotalBuddy,
                        ageBuddyMale: ageBuddyMale,
                        ageBuddyFemale: ageBuddyFemale,
                        ageBuddyTrans: ageBuddyTrans,

                        ageTotalExplore: ageTotalExplore,
                        ageExploreMale: ageExploreMale,
                        ageExploreFemale: ageExploreFemale,
                        ageExploreTrans: ageExploreTrans,

                        totalAgeGroupCount: totalAgeGroupCount,

                    },
                    success: function(data) {

                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `users.xlsx`;
                        link.click();

                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
        });

        //dowload naveli,buddy,cycleExplore data
        $(document).ready(function() {
            $('#downloadusersButton').click(function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var userCount = $('#userCount').text();

                $.ajax({
                    url: '{{ route('download.usersNBC') }}',
                    type: 'post',
                    cache: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_count: userCount,

                    },
                    success: function(data) {

                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `usersNBC.xlsx`;
                        link.click();

                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
        });

        //dowload GenderWise data
        $(document).ready(function() {
            $('#downloadGenderUserButton').click(function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var userCount = $('#userCount').text();

                $.ajax({
                    url: '{{ route('download.usersGender') }}',
                    type: 'post',
                    cache: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_count: userCount,

                    },
                    success: function(data) {

                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `usersGender.xlsx`;
                        link.click();

                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
        });

        //dowload RelationWise data
        $(document).ready(function() {
            $('#downloadRelationUserButton').click(function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var userCount = $('#userCount').text();

                $.ajax({
                    url: '{{ route('download.usersRelation') }}',
                    type: 'post',
                    cache: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_count: userCount,

                    },
                    success: function(data) {

                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `usersRelation.xlsx`;
                        link.click();

                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
        });

        //dowload ActiveUser data
        $(document).ready(function() {
            $('#downloadActiveUserButton').click(function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var userCount = $('#userCount').text();

                $.ajax({
                    url: '{{ route('download.downloadActiveUsers') }}',
                    type: 'post',
                    cache: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_count: userCount,

                    },
                    success: function(data) {

                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `activeUsers.xlsx`;
                        link.click();

                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
        });

        //dowload AgeGroupTotalCount data
        $(document).ready(function() {
            $('#downloadAgeGroupButton').click(function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var userCount = $('#userCount').text();
                var ageGroupId = $('#selectBox').val();
                //neow
                var ageTotalNeow = $('.totalNeowCount').text();
                var ageNeowFemale = $('.totalFemaleNeowCount').text();
                var ageNeowTrans = $('.totalTransNeowCount').text();
                //buddy
                var ageTotalBuddy = $('.totalBuddyCount').text();
                var ageBuddyMale = $('.totalMaleBuddyCount').text();
                var ageBuddyFemale = $('.totalFemaleBuddyCount').text();
                var ageBuddyTrans = $('.totalTransBuddyCount').text();
                //cycleExplore
                var ageTotalExplore = $('.totalExplorerCount').text();
                var ageExploreMale = $('.totalMaleExplorerCount').text();
                var ageExploreFemale = $('.totalFemaleExplorerCount').text();
                var ageExploreTrans = $('.totalTransExplorerCount').text();

                //TotalAgeCount
                var totalAgeGroupCount = $('.totalAgeGroupCount').text();

                $.ajax({
                    url: '{{ route('download.usersAgeGroup') }}',
                    type: 'post',
                    cache: false,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_count: userCount,
                        ageGroupId: ageGroupId,

                        ageTotalNeow: ageTotalNeow,
                        ageNeowFemale: ageNeowFemale,
                        ageNeowTrans: ageNeowTrans,

                        ageTotalBuddy: ageTotalBuddy,
                        ageBuddyMale: ageBuddyMale,
                        ageBuddyFemale: ageBuddyFemale,
                        ageBuddyTrans: ageBuddyTrans,

                        ageTotalExplore: ageTotalExplore,
                        ageExploreMale: ageExploreMale,
                        ageExploreFemale: ageExploreFemale,
                        ageExploreTrans: ageExploreTrans,

                        totalAgeGroupCount: totalAgeGroupCount,

                    },
                    success: function(data) {

                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(data);
                        link.download = `usersAgeGroup.xlsx`;
                        link.click();

                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
        });
    </script>


@endsection
