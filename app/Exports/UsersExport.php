<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Contracts\View\View;

class UsersExport implements FromView,WithHeadings, WithEvents
{
    use Exportable;

    public $startDate;
    public $endDate;
    public $userCount;

    public function __construct($startDate, $endDate, $userCount, $ageGroupName,
    $ageTotalNeow,$ageNeowFemale, $ageNeowTrans,
    $ageTotalBuddy,$ageBuddyMale, $ageBuddyFemale,$ageBuddyTrans,
    $ageTotalExplore,$ageExploreMale,$ageExploreFemale,$ageExploreTrans) {

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

    }

    
      public function view(): View
    {
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

        // If start date and end date are the same, retrieve all users
        if ($this->startDate == $this->endDate) {
            $users = $query->where('id', '!=', 1)->get();

            // Total users
            $totalUsers = $users->count();
            
            //neow
            $totalNeow = $users->where('role_id', 2)->count();
            $neowFemale = $users->where('role_id', 2)->where('gender',2)->count();
            $neowTrans = $users->where('role_id', 2)->where('gender',3)->count();

            //buddy
            $totalBuddy = $users->where('role_id', 3)->count();
            $buddyMale = $users->where('role_id', 3)->where('gender',1)->count();
            $buddyFemale = $users->where('role_id', 3)->where('gender',2)->count();
            $buddyTrans = $users->where('role_id', 3)->where('gender',3)->count();

            //CycleExplore
            $totalCycleExplore = $users->where('role_id', 4)->count();
            $cycleExploreMale = $users->where('role_id', 4)->where('gender',1)->count();
            $cycleExploreFemale = $users->where('role_id', 4)->where('gender',2)->count();
            $cycleExploreTrans = $users->where('role_id', 4)->where('gender',3)->count();

            //totaluser gender wise
            $totalMale = $users->where('gender',1)->count();
            $totalFemale = $users->where('gender',2)->count();
            $totalTrans = $users->where('gender',3)->count();

            //relationWise
            $total_solo = $users->where('relationship_status', 1)->count();
            $total_tied = $users->where('relationship_status', 2)->count();
            $total_ofs = $users->where('relationship_status', 3)->count();

           
        }else{
            $users = $query->where('id','!=',1)->whereBetween('created_at', [$this->startDate, $this->endDate])->get();
           
            // Total users
            $totalUsers = $users->count();

            //neow
            $totalNeow = $users->where('role_id', 2)->count();
            $neowFemale = $users->where('role_id', 2)->where('gender',2)->count();
            $neowTrans = $users->where('role_id', 2)->where('gender',3)->count();

            //buddy
            $totalBuddy = $users->where('role_id', 3)->count();
            $buddyMale = $users->where('role_id', 3)->where('gender',1)->count();
            $buddyFemale = $users->where('role_id', 3)->where('gender',2)->count();
            $buddyTrans = $users->where('role_id', 3)->where('gender',3)->count();

            //CycleExplore
            $totalCycleExplore = $users->where('role_id', 4)->count();
            $cycleExploreMale = $users->where('role_id', 4)->where('gender',1)->count();
            $cycleExploreFemale = $users->where('role_id', 4)->where('gender',2)->count();
            $cycleExploreTrans = $users->where('role_id', 4)->where('gender',3)->count();

            //totaluser gender wise
            $totalMale = $users->where('gender',1)->count();
            $totalFemale = $users->where('gender',2)->count();
            $totalTrans = $users->where('gender',2)->count();

            //relationWise
            $total_solo = $users->where('relationship_status', 1)->count();
            $total_tied = $users->where('relationship_status', 2)->count();
            $total_ofs = $users->where('relationship_status', 3)->count();
        }



        return view('admin.exports.users', [
            'startDate' => $this->startDate, 
            'endDate' => $this->endDate,
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
            AfterSheet::class => function(AfterSheet $event) {
                // Customize row 4
                $event->sheet->getColumnDimension('A')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('B')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('C')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('D')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('E')->setWidth(20); // Adjust the width as needed
                $event->sheet->getColumnDimension('F')->setWidth(20); // Adjust the width as needed
            
            

                $event->sheet->getRowDimension(4)->setRowHeight(20); // Adjust the height as needed
                $event->sheet->getStyle('A1:B1')->getFont()->setBold(true); 
                $event->sheet->getStyle('A1:B1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A6:B6:')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C6:D6')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E6:F6')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A7:B7')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C7:D7')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E7:F7')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C8:D8')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E8:F8')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A10:B10')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C10:D10')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A11:B11')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C11:D11')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A12:B12')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C12:D12')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A13:B13')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C13:D13')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A18:B18')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C18:D18')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E18:F18')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A19:B19')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C19:D19')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E19:F19')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A20:B20')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C20:D20')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E20:F20')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A21:B21')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('C21:D21')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('E21:F21')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A15')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A16')->getAlignment()->setHorizontal('center');
                

                $event->sheet->getStyle('B1:B3')->applyFromArray([
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
                $event->sheet->getStyle('A1:B3')->applyFromArray([
                    'borders' => [
                        'outline' => [
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
                $event->sheet->getStyle('A18:F18')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
              
                $event->sheet->getStyle('A1:A3')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A19:A21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('B18:B21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);


                $event->sheet->getStyle('C19:C21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('D18:D21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('E19:E21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('F19:F21')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A15')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A15:A17')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFB9EBFF', // Background color #B9EBFF
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A10:D10')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFB9EBFF', // Background color #B9EBFF
                        ],
                    ],
                ]);

                
                $event->sheet->getStyle('A4:F5')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFB9EBFF', // Background color #B9EBFF
                        ],
                    ],
                ]);

                
                
                
                $event->sheet->getStyle('A4:F5')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A2:B2')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A4:F4')->getFont()->setBold(true);
                
                $event->sheet->getStyle('A5:F5')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A11:A13')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('B10:B13')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C11:C13')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                $event->sheet->getStyle('D11:D13')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                ]);

                


                $event->sheet->getStyle('A10:D10')->applyFromArray([
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

                // You can add more customization as needed
            },
        ];
    }
}
