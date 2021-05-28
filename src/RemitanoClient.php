<?php
namespace Remitano\Api;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use OTPHP\HOTP;
use OTPHP\TOTP;
use Remitano\Api\Utils\ActionConfirmations;
use Remitano\Api\Utils\ApiAuthHandler;

class RemitanoClient {
    private $client;
    private $authenticator_secret;

    public function __construct($config)
    {
        $accessID= $config['apiKey'];
        $secretKey = $config['apiSecret'];
        $this->authenticator_secret = $config['authenticatorSecret'];

        $apiAuthHandler = new ApiAuthHandler(array(
            'apiKey' =>  $accessID,
            'apiSecret' =>  $secretKey
        ));
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push($apiAuthHandler->handleAuthorizationHeader());

        $this->client = new Client([
            'handler'  => $stack,
            "base_uri" => $this->base_uri()
        ]);
    }

    public function authenticator_token()
    {
        return TOTP::create($this->authenticator_secret)->now();
    }

    public function hotp($otp_counter)
    {
        return HOTP::create($this->authenticator_secret, $otp_counter)->at($otp_counter);
    }

    public function get($url)
    {
        return json_decode($this->request('get', $url));
    }

    public function post($url, $data)
    {
        return json_decode($this->request('post', $url, $data));
    }

    public function put($url, $data)
    {
        return json_decode($this->request('put', $url, $data));
    }

    private function request($method, $url, $data = null)
    {
        try {
            $response = $this->client->request($method, $url, ['json' => $data]);
            return $response->getBody();
        } catch (GuzzleException $e) {
            return "{$e->getCode()} - {$e->getMessage()}";
        }
    }

    private function base_uri()
    {
        return getenv('REMITANO_SERVER') ?: "https://api.remitano.com/api/v1/";
    }
}
