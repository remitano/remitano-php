<?php
namespace Remitano\Api\Utils;

class ActionConfirmations
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function confirm($id)
    {
        return $this->client->post("/action_confirmations/$id/confirm", [
            "token" => $this->client->authenticator_token()
        ]);
    }

    public function confirm_by_hotp($id, $otp_counter)
    {
        return $this->client->post("/action_confirmations/$id/confirm", [
            "token" => $this->client->hotp($otp_counter)
        ]);
    }
}
