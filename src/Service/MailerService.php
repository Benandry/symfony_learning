<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MailerService
{

    public function __construct( 
        private readonly MailerInterface $mailer
    )
    {
    }

    public function sendEmail(string $to, string $subject, string $content): void
    {
       try {
        $email = (new Email())
            ->from("nandry556@gmail.com")
            ->to($to)
            ->subject($subject)
            ->html($content);

            $this->mailer->send($email);
       } catch (TransportException $th) {
            // Log the error or handle it as needed
            throw new \RuntimeException('Failed to send email: ' . $th->getMessage());
       }
    }
}

