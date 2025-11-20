<?php

use Minishlink\WebPush\VAPID;

require __DIR__.'/vendor/autoload.php';

$keys = VAPID::createVapidKeys();

echo "Public Key:\n".$keys['publicKey']."\n\n";
echo "Private Key:\n".$keys['privateKey']."\n";  