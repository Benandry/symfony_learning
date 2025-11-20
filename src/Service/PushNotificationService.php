<?php 

declare(strict_types=1);

namespace App\Service;

use App\Entity\PushSubscription;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

final class PushNotificationService
{
    /**
     * Undocumented function
     *
     * @param string $title
     * @param string $message
     * @param PushSubscription[] $subscribers
     * @return array
     */
    public function sendNotification(string $title, string $message, array $subscribers): array
    {
        if(empty($subscribers)) {
          return ['status' => 0, 'failure' => 0, 'message' => 'No subscriber provided'];
        }
        $publicKey = $_ENV['VAPID_PUBLIC_KEY'];
        $privateKey = $_ENV['VAPID_PRIVATE_KEY'];

        if(empty($publicKey) || empty($privateKey)) {
          throw new \InvalidArgumentException('VAPID keys are not set in environment variables.');
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'mailto:nandry556@gmail.com',
                'publicKey' => $publicKey,
                'privateKey' => $privateKey,
            ]
        ]);

        foreach ($subscribers as $subscriber) {
            $subscription = Subscription::create([
                'endpoint' => $subscriber->getEndpoint(),
                'keys' => [
                    'p256dh' => $subscriber->getPublicKey(),
                    'auth' => $subscriber->getAuthToken(),
                ],
            ]);

            $webPush->queueNotification(
                $subscription,
                json_encode(['title' => $title, 'message' => $message])
            );
        }

        $success = 0;
        $failure = 0;

        foreach ($webPush->flush() as $report) {
            if ($report->isSuccess()) {
                $success++;
            } else {
                $failure++;
            }
        }
        return [
            'success' => $success,
            'failure' => $failure,
        ];
    }
}