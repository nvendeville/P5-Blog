<?php

namespace App\core;

use PHPMailer\PHPMailer\PHPMailer;

trait Mailer
{

    public function sendMail(string $subject, string $message, string $replyTo): void
    {
        $config = ConfigClass::getInstance();
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->isHTML(true);

        $mail->SMTPAuth = $config->get("smtp_auth");
        $mail->Host = $config->get("smtp_host");
        $mail->Port = $config->get("smtp_port");
        $mail->setFrom($config->get("smtp_setFromMail"), $config->get("smtp_setFromName"));
        $mail->addAddress($config->get("smtp_addAddress"));

        $mail->addReplyTo($replyTo);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }
}
