<?php
require '../vendor/autoload.php';

$client = new Remitano\Api\RemitanoClient(array(
    'apiKey'  => 'a4c60313f2ce6a0d93432462ae23771ea11428aa36e067970d599db966ab7212',
    'apiSecret' => 'YqEHOdLr/dhqEVOgNWCfOQNn7rxGCX1GWRYIvVbs2r2DQCGtiEjyz8WsyasH+DdIb0p5/Jbsh0hBJu3lm1QKWg==',
    'authenticatorSecret' => 'base32secretkey3232'
));

// Get coin account info of current user
$coin_accounts = $client->get('/users/coin_accounts');

$merchant_withdrawals = new Remitano\Api\Merchant\Withdrawal($client);
$withdrawal = $merchant_withdrawals->get(1);
