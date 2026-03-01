<?php

namespace App\Services;

use App\Mail\EventInvitation;
use App\Models\Invit;
use Illuminate\Support\Facades\Mail;

class InvitationService
{
    public function send(Invit $invitation): void
    {
        Mail::to($invitation->email)->queue(new EventInvitation($invitation));
        
        $invitation->markAsSent();
    }

    public function sendBulk(array $invitations): array
    {
        $sent = 0;
        $failed = 0;

        foreach ($invitations as $invitation) {
            if ($invitation->isRegistered()) {
                continue;
            }

            try {
                $this->send($invitation);
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                \Log::error('Échec envoi invitation: ' . $e->getMessage(), [
                    'invitation_id' => $invitation->id,
                ]);
            }
        }

        return [
            'sent' => $sent,
            'failed' => $failed,
        ];
    }
}