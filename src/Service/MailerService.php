<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function sendEmail(MailerInterface $mailer,$to,$content): void
    {
        $email = (new Email())
            ->from('insitefulcontact@gmail.com')
            ->to($to)
            ->subject('Welcome to INSITEFUL!')
            ->html($content);
        $mailer->send($email);
    }

}