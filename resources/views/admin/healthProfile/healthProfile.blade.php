@extends('admin.layouts.admin-layout')
@section('title', 'Health Profile')
@section('content')

<div class="pagetitle">
    <h1>{{ trans('label.healthProfile') }}</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"> <a href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a>
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

    function format ( details ) {
        if(details.sr == 1 || details.sr == 2){
            var html = '';
            html += '<table class="table w-100">';
                html += '<tr>';
                    html += '<td>Solo Normal : '+details.solo_normal+'<br> Solo Irregular : '+details.solo_irregular+'</td>';
                    html += '<td>Tied Normal : '+details.tied_normal+' <br> Tied Irregular : '+details.tied_irregular+'</td>';
                    html += '<td>OFS Normal : '+details.ofs_normal+' <br> OFS Irregular : '+details.ofs_irregular+'</td>';
                    html += '<td>Total Normal : '+details.total_normal+' <br> Total Irregular : '+details.total_irregular+'</td>';
                html += '</tr>';
            html += '</table>';
            return html;
        }else{
            var html = '';
            html += '<table class="table w-100">';
                html += '<tr>';
                    html += '<td class="text-center"><strong>Day 1</strong></td>';
                    html += '<td class="text-center"><strong>Day 2</strong></td>';
                    html += '<td class="text-center"><strong>Day 3</strong></td>';
                html += '</tr>';
                html += '<tr>';
                    html += '<td class="text-center">Almost Never : '+details.day_1_almost_never+' <br> Almost Always : 0 <br> None : 0</td>';
                    html += '<td class="text-center">Almost Never : 0 <br> Almost Always : 0 <br> None : 0</td>';
                    html += '<td class="text-center">Almost Never : 0 <br> Almost Always : 0 <br> None : 0</td>';
                html += '</tr>';
            html += '</table>';
            return html;
        }
    }

    var healthProfileTable =  $('#healthProfile').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging : false,
        info: false,
        ajax: "{{ route('healthProfile.load') }}",
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

    var detailRows = [];

    $('#healthProfile tbody').on( 'click', 'tr td:first-child', function () {
        var tr = $(this).parents('tr');
        var row = healthProfileTable.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            if(row.data()){
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();

                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        }
    } );

    healthProfileTable.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td:first-child').trigger( 'click' );
        } );
    } );

</script>

@endsection
