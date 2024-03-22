<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('name','email','unique_id','birthdate','mobile','average_cycle_length','previous_periods_begin','previous_periods_month','average_period_length','hum_apke_he_kon')
        ->where('role_id','!=',1)->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Unique_id',
            'Birthdate',
            'Mobile',
            'Average_cycle_length',
            'Previous_periods_begin',
            'Previous_periods_month',
            'Average_period_length',
            'Hum_apke_he_kon'
        ];
    }

}
