<?php

namespace App\Filament\Actions\ThrSalaries;

use Carbon\Carbon;
use Livewire\Component;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\File;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class GenerateSlip
{
    public static function make(): BulkAction
    {
        return BulkAction::make('generateThrSalaryPdf')
            ->label('Generate PDF')
            ->color('primary')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function (Collection $records, Component $livewire) {
                try {
                    $generateCount = 0;
                foreach($records as $salary) {
                    $religion = $salary->religion;
                    $tahun = $salary->periodeThr->year;
                    $folderPath = $religion.'-'.$tahun;
                    $nomorAcak = self::generateRandomString();
                    $titleSlip = $salary->periodeThr->title.' '.$tahun;
                    $message = $salary->periodeThr->message ?? '';
                    if (!Storage::disk('public')->exists($folderPath)) {
                        Storage::disk('public')->makeDirectory($folderPath, 0775, true, true);
                    }
                    $path = public_path().'/images/sne-logo.jpg';
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $image = 'data:image/'.$type.';base64,'.base64_encode($data);
                    $qrCode = base64_encode(QrCode::format('svg')->size('70')->generate($salary->nomor_surat)); 
                    $filePath = $folderPath.'/slip-thr-'.$salary->name.'-'.$tahun.'-'.$nomorAcak.'.pdf';
                    $fileUrl = $religion.'-'.$tahun.'/slip-thr-'.$salary->name.'-'.$tahun.'-'.$nomorAcak.'.pdf';

                    //dd(Storage::exists($folderPath));

                    $pdf = Pdf::loadView('template-thr', [
                        'name' => $salary->name,
                        'departemen' => $salary->departemen,
                        'position' => $salary->position,
                        'nip' => $salary->nip,
                        'join_date' => $salary->join_date,
                        'masa_kerja' => $salary->masa_kerja,
                        'pph21' => $salary->pph21,
                        'thp' => $salary->thp,
                        'terbilang' => $salary->terbilang,
                        'nomor_surat' => $salary->nomor_surat,
                        'tahun' => $tahun,
                        'qrCode' => $qrCode,
                        'image' => $image,
                        'message' => $message,
                        'titleSlip' => $titleSlip
                    ])->save(Storage::disk('public')->path($filePath));
                    $salary->update([
                        'is_pdf' => true,
                        'file' => $fileUrl
                    ]); 
                    $generateCount++;
                }
                $livewire->dispatch('refresh-table');
                Notification::make()
                    ->title("Berhasil Generate Pdf untuk ".$generateCount." Slip Gaji")
                    ->success()
                    ->send();
                } catch(\Exception $er) {
                    dd($er);
                }
            });
            // ->visible(function (Table $table) {
            //     // Cek apakah semua record yang ada memiliki is_pdf = true
            //     //return \App\Models\Salary::query()->where('isPdf', false)->doesntExist();
            // });
    }

    public static function generateRandomString($length = 6) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}