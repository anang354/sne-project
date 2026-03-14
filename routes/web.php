<?php

use App\Http\Controllers\PdfController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return Pdf::loadView('template-thr')->stream('thr.pdf');
});
Route::get('generate-pdf', [PdfController::class, 'generatePdf']);

