<?php

namespace App\Filament\Actions\Salaries;

use Livewire\Component;
use App\Mail\SalarySentMail;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

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
                        new SalarySentMail($record)
                    );
                    $record->update(['isEmail' => true]);
                    //Send Notification
                    Notification::make()
                            ->title("Email untuk {$record->nama} berhasil dikirim")
                            ->success()
                            ->send();
                    $livewire->dispatch('refresh-table');
                } catch (\Exception $e) {
                    Notification::make()
                            ->title("Error")
                            ->error()
                            ->send();
                }
            })
            ->visible(function ($record) {
                return !$record->isEmail && $record->isPdf;
            });
    }
}