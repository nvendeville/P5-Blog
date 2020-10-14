<?php


namespace App\core;


use PHPMailer\PHPMailer\PHPMailer;

trait Mailer
{
    private $mail;

    private $subject = 'Demande de contact';

    public function sendMail($contactForm)
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->SMTPAuth = false;
        $this->mail->Host = 'localhost';
        $this->mail->Port = 1025;

        $this->mail->setFrom('nvendeville@cenef.fr', 'Nathalie Vendeville');
        $this->mail->addAddress($contactForm['email']);
        $this->mail->isHTML(true);

        $this->mail->Subject = $this->subject;

        $this->mail->Body = 'Vous avez reçu un message de ' . $contactForm['firstname'] . ' ' . $contactForm['lastname'] . ' : ' . $contactForm['message'];
        if (!$this->mail->send()) {
            echo 'Erreur, message non envoyé.';
            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            die();
        }
    }

}