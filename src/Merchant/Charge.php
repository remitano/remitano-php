<?php
namespace Remitano\Api\Merchant;

class Charge
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function get($id)
    {
        return $this->client->get("merchant/merchant_charges/$id");
    }

    public function create($data)
    {
        return $this->client->post("merchant/merchant_charges", [
            "coin_currency" => $data["coin_currency"],
            "coin_amount" => $data["coin_amount"],
            "cancelled_or_completed_callback_url" => $data["cancelled_or_completed_callback_url"]
        ]);
    }
}
