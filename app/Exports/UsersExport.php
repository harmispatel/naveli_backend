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

class UsersExport implements FromView, WithHeadings, WithEvents
{
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

        $query = User::query();

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

        $totalAgeGroupCount = $this->totalAgeGroupCount;

        // If start date and end date are the same, retrieve all users
        if ($this->startDate == $this->endDate) {
            $users = $query->where('id', '!=', 1)->get();

            // Total users
            $totalUsers = $users->count();

            //neow
            $totalNeow = $users->where('role_id', 2)->count();
            $neowFemale = $users->where('role_id', 2)->where('gender', 2)->count();
            $neowTrans = $users->where('role_id', 2)->where('gender', 3)->count();

            //buddy
            $totalBuddy = $users->where('role_id', 3)->count();
            $buddyMale = $users->where('role_id', 3)->where('gender', 1)->count();
            $buddyFemale = $users->where('role_id', 3)->where('gender', 2)->count();
            $buddyTrans = $users->where('role_id', 3)->where('gender', 3)->count();

            //CycleExplore
            $totalCycleExplore = $users->where('role_id', 4)->count();
            $cycleExploreMale = $users->where('role_id', 4)->where('gender', 1)->count();
            $cycleExploreFemale = $users->where('role_id', 4)->where('gender', 2)->count();
            $cycleExploreTrans = $users->where('role_id', 4)->where('gender', 3)->count();

            //totaluser gender wise
            $totalMale = $users->where('gender', 1)->count();
            $totalFemale = $users->where('gender', 2)->count();
            $totalTrans = $users->where('gender', 3)->count();

            //relationWise
            $total_solo = $users->where('relationship_status', 1)->count();
            $total_tied = $users->where('relationship_status', 2)->count();
            $total_ofs = $users->where('relationship_status', 3)->count();

        } else {
            $users = $query->where('id', '!=', 1)->whereBetween('created_at', [$this->startDate, $this->endDate])->get();

            // Total users
            $totalUsers = $users->count();

            //neow
            $totalNeow = $users->where('role_id', 2)->count();
            $neowFemale = $users->where('role_id', 2)->where('gender', 2)->count();
            $neowTrans = $users->where('role_id', 2)->where('gender', 3)->count();

            //buddy
            $totalBuddy = $users->where('role_id', 3)->count();
            $buddyMale = $users->where('role_id', 3)->where('gender', 1)->count();
            $buddyFemale = $users->where('role_id', 3)->where('gender', 2)->count();
            $buddyTrans = $users->where('role_id', 3)->where('gender', 3)->count();

            //CycleExplore
            $totalCycleExplore = $users->where('role_id', 4)->count();
            $cycleExploreMale = $users->where('role_id', 4)->where('gender', 1)->count();
            $cycleExploreFemale = $users->where('role_id', 4)->where('gender', 2)->count();
            $cycleExploreTrans = $users->where('role_id', 4)->where('gender', 3)->count();

            //totaluser gender wise
            $totalMale = $users->where('gender', 1)->count();
            $totalFemale = $users->where('gender', 2)->count();
            $totalTrans = $users->where('gender', 2)->count();

            //relationWise
            $total_solo = $users->where('relationship_status', 1)->count();
            $total_tied = $users->where('relationship_status', 2)->count();
            $total_ofs = $users->where('relationship_status', 3)->count();
        }

        return view('admin.exports.users', [
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

            //totaluser gender wise
            'totalMale' => $totalMale,
            'totalFemale' => $totalFemale,
            'totalTrans' => $totalTrans,

            //relationWise
            'total_solo' => $total_solo,
            'total_tied' => $total_tied,
            'total_ofs' => $total_ofs,

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
                // Customize row 4
                $event->sheet->getColumnDimension('A')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('B')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('C')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('D')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('E')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('F')->setWidth(20); // Adjust the width as needed

                $event->sheet->getRowDimension(4)->setRowHeight(20); // Adjust the height as needed
                $event->sheet->getRowDimension(10)->setRowHeight(20);
                $event->sheet->getRowDimension(15)->setRowHeight(20);
                $event->sheet->getRowDimension(20)->setRowHeight(20);
                $event->sheet->getStyle('C1:D1')->getFont()->setBold(true);
                $event->sheet->getStyle('C1:D1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A6:B6:')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C6:D6')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E6:F6')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A7:B7')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C7:D7')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E7:F7')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C8:D8')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E8:F8')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C15:F15')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C10:D13')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C15:D18')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A20:F24')->getAlignment()->setHorizontal('center');
                
             

                // Get the value from cell A10
                $dataA10 = $event->sheet->getCell('A10')->getValue();
                $dataA15 = $event->sheet->getCell('A15')->getValue();

                // Set the value "hello" to cells B10 and C10
                $event->sheet->setCellValue('C10', $dataA10);
                $event->sheet->setCellValue('C15', $dataA15);

                // Merge cells B10:C10 and D10:E10
                $event->sheet->mergeCells('C10:D10');
                $event->sheet->mergeCells('C15:D15');
           
                $event->sheet->setCellValue('C1', $event->sheet->getCell('A1')->getValue());
                $event->sheet->setCellValue('C2', $event->sheet->getCell('A2')->getValue());
                $event->sheet->setCellValue('D1', $event->sheet->getCell('B1')->getValue());
                $event->sheet->setCellValue('D2', $event->sheet->getCell('B2')->getValue());

                $event->sheet->setCellValue('C11', $event->sheet->getCell('A11')->getValue());
                $event->sheet->setCellValue('C12', $event->sheet->getCell('A12')->getValue());
                $event->sheet->setCellValue('C13', $event->sheet->getCell('A13')->getValue());

                $event->sheet->setCellValue('D11', $event->sheet->getCell('B11')->getValue());
                $event->sheet->setCellValue('D12', $event->sheet->getCell('B12')->getValue());
                $event->sheet->setCellValue('D13', $event->sheet->getCell('B13')->getValue());

                $event->sheet->setCellValue('C16', $event->sheet->getCell('A16')->getValue());
                $event->sheet->setCellValue('C17', $event->sheet->getCell('A17')->getValue());
                $event->sheet->setCellValue('C18', $event->sheet->getCell('A18')->getValue());

                $event->sheet->setCellValue('D16', $event->sheet->getCell('B16')->getValue());
                $event->sheet->setCellValue('D17', $event->sheet->getCell('B17')->getValue());
                $event->sheet->setCellValue('D18', $event->sheet->getCell('B18')->getValue());
                
                $event->sheet->setCellValue('A1', '');
                $event->sheet->setCellValue('A2', '');  
                $event->sheet->setCellValue('B1', '');
                $event->sheet->setCellValue('B2', '');
                $event->sheet->setCellValue('A10', '');
                $event->sheet->setCellValue('A11', '');
                $event->sheet->setCellValue('A12', '');
                $event->sheet->setCellValue('A13', '');
                $event->sheet->setCellValue('B11', '');
                $event->sheet->setCellValue('B12', '');
                $event->sheet->setCellValue('B13', '');

                $event->sheet->setCellValue('A15', '');
                $event->sheet->setCellValue('A16', '');
                $event->sheet->setCellValue('A17', '');
                $event->sheet->setCellValue('A18', '');
                $event->sheet->setCellValue('B16', '');
                $event->sheet->setCellValue('B17', '');
                $event->sheet->setCellValue('B18', '');
                

                $event->sheet->getStyle('D1:D2')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('B5:B8')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('B5:B8')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);
                $event->sheet->getStyle('D5:D8')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

               

                $event->sheet->getStyle('C16:C18')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A6:A8')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C6:C8')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);
                $event->sheet->getStyle('E6:E8')->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thin
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A6:F8')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A20:F24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C15:D15')->applyFromArray([
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

              
            


                $event->sheet->getStyle('C10:D13')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);


                $event->sheet->getStyle('C10:C13')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C15:D18')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C10:D10')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('D10')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('D2')->applyFromArray([
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
           

            
            
            

                $event->sheet->getStyle('C1:D1')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C1:D1')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #B9EBFF
                        ],
                    ],
                ]);

        

                $event->sheet->getStyle('A4:F5')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #B9EBFF
                        ],
                    ],
                ]);

            
                $event->sheet->getStyle('C10:D10')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #B9EBFF
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C15:D15')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #B9EBFF
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A20:F21')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'cfd5dc', // Background color #B9EBFF
                        ],
                    ],
                ]);


                $event->sheet->getStyle('A4:F5')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C2:D2')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A4:F4')->getFont()->setBold(true);
                $event->sheet->getStyle('A10:D10')->getFont()->setBold(true);
                $event->sheet->getStyle('C15:D15')->getFont()->setBold(true);
                $event->sheet->getStyle('A20:F20')->getFont()->setBold(true);
               

                $event->sheet->getStyle('A5:F5')->applyFromArray([
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

              

                $event->sheet->getStyle('A4:F5')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A20:F20')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A21:F21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A21:A24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('B21:B24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C21:C24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('D21:D24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('E21:E24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);

                $event->sheet->getStyle('F21:F24')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Set border style to thick
                            'color' => ['argb' => 'FF000000'], // Set border color (black)
                        ],
                    ],
                ]);
                // You can add more customization as needed
            },
        ];
    }
}
