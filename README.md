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

$client->get('/api/v1/users/me');
```

## Security

If you discover any security related issues, please email support@remitano.com or file a report at hackerone.com/remitano

## Credits

- [Remitano][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/remitano
