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

class UserNBCExport implements FromView, WithHeadings, WithEvents
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

            // Total users
            $totalUsers = $users->count();

            //neow
            $totalNeow = $users->where('role_id', 2)->count();
            $neowFemale = $users->where('role_id', 2)->where('gender', 2)->count();
            $neowTrans = $users->where('role_id', 2)->whereIn('gender', [3, 4])->count();

            //buddy
            $totalBuddy = $users->where('role_id', 3)->count();
            $buddyMale = $users->where('role_id', 3)->where('gender', 1)->count();
            $buddyFemale = $users->where('role_id', 3)->where('gender', 2)->count();
            $buddyTrans = $users->where('role_id', 3)->whereIn('gender', [3, 4])->count();

            //CycleExplore
            $totalCycleExplore = $users->where('role_id', 4)->count();
            $cycleExploreMale = $users->where('role_id', 4)->where('gender', 1)->count();
            $cycleExploreFemale = $users->where('role_id', 4)->where('gender', 2)->count();
            $cycleExploreTrans = $users->where('role_id', 4)->whereIn('gender', [3, 4])->count();

        } else {
            $users = $query->where('id', '!=', 1)->whereBetween('created_at', [$this->startDate, $this->endDate])->get();

            // Total users
            $totalUsers = $users->count();

            //neow
            $totalNeow = $users->where('role_id', 2)->count();
            $neowFemale = $users->where('role_id', 2)->where('gender', 2)->count();
            $neowTrans = $users->where('role_id', 2)->whereIn('gender', [3, 4])->count();

            //buddy
            $totalBuddy = $users->where('role_id', 3)->count();
            $buddyMale = $users->where('role_id', 3)->where('gender', 1)->count();
            $buddyFemale = $users->where('role_id', 3)->where('gender', 2)->count();
            $buddyTrans = $users->where('role_id', 3)->whereIn('gender', [3, 4])->count();

            //CycleExplore
            $totalCycleExplore = $users->where('role_id', 4)->count();
            $cycleExploreMale = $users->where('role_id', 4)->where('gender', 1)->count();
            $cycleExploreFemale = $users->where('role_id', 4)->where('gender', 2)->count();
            $cycleExploreTrans = $users->where('role_id', 4)->whereIn('gender', [3, 4])->count();

        }

        return view('admin.exports.usersNBC', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalUsers' => $totalUsers,

            //neow
            'totalNeow' => $totalNeow,
            'neowFemale' => $neowFemale,
            'neowTrans' => $neowTrans,

            //buddy
            'totalBuddy' => $totalBuddy,
            'buddyMale' => $buddyMale,
            'buddyFemale' => $buddyFemale,
            'buddyTrans' => $buddyTrans,

            //cycle Explore
            'totalCycleExplore' => $totalCycleExplore,
            'cycleExploreMale' => $cycleExploreMale,
            'cycleExploreFemale' => $cycleExploreFemale,
            'cycleExploreTrans' => $cycleExploreTrans,

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

                $event->sheet->getStyle('C1:D1')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C2:D2')->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('A4:F4')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:F8')->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('A4:F5')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #cfd5dc
                        ],
                    ],
                ]);

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

            },
        ];
    }
}
