<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Envío de correos por SMTP. Las credenciales viven en config/services.php (.env).
 */
class Mailer
{
    public function send(string $to, string $subject, string $html): bool
    {
        $config = config('services.smtp');

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;
            $mail->Host = $config['host'];
            $mail->Port = $config['port'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->SMTPSecure = $config['encryption'] ?: false;
            $mail->SMTPAutoTLS = (bool) $config['encryption'];

            $mail->setFrom($config['from']);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $html;

            return $mail->send();
        } catch (Exception $e) {
            Log::error('No se pudo enviar el correo: ' . $e->getMessage(), ['to' => $to, 'subject' => $subject]);

            return false;
        }
    }
}
