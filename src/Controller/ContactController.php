<?php 

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
   #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerService $mailerService)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $mailerService->sendEmail(
                $data['email'],
                'Nouveau message de contact',
                nl2br($data['message'])
            );


            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('app_contact');
        }
         return $this->render('contact/index.html.twig', [
            'contactForm' => $form
        ]);
    }
}