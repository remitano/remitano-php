<?php
require '../vendor/autoload.php';

$client = new Remitano\Api\RemitanoClient(array(
    'apiKey'  => 'a4c60313f2ce6a0d93432462ae23771ea11428aa36e067970d599db966ab7212',
    'apiSecret' => 'YqEHOdLr/dhqEVOgNWCfOQNn7rxGCX1GWRYIvVbs2r2DQCGtiEjyz8WsyasH+DdIb0p5/Jbsh0hBJu3lm1QKWg==',
    'authenticatorSecret' => 'base32secretkey3232'
));

//print_r($client->get('users/document'));
//
$merchant_charges = new Remitano\Api\Merchant\Charge($client);
$charge = $merchant_charges->create([
    "coin_currency" =>"usdt",
    "coin_amount" => 10.99,
    "cancelled_or_completed_callback_url" =>"https://example.com/payments/callback?id=example"
]);
print_r($charge);

//print_r($client->post('users/update', [
//    'name'=>'buyer slee'
//]));


//print_r($client->post("merchant/merchant_charges", [
//    "coin_currency" => "usdt",
//    "coin_amount" => 10.899,
//    "cancelled_or_completed_callback_url" => "https://example.com/payments/callback?id=example"
//]));
