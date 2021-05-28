# Remitano PHP API Client

PHP client for Remitano API https://developers.remitano.com/api-explorer/

## Install

Via Composer

``` bash
$ composer require remitano/remitano-php
```

## Usage

``` php
$client = new Remitano\Api\RemitanoClient(array(
    'apiKey'  => 'your-api-key',
    'apiSecret' => 'your-api-secret',
    'authenticatorSecret' => 'your-authenticator-secret'
));

$merchant_charges = new Remitano\Api\Merchant\Charge($client);
$charge = $merchant_charges->create([
    "coin_currency" =>"usdt",
    "coin_amount" =>10.99,
    "cancelled_or_completed_callback_url" =>"https://example.com/payments/callback?id=example"
]);

$merchange_withdrawal = new Remitano\Api\Merchant\Withdrawal($client);
$withdraw= $merchange_withdrawal->create([
    "merchant_withdrawal_ref" => "123",
    "coin_currency" => "btc",
    "coin_amount" => 1,
    "coin_address" => "3CpwViK5RAMzT8AmaMFHVHyfoyQSwNPB6y",
    "receiver_pay_fee" => true,
    "cancelled_or_completed_callback_url" => "http://sample.com/123/callback",
]);
```

## Security

If you discover any security related issues, please email support@remitano.com or file a report at hackerone.com/remitano

## Credits

- [Remitano][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/remitano
