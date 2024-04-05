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
    </div>

    <section class="section dashboard">
        <div class="row mb-3">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <select name="age_group" id="age_group" class="form-control">
                    <option value="">Filter By Age Group</option>
                    <option value="9-15">9 to 15 Years Old</option>
                    <option value="16-25">16 to 25 Years Old</option>
                    <option value="26-45">26 to 45 Years Old</option>
                    <option value="46-60">46 to 60 Years Old</option>
                    <option value="60">60+ Years Old</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="month" id="month-year" class="form-control">
            </div>
        </div>
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
                                        <table class="table w-100" id="healthProfile">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%"></th>
                                                    <th style="width: 10%">Sr.</th>
                                                    <th>Title</th>
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
        var detailRows = [];
        var healthProfileTable = null;

        $(document).ready(function() {
            getHealthData();
        });

        // Get Health Data Function
        function getHealthData(monthYear = null, ageGroup = null) {
            if (healthProfileTable !== null) {
                healthProfileTable.destroy();
            }

            healthProfileTable = $('#healthProfile').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ route('healthProfile.load') }}",
                    data: {
                        monthYear: monthYear,
                        ageGroup: ageGroup
                    }
                },
                columns: [{
                        "class": "details-control",
                        "orderable": false,
                        "data": null,
                        "defaultContent": ""
                    },
                    {
                        data: 'sr',
                        name: 'sr',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            healthProfileTable.on('draw', function() {
                $.each(detailRows, function(i, id) {
                    $('#' + id + ' td:first-child').trigger('click');
                });
            });
        }

        // Add Data when Click on Rows
        $('#healthProfile tbody').on('click', 'tr td:first-child', function() {
            var tr = $(this).parents('tr');
            var row = healthProfileTable.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice(idx, 1);
            } else {
                if (row.data()) {
                    tr.addClass('details');
                    row.child(format(row.data())).show();

                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
                }
            }
        });

        function format(details) {
            if (details.sr == 1 || details.sr == 2) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td>Solo Normal : ' + details.solo_normal +
                    '<br> <a target="_blank" href="{{ route('healthProfile.users', ['']) }}/' + details.solo_irregular[1] +
                    '">Solo Irregular : ' + details.solo_irregular[0] + '</a></td>';
                html += '<td>Tied Normal : ' + details.tied_normal +
                    ' <br> <a target="_blank" href="{{ route('healthProfile.users', ['']) }}/' + details.tied_irregular[1] +
                    '">Tied Irregular : ' + details.tied_irregular[0] + '</a></td>';
                html += '<td>OFS Normal : ' + details.ofs_normal +
                    ' <br> <a target="_blank" href="{{ route('healthProfile.users', ['']) }}/' + details.ofs_irregular[1] +
                    '">OFS Irregular : ' + details.ofs_irregular[0] + '</a></td>';
                html += '<td>Total Normal : ' + details.total_normal +
                    ' <br> <a target="_blank" href="{{ route('healthProfile.users', ['']) }}/' + details.total_irregular[
                    1] + '">Total Irregular : ' + details.total_irregular[0] + '</a></td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 3) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center">Almost Always : ' + details.day_1_almost_always + ' <br> Almost Never : ' +
                    details.day_1_almost_never + ' <br> None : ' + details.day_1_none + '</td>';
                html += '<td class="text-center">Almost Always : ' + details.day_2_almost_always + ' <br> Almost Never : ' +
                    details.day_2_almost_never + ' <br> None : ' + details.day_2_none + '</td>';
                html += '<td class="text-center">Almost Always : ' + details.day_3_almost_always + ' <br> Almost Never : ' +
                    details.day_3_almost_never + ' <br> None : ' + details.day_3_none + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 4) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center"><b>1</b> : ' + details.day_1_first + ' <br> <b>2-3</b> : ' + details
                    .day_1_second + ' <br> <b>4</b> : ' + details.day_1_third + '</td>';
                html += '<td class="text-center"><b>1</b> : ' + details.day_2_first + ' <br> <b>2-3</b> : ' + details
                    .day_2_second + ' <br> <b>4</b> : ' + details.day_2_third + '</td>';
                html += '<td class="text-center"><b>1</b> : ' + details.day_3_first + ' <br> <b>2-3</b> : ' + details
                    .day_3_second + ' <br> <b>4</b> : ' + details.day_3_third + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 5) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center">Hurts Little : ' + details.day_1_hurts_little + ' <br> Hurts More : ' +
                    details.day_1_hurts_more + ' <br> Hurts Worst : ' + details.day_1_hurts_worst + '</td>';
                html += '<td class="text-center">Hurts Little : ' + details.day_2_hurts_little + ' <br> Hurts More : ' +
                    details.day_2_hurts_more + ' <br> Hurts Worst : ' + details.day_2_hurts_worst + '</td>';
                html += '<td class="text-center">Hurts Little : ' + details.day_3_hurts_little + ' <br> Hurts More : ' +
                    details.day_3_hurts_more + ' <br> Hurts Worst : ' + details.day_3_hurts_worst + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 6) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center">Sanitary Pads : ' + details.day_1_pads + ' <br> Cloths : ' + details
                    .day_1_cloths + ' <br> Tampons : ' + details.day_1_tampons + ' <br> Cups : ' + details.day_1_cups +
                    '</td>';
                html += '<td class="text-center">Sanitary Pads : ' + details.day_2_pads + ' <br> Cloths : ' + details
                    .day_2_cloths + ' <br> Tampons : ' + details.day_2_tampons + ' <br> Cups : ' + details.day_2_cups +
                    '</td>';
                html += '<td class="text-center">Sanitary Pads : ' + details.day_3_pads + ' <br> Cloths : ' + details
                    .day_3_cloths + ' <br> Tampons : ' + details.day_3_tampons + ' <br> Cups : ' + details.day_3_cups +
                    '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 7) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center"><b>4</b> : ' + details.day_1_four_time + ' <br><b>3</b> : ' + details
                    .day_1_three_time + ' <br><b>2</b> : ' + details.day_1_two_time + ' <br><b>1</b> : ' + details
                    .day_1_one_time + '</td>';
                html += '<td class="text-center"><b>4</b> : ' + details.day_2_four_time + ' <br><b>3</b> : ' + details
                    .day_2_three_time + ' <br><b>2</b> : ' + details.day_2_two_time + ' <br><b>1</b> : ' + details
                    .day_2_one_time + '</td>';
                html += '<td class="text-center"><b>4</b> : ' + details.day_3_four_time + ' <br><b>3</b> : ' + details
                    .day_3_three_time + ' <br><b>2</b> : ' + details.day_3_two_time + ' <br><b>1</b> : ' + details
                    .day_3_one_time + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 8) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center">Relaxed : ' + details.day_1_relaxed + ' <br> Iritated : ' + details
                    .day_1_iritated + ' <br> Sad : ' + details.day_1_sad + '</td>';
                html += '<td class="text-center">Relaxed : ' + details.day_2_relaxed + ' <br> Iritated : ' + details
                    .day_2_iritated + ' <br> Sad : ' + details.day_2_sad + '</td>';
                html += '<td class="text-center">Relaxed : ' + details.day_3_relaxed + ' <br> Iritated : ' + details
                    .day_3_iritated + ' <br> Sad : ' + details.day_3_sad + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 9) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center">Lively : ' + details.day_1_lively + ' <br> Normal : ' + details
                    .day_1_normal + ' <br> Tired : ' + details.day_1_tired + '</td>';
                html += '<td class="text-center">Lively : ' + details.day_2_lively + ' <br> Normal : ' + details
                    .day_2_normal + ' <br> Tired : ' + details.day_2_tired + '</td>';
                html += '<td class="text-center">Lively : ' + details.day_3_lively + ' <br> Normal : ' + details
                    .day_3_normal + ' <br> Tired : ' + details.day_3_tired + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 10) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td class="text-center"><strong>Day 1</strong></td>';
                html += '<td class="text-center"><strong>Day 2</strong></td>';
                html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td class="text-center">Low : ' + details.day_1_low + ' <br> Moderate : ' + details
                    .day_1_moderate + ' <br> High : ' + details.day_1_high + '</td>';
                html += '<td class="text-center">Low : ' + details.day_2_low + ' <br> Moderate : ' + details
                    .day_2_moderate + ' <br> High : ' + details.day_2_high + '</td>';
                html += '<td class="text-center">Low : ' + details.day_3_low + ' <br> Moderate : ' + details
                    .day_3_moderate + ' <br> High : ' + details.day_3_high + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            } else if (details.sr == 11) {
                var html = '';
                html += '<table class="table w-100">';
                html += '<tr>';
                html += '<td>Severely Underweight : ' + details.bmi_severely_underweight + '</td>';
                html += '<td>Underweight : ' + details.bmi_underweight + '</td>';
                html += '<td>Normal Weight : ' + details.bmi_normal_weight + '</td>';
                html += '<td>Overweight : ' + details.bmi_over_weight + '</td>';
                html += '<td>Obese : ' + details.bmi_obese + '</td>';
                html += '<td>Total : ' + details.total_bmi + '</td>';
                html += '</tr>';
                html += '</table>';
                return html;
            }
        }

        // Month Year Filter
        $('#month-year').on('change', function() {
            getHealthData($(this).val(), $('#age_group :selected').val());
        });

        // Age Group Filter
        $('#age_group').on('change', function() {
            getHealthData($('#month-year').val(), $(this).val());
        });
    </script>

@endsection
