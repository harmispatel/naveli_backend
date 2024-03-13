<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class pdfController extends Controller
{
    public function generatePDF()
    {
        $pdf = PDF::loadView('admin.pdf.pdf');
        return $pdf->download('document.pdf');
    }
}
