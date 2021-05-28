<?php
require '../vendor/autoload.php';
use Remitano\Api\RemitanoClient;

$client = new RemitanoClient(array(
    'apiKey'  => 'a4c60313f2ce6a0d93432462ae23771ea11428aa36e067970d599db966ab7212',
    'apiSecret' => 'YqEHOdLr/dhqEVOgNWCfOQNn7rxGCX1GWRYIvVbs2r2DQCGtiEjyz8WsyasH+DdIb0p5/Jbsh0hBJu3lm1QKWg==',
    'authenticatorSecret' => '123'
));

print_r($client->get('/api/v1/users/document'));
