<?php

namespace App\Exports;

use App\Models\Label;
use Maatwebsite\Excel\Concerns\FromCollection;

class LabelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Label::all();
    }
}
