<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UserGenderExport implements FromView, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public $startDate;
    public $endDate;
    public $userCount;

    public function __construct($startDate, $endDate, $userCount)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userCount = $userCount;
    }

    public function view(): View
    {
        if($this->startDate == $this->endDate){
            $startDate = 'All';
            $endDate = 'All';
        }else{
           $startDate = $this->startDate;
           $endDate = $this->endDate; 
        }

        $query = User::query();

        // If start date and end date are the same, retrieve all users
        if ($this->startDate == $this->endDate) {
            $users = $query->where('id', '!=', 1)->get();

            //totaluser gender wise
            $totalMale = $users->where('gender', 1)->count();
            $totalFemale = $users->where('gender', 2)->count();
            $totalTrans = $users->where('gender', 3)->count();

            $total = $totalMale + $totalFemale + $totalTrans;
        } else {
            $users = $query->where('id', '!=', 1)->whereBetween('created_at', [$this->startDate, $this->endDate])->get();

            // Total users
            $totalUsers = $users->count();

         //totaluser gender wise
         $totalMale = $users->where('gender', 1)->count();
         $totalFemale = $users->where('gender', 2)->count();
         $totalTrans = $users->where('gender', 3)->count();

         $total = $totalMale + $totalFemale + $totalTrans;
        }

        return view('admin.exports.usersGender', [
            'startDate' => $startDate,
            'endDate' => $endDate,
           
            //totaluser gender wise
            'totalMale' => $totalMale,
            'totalFemale' => $totalFemale,
            'totalTrans' => $totalTrans,
            'total' => $total,

        ]);

    }

    public function headings(): array
    {
        // Define your column headings
        return [
            'Column A',
            'Column B',
            // Add more columns if needed
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Customize row 4
                $event->sheet->getColumnDimension('A')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('B')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('C')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('D')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('E')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('F')->setWidth(20); // Adjust the width as needed

                $event->sheet->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getRowDimension(2)->setRowHeight(20);

                $event->sheet->setCellValue('C1', $event->sheet->getCell('A1')->getValue());
                $event->sheet->setCellValue('C2', $event->sheet->getCell('A2')->getValue());
                $event->sheet->setCellValue('D1', $event->sheet->getCell('B1')->getValue());
                $event->sheet->setCellValue('D2', $event->sheet->getCell('B2')->getValue());

                $event->sheet->setCellValue('A1', '');
                $event->sheet->setCellValue('A2', '');
                $event->sheet->setCellValue('B1', '');
                $event->sheet->setCellValue('B2', '');

                $event->sheet->getStyle('C1:D1')->getFont()->setBold(true);
                $event->sheet->getStyle('C1:D1')->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('C1:D1')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #cfd5dc
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C1:D1')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C1:D2')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C1:C2')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C2:D2')->getAlignment()->setHorizontal('center');

                $event->sheet->getRowDimension(4)->setRowHeight(20);       
                $event->sheet->getStyle('C4:D4')->getFont()->setBold(true);
                $event->sheet->setCellValue('C4', $event->sheet->getCell('A4')->getValue());
                $event->sheet->setCellValue('D4', $event->sheet->getCell('A4')->getValue());
                $event->sheet->setCellValue('C5', $event->sheet->getCell('A5')->getValue());
                $event->sheet->setCellValue('C6', $event->sheet->getCell('A6')->getValue());
                $event->sheet->setCellValue('C7', $event->sheet->getCell('A7')->getValue());
                $event->sheet->setCellValue('D5', $event->sheet->getCell('B5')->getValue());
                $event->sheet->setCellValue('D6', $event->sheet->getCell('B6')->getValue());
                $event->sheet->setCellValue('D7', $event->sheet->getCell('B7')->getValue());
               
              

                // Merge cells B10:C10 and D10:E10
                $event->sheet->mergeCells('C4:D4');
                $event->sheet->setCellValue('A4', '');
                $event->sheet->setCellValue('A5', '');
                $event->sheet->setCellValue('A6', '');
                $event->sheet->setCellValue('A7', '');
                $event->sheet->setCellValue('B5', '');
                $event->sheet->setCellValue('B6', '');
                $event->sheet->setCellValue('B7', '');

                $event->sheet->getStyle('C4:D7')->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('C4:D7')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C4:D4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C4:C7')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C4:D4')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #cfd5dc
                        ],
                    ],
                ]);

            },
        ];
    }
}
