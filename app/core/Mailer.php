<?php

declare(strict_types=1);

namespace App\core;

use PHPMailer\PHPMailer\PHPMailer;

trait Mailer
{
    public function sendMail(string $subject, string $message, string $addAddress, string $replyTo): void
    {
        $config = ConfigClass::getInstance();
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->SMTPAuth = $config->getBool("smtp_auth");
        $mail->Host = $config->getString("smtp_host");
        $mail->Port = $config->getInt("smtp_port");
        $mail->setFrom($config->getString("smtp_setFromMail"), $config->getString("smtp_setFromName"));
        $mail->addAddress($addAddress);
        $mail->addReplyTo($replyTo);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }
}
