<?php

namespace App\Console\Commands;

use App\Models\Invit;
use App\Services\InvitationService;
use Illuminate\Console\Command;

class SendPendingInvitations extends Command
{
    
    protected $signature = 'invitations:send 
                            {--event= : ID de l\'événement (optionnel)} 
                            {--limit=10 : Nombre max à envoyer}';

    
    protected $description = 'Envoie les invitations en attente';

   
    public function handle(InvitationService $service)
    {
        $query = Invit::pending()->with('event');

        if ($eventId = $this->option('event')) {
            $query->where('event_id', $eventId);
        }

        $invitations = $query->limit($this->option('limit'))->get();

        if ($invitations->isEmpty()) {
            $this->info('Aucune invitation en attente.');
            return Command::SUCCESS;
        }

        $this->info("Envoi de {$invitations->count()} invitation(s)...");

        $bar = $this->output->createProgressBar($invitations->count());
        $bar->start();

        $sent = 0;
        $failed = 0;

        foreach ($invitations as $invitation) {
            try {
                $service->send($invitation);
                $sent++;
                $this->newLine();
                $this->line("Envoyé à {$invitation->email} ({$invitation->event->title})");
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->error("Échec pour {$invitation->email}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Terminé ! {$sent} envoyé(s), {$failed} échec(s).");

        return Command::SUCCESS;
    }
}