<?php

namespace App\Exports;

use App\Models\{Label,Reproduction};
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;


class ExportLabels implements FromCollection, WithMapping, WithHeadings
{
        private $outer_data;

        // public function __construct($outer_data)
        // {
        //     $this->outer_data = $outer_data;
        // }
        public function collection()
        {
            return $this->outer_data;
        }
        public function map($labelsExport): array
        {
            // dd($labelsExport->labels->first()->name);
            return [
                $labelsExport->id,
                $labelsExport->labels->implode('labels', ', '),
                $labelsExport->job_completed,
            ];
        }
        public function headings():array
        {
            return[
                'Label_name',
                'Total_plays',
                'Song_count',
            ];
        }
        // return Label::all();
        // return Label::select('name')->with('songs')->get();
}
