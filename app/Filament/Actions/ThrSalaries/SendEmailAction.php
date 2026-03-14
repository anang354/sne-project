<?php

namespace App\Filament\Actions\ThrSalaries;

use App\Mail\ThrSentMail;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SendEmailAction
{
    public static function make(): Action
    {
        return Action::make('sendEmail')
            ->label('Send Email')
            ->icon('heroicon-o-envelope')
            ->action(function ($record, Component $livewire) {
                try {
                    //Action Sending Email
                    Mail::to($record->email)->send(
                        new ThrSentMail($record)
                    );
                    $record->update(['is_sent' => true]);
                    //Send Notification
                    Notification::make()
                            ->title("Email untuk {$record->name} berhasil dikirim")
                            ->success()
                            ->send();
                    $livewire->dispatch('refresh-table');
                } catch (\Exception $e) {
                    // Notification::make()
                    //         ->title("Error")
                    //         ->error($e)
                    //         ->send();
                    dd($e);
                }
            })
            ->visible(function ($record) {
                return !$record->is_sent && $record->is_pdf;
            });
    }
}