<?php 

namespace App\Controller;

use App\Entity\PushSubscription as EntityPushSubscription;
use App\Model\PushSubscription;
use App\Service\PushNotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index()
    {
        return $this->render('notification/index.html.twig', [
            'vapid_public_key' => $_ENV['VAPID_PUBLIC_KEY'],
        ]);
    }

    #[Route('/subscriber', name: 'app_subscriber' , methods: ['POST'])]
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $subscription = (new EntityPushSubscription())
        ->setEndpoint($data['endpoint'])
        ->setPublicKey($data['keys']['p256dh'])
        ->setAuthToken($data['keys']['auth']);

        $em->persist($subscription);
        $em->flush();

       return  new Response('Subscription received', Response::HTTP_OK );
    }

    #[Route('/send-notification', name: 'app_send_notification' , methods: ['POST'])]
    public function sendNotification(Request $request, EntityManagerInterface $em, PushNotificationService $pushService): Response
    {
        $subscriptions = $em->getRepository(EntityPushSubscription::class)->findAll();

        $result = $pushService->sendNotification(
            'New Notification',
            'This is a test notification sent from Symfony!',
            $subscriptions
        );

        
        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'failure' => $result['failure'],
            'message' => $result['message'],
        ]);
    }
}