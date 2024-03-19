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
                            <input type="text" name="daterange" id="daterange" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-center">Total Users - <span class="users_count"></span></h5>
                        <!-- <a href="{{ route('users') }}" style="text-decoration: none; color: inherit;">
                                        </a> -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Total Neow</h5>
                                        <h3 class="total_neow"></h3>
                                        <div class="p-3 text-start">
                                            <li>
                                                Neow Female : <span class="total_neow_female"></span>
                                            </li>
                                            <li>
                                                Neow Transgender : <span class="total_neow_trans"></span>
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
                                                Buddy Male : <span class="total_buddy_male"></span>
                                            </li>
                                            <li>
                                                Buddy Female : <span class="total_buddy_female"></span>
                                            </li>
                                            <li>
                                                Buddy Transgender : <span class="total_buddy_trans"></span>
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
                                                Cycle-Explorer Male : <span class="total_cycleExplorer_male"></span>
                                            </li>
                                            <li>
                                                Cycle-Explorer Female : <span class="total_cycleExplorer_female"></span>
                                            </li>
                                            <li>
                                                Cycle-Explorer Transgender : <span class="total_cycleExplorer_trans"></span>
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
                        <h5 class="card-title text-center">Total Users(Relation Wise)</h5>
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
                        <h5 class="card-title text-center">Total Active Users</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Total Male</h5>
                                        <div class="text-center">
                                            <h1>0</h1>
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
                                            <h1>0</h1>
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
                                            <h1>0</h1>
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
                        <select name="selectBox" id="selectBox" class="form-control w-50 mb-5">
                            <option value="all" selected>All</option>
                            @foreach ($age_groups as $age_group)
                                <option value="{{ $age_group->id }}">{{ $age_group->name }}</option>
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

    </section>

@endsection


@section('page-js')
    {{-- <script>
        $(document).ready(function() {
            getCount('all'); // Call getCount function with 'all' as the default ageGroupId
        });

        function getCount(ageGroupId) {

            if (ageGroupId) {

                $.ajax({
                    url: '{{ route('users.count', ':ageGroupId') }}'.replace(':ageGroupId', ageGroupId),
                    type: 'GET',
                    success: function(response) {

                        // Update the total count Neow dynamically
                        $('.totalNeowCount').text(response.totalNeowCount);
                        $('.totalFemaleNeowCount').text(response.totalFemaleNeowCount);
                        $('.totalTransNeowCount').text(response.totalTransNeowCount);

                        // Update the total count Buddy dynamically
                        $('.totalBuddyCount').text(response.totalBuddyCount);
                        $('.totalMaleBuddyCount').text(response.totalMaleBuddyCount);
                        $('.totalFemaleBuddyCount').text(response.totalFemaleBuddyCount);
                        $('.totalTransBuddyCount').text(response.totalTransBuddyCount);

                        // Update the total count cycle Explorer dynamically
                        $('.totalExplorerCount').text(response.totalExplorerCount);
                        $('.totalMaleExplorerCount').text(response.totalMaleExplorerCount);
                        $('.totalFemaleExplorerCount').text(response.totalFemaleExplorerCount);
                        $('.totalTransExplorerCount').text(response.totalTransExplorerCount);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        $(function() {
            $('#daterange').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                var startDate = start.format('YYYY-MM-DD');
                var endDate = end.format('YYYY-MM-DD');

                // Make AJAX request
                $.ajax({
                    url: '{{ route('users.count','all') }}',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {

                    }
                });
            });
        });
    </script> --}}


    <script>
        // $(document).ready(function() {
        //     // Initialize date range picker
        //     $('#daterange').daterangepicker({
        //         opens: 'left'
        //     });

        //     // Event listener for age group selection change
        //     $('#selectBox').change(function() {
        //         var ageGroupId = $(this).val();
        //         var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

        //         // Trigger counting process when age group selection changes
        //         getCount(ageGroupId, startDate, endDate);
        //     });

        //     // Event listener for date range selection change
        //     $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        //         var ageGroupId = $('#selectBox').val();
        //         var startDate = picker.startDate.format('YYYY-MM-DD');
        //         var endDate = picker.endDate.format('YYYY-MM-DD');

        //         // Trigger counting process when date range selection changes
        //         getCount(ageGroupId, startDate, endDate);
        //     });
        // });

        $(document).ready(function() {
            // Calculate the start and end dates
            var endDate = moment(); // Current date
            var startDate = moment().subtract(1, 'month'); // One month ago

            // Initialize date range picker with the calculated dates
            $('#daterange').daterangepicker({
                opens: 'left',
                startDate: startDate,
                endDate: endDate
            });

            // Trigger counting process when page loads
            getCount('all', startDate, endDate);

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
        }
    </script>
@endsection
