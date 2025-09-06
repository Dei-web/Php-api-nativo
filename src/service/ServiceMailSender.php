<?php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Utils/util.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ServiceMailSender
{
    private string $username = 'deilerc27@gmail.com';
    private string $password = 'wggx rkao gmxp geoi '; // Tus credenciales
    private string $fromEmail = 'deilerc27@gmail.com';
    private string $fromName = 'Tu App';

    public function sendRecoveryCode(string $email, string $code): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Código de recuperación';
            $mail->Body    = "Tu código de recuperación es <b>{$code}</b>";

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Error enviando correo: {$mail->ErrorInfo}");
            return false;
        }
    }
}
