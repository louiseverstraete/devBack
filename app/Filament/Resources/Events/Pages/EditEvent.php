<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Services\InvitationService;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->visible(fn () => auth()->user()->role === 'ADMIN' || $this->record->organizer_id === auth()->id()),

            Actions\Action::make('send_invitations')
                ->label(function ($record) {
                    $pending = $record->invitations()->pending()->count();
                    return "Envoyer les invitations ({$pending})";
                })
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->badge(function ($record) {
                    return $record->invitations()->pending()->count();
                })
                ->badgeColor('warning')
                ->requiresConfirmation()
                ->modalHeading('Envoyer les invitations')
                ->modalDescription(function ($record) {
                    $pending = $record->invitations()->pending()->count();
                    return "Envoyer {$pending} invitation(s) en attente par email ?";
                })
                ->modalSubmitActionLabel('Envoyer')
                ->action(function ($record) {
                    $invitations = $record->invitations()->pending()->get();

                    if ($invitations->isEmpty()) {
                        Notification::make()
                            ->warning()
                            ->title('Aucune invitation en attente')
                            ->body('Toutes les invitations ont déjà été envoyées.')
                            ->send();
                        return;
                    }

                    try {
                        $service = app(InvitationService::class);
                        $result = $service->sendBulk($invitations->all());

                        Notification::make()
                            ->success()
                            ->title('✅ Invitations envoyées !')
                            ->body("{$result['sent']} invitation(s) envoyée(s)" . 
                                ($result['failed'] > 0 ? " • {$result['failed']} échec(s)" : ''))
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->danger()
                            ->title('❌ Erreur')
                            ->body('Impossible d\'envoyer les invitations : ' . $e->getMessage())
                            ->send();
                    }
                })
                ->visible(fn ($record) => $record->visibility === 'prive'),
            
            // ==========================================
            // ACTION : Recevoir le récap par email
            // ==========================================

            
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);
        $user = auth()->user();
        if ($user->role !== 'ADMIN' && $this->record->organizer_id !== $user->id) {
            abort(403);
        }
    }
}
