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

class UserAgeGroupExport implements FromView, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public $startDate;
    public $endDate;
    public $userCount;

    public function __construct($startDate, $endDate, $userCount, $ageGroupName,
        $ageTotalNeow, $ageNeowFemale, $ageNeowTrans,
        $ageTotalBuddy, $ageBuddyMale, $ageBuddyFemale, $ageBuddyTrans,
        $ageTotalExplore, $ageExploreMale, $ageExploreFemale, $ageExploreTrans, $totalAgeGroupCount) {

        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userCount = $userCount;
        $this->ageGroupName = $ageGroupName;

        //neow
        $this->ageTotalNeow = $ageTotalNeow;
        $this->ageNeowFemale = $ageNeowFemale;
        $this->ageNeowTrans = $ageNeowTrans;

        //buddy
        $this->ageTotalBuddy = $ageTotalBuddy;
        $this->ageBuddyMale = $ageBuddyMale;
        $this->ageBuddyFemale = $ageBuddyFemale;
        $this->ageBuddyTrans = $ageBuddyTrans;

        //Explore
        $this->ageTotalExplore = $ageTotalExplore;
        $this->ageExploreMale = $ageExploreMale;
        $this->ageExploreFemale = $ageExploreFemale;
        $this->ageExploreTrans = $ageExploreTrans;

        //totalAgeGroupCount
        $this->totalAgeGroupCount = $totalAgeGroupCount;

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

        //ageGroup
        $ageGroupName = $this->ageGroupName;

        //neow
        $ageTotalNeow = $this->ageTotalNeow;
        $ageNeowFemale = $this->ageNeowFemale;
        $ageNeowTrans = $this->ageNeowTrans;

        //buddy
        $ageTotalBuddy = $this->ageTotalBuddy;
        $ageBuddyMale = $this->ageBuddyMale;
        $ageBuddyFemale = $this->ageBuddyFemale;
        $ageBuddyTrans = $this->ageBuddyTrans;

        //Explore
        $ageTotalExplore = $this->ageTotalExplore;
        $ageExploreMale = $this->ageExploreMale;
        $ageExploreFemale = $this->ageExploreFemale;
        $ageExploreTrans = $this->ageExploreTrans;

        //totalAgeGroupCount
        $totalAgeGroupCount = $this->totalAgeGroupCount;

        return view('admin.exports.usersAgeGroup', [
            'startDate' => $startDate,
            'endDate' => $endDate,
          
            //ageGroup
            'ageGroupName' => $ageGroupName,

            //ageGroup neow
            'ageTotalNeow' => $ageTotalNeow,
            'ageNeowFemale' => $ageNeowFemale,
            'ageNeowTrans' => $ageNeowTrans,

            //ageGroup Buddy
            'ageTotalBuddy' => $ageTotalBuddy,
            'ageBuddyMale' => $ageBuddyMale,
            'ageBuddyFemale' => $ageBuddyFemale,
            'ageBuddyTrans' => $ageBuddyTrans,

            //ageGroup Explore
            'ageTotalExplore' => $ageTotalExplore,
            'ageExploreMale' => $ageExploreMale,
            'ageExploreFemale' => $ageExploreFemale,
            'ageExploreTrans' => $ageExploreTrans,

            //totalAgeGroupCount
            'totalAgeGroupCount' => $totalAgeGroupCount,

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

                $event->sheet->getStyle('A4:F4')->getFont()->setBold(true);

                $event->sheet->getStyle('A4:F8')->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('A4:F8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A4:F4')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A5:F5')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A5:A8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('B5:B8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C5:C8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('D5:D8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('E5:E8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('F5:F8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A4:F5')->applyFromArray([
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
