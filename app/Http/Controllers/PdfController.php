<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{
    public function generatePdf() {
        $data = [
            'hello' => 'Hello World'
        ];
        $pdf = Pdf::loadView('test', $data);
        Storage::disk('public')->put('testt.pdf', $pdf->output());
        return $pdf->stream();
    }
}
