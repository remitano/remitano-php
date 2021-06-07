# Remitano PHP API Client

Feel free to fork, modify & redistribute under the MIT license.

## Installation

Via Composer

``` bash
$ composer require remitano/remitano-php
```

Or clone this repository and include it in your project

## Usage
### Create API Key

Visit https://remitano.com/settings/api_key to create API key.

### Get Authenticator secret

Visit https://remitano.com/settings/authenticator to get your authenticator secret.

Note: This is needed to perform actions which need 2FA authentication like withdrawals, otherwise, you won't need it.

### Setup Remitano client

```php
$client = new Remitano\Api\RemitanoClient([
    'apiKey'  => 'your-api-key',
    'apiSecret' => 'your-api-secret',
    'authenticatorSecret' => 'your-authenticator-secret'
]);
```
### Payment gateway
Visit https://developers.remitano.com/api-explorer - Merchant section for more information.
#### Charges
##### Get
```php
$merchant_charges = new Remitano\Api\Merchant\Charge($client);
$merchant_charges->get($id);
```
##### Create
```php
$merchant_charges->create([
    "coin_currency" => "usdt",
    "coin_amount" => 10.99,
    "cancelled_or_completed_callback_url" =>"https://example.com/payments/callback?id=example",
    "description" => "Example charge"
]);
```
Note: For now, we only support `usdt` as the price coin currency.

#### Withdrawals
##### Get
```php
$merchant_withdrawals = new Remitano\Api\Merchant\Withdrawal($client);
$merchant_withdrawals->get($id);
```
##### Create
1. Withdraw to external coin address
```php
$merchant_withdrawals->create([
    "merchant_withdrawal_ref" => "123",
    "coin_currency" => "btc",
    "coin_amount" => 1,
    "receiver_pay_fee" => true,
    "cancelled_or_completed_callback_url" => "http://sample.com/123/callback",
    "coin_address" => "3CpwViK5RAMzT8AmaMFHVHyfoyQSwNPB6y"
]);
```

2. Withdraw to other remitano account
```php
$merchant_withdrawals->create([
    "merchant_withdrawal_ref" => "123",
    "coin_currency" => "btc",
    "coin_amount" => 1,
    "receiver_pay_fee" => true,
    "cancelled_or_completed_callback_url" => "http://sample.com/123/callback",
    "remitano_username" => "receiver123",
    "remitano_phone_number" => "+234 1 123 4567"
]);
```

#### Callbacks
##### Charges
Whenever a charge is changed to completed or cancelled in our system:
- we will send a POST request to `charge.cancelled_or_completed_callback_url` with `remitano_id` param.
- if user is still on our site, we will also redirect user to `object.cancelled_or_completed_callback_url` with `remitano_id` param (GET request).

After receiving these callbacks, you could call `$merchant_charges->get($params['remitano_id'])` to get the updated information and process accordingly.

##### Withdrawals
Whenever a withdrawal is changed to completed or cancelled in our system:
- we will send a POST request to `withdrawal.cancelled_or_completed_callback_url` with `remitano_id` param.

After receiving these callbacks, you could call `$merchant_withdrawals->get($params['remitano_id'])` to get the updated information and process accordingly.

### Other API calls
Visit https://developers.remitano.com/api-explorer for more API specs, APIs can be called directly by using method `get`, `post`, `put` of `$client`

```php
$client->get('users/coin_accounts');

$client->post('offers/best', [
    "country_code" => "my",
    "offer_type" => "buy",
    "coin_currency" => "btc",
    "coin_amount" => 1
]);
```
### Errors
When receiving non 200-299 http code, an Error will be raised.

### Sandbox testing
We have a Testnet at https://remidemo.com.

You could register an account there, then submit a request at [this google form](https://forms.gle/jvJyWPBNwTWfowSm9) with your Remidemo username, so we could help to setup your testing account as a merchant.

After that, you could start your sandbox testing by setting ENV variable: `putenv("REMITANO_SANDBOX=1")`.

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b
   my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
