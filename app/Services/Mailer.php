<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Envía correos HTML y registra el error en lugar de interrumpir la petición.
 */
class Mailer
{
    public function send(string $to, string $subject, string $html): bool
    {
        try {
            Mail::html($html, fn ($message) => $message->to($to)->subject($subject));

            return true;
        } catch (Throwable $e) {
            Log::error('No se pudo enviar el correo: ' . $e->getMessage(), ['to' => $to, 'subject' => $subject]);

            return false;
        }
    }
}
