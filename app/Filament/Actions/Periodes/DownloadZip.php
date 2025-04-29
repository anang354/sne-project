<?php

namespace App\Filament\Actions\Periodes;

use ZipArchive;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DownloadZip {
    public static function make(): Action 
    {
        return Action::make('downlaodZip')
        ->label('Download Slip Gaji')
        ->icon('heroicon-o-inbox-arrow-down')
        ->action(function($record) {
            $bulan = $record->month;
            $tahun = $record->year;
            $folderName = $bulan.'-'.$tahun;
            $folderPath = Storage::disk('public')->path($folderName);
            if (!file_exists($folderPath)) {
                abort(404, 'Folder tidak ditemukan.');
            }

            // Nama file zip yang akan dibuat
            $zipFileName = $folderName . '.zip';
            $zipFilePath = storage_path('app/public/' . $zipFileName);

            // Buat zip baru
            $zip = new ZipArchive;
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($folderPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = ltrim(str_replace($folderPath, '', $filePath), '/\\');
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                $zip->close();
            } else {
                abort(500, 'Gagal membuat file zip.');
            }

            // Download file zip
            return response()->download($zipFilePath)->deleteFileAfterSend(true);

            //dd($folderPath);
        });
    }
}