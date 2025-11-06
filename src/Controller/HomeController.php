<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    public function __construct(
        private readonly MailerInterface $mailer
    )
    {
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $this->mailer->send(
            (new Email())
                ->from('Acme <onboarding@resend.dev>')
                ->to('nandry556@gmail.com')
                ->subject('Hello world')
                ->html('<strong>it works!</strong>')
        );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
