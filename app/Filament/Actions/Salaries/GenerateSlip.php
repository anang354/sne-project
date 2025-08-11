<?php

namespace App\Filament\Actions\Salaries;

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
        return BulkAction::make('generateSalaryPdf')
            ->label('Generate PDF')
            ->color('primary')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function (Collection $records, Component $livewire) {
                try {
                    $generateCount = 0;
                foreach($records as $salary) {
                    $bulan = $salary->periode->month;
                    $tahun = $salary->periode->year;
                    $folderPath = $bulan.'-'.$tahun;
                    $nomorAcak = self::generateRandomString();
                    
                    if (!Storage::disk('public')->exists($folderPath)) {
                        Storage::disk('public')->makeDirectory($folderPath, 0775, true, true);
                    }
                    $path = public_path().'/images/sne-logo.jpg';
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $image = 'data:image/'.$type.';base64,'.base64_encode($data);
                    $qrCode = base64_encode(QrCode::format('svg')->size('70')->generate($salary->nomor_surat)); 
                    $filePath = $folderPath.'/slip-gaji-'.$salary->nama.'-'.$bulan.' '.$tahun.'-'.$nomorAcak.'.pdf';
                    $fileUrl = $bulan.'-'.$tahun.'/slip-gaji-'.$salary->nama.'-'.$bulan.' '.$tahun.'-'.$nomorAcak.'.pdf';

                    //dd(Storage::exists($folderPath));

                    $pdf = Pdf::loadView('template', [
                        'name' => $salary->nama,
                        'department' => $salary->departemen,
                        'position' => $salary->posisi,
                        'gajiPokok' => $salary->gaji_pokok,
                        'tunjJabatan' => $salary->tunj_jabatan,
                        'tunjBahasa' => $salary->tunj_bahasa,
                        'tunjKerajinan' => $salary->tunj_kerajinan,
                        'tunjLainnya' => $salary->tunj_lainnya,
                        'totalGaji' => $salary->total_gaji,
                        'lembur' => $salary->lembur,
                        'uangMakan' => $salary->uang_makan,
                        'rapel' => $salary->rapel,
                        'potonganHari' => $salary->potongan_hari,
                        'potonganAbsensi' => $salary->potongan_absensi,
                        'denda' => $salary->denda,
                        'bpjsTk' => $salary->bpjs_tk,
                        'bpjsKs' => $salary->bpjs_ks,
                        'pph21' => $salary->pph21,
                        'potonganLainnya' => $salary->potongan_lainnya,
                        'totalPotongan' => $salary->total_potongan,
                        'gajiBersih' => $salary->gaji_bersih,
                        'terbilang' => $salary->terbilang,
                        'tanggal' => $salary->tanggal,
                        'nomorSurat' => $salary->nomor_surat,
                        'qrCode' => $qrCode,
                        'image' => $image,
                        'bulan' => $bulan,
                        'tahun' => $tahun
                    ])->save(Storage::disk('public')->path($filePath));
                    $salary->update([
                        'isPdf' => true,
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