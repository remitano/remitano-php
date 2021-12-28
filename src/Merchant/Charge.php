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
        if (isset($data['fiat_currency'])) {
            return $this->client->post("merchant/merchant_charges", [
                "fiat_currency" => $data["fiat_currency"],
                "fiat_amount" => $data["fiat_amount"],
                "cancelled_or_completed_callback_url" => $data["cancelled_or_completed_callback_url"],
                "cancelled_or_completed_redirect_url" => $data["cancelled_or_completed_redirect_url"],
                "description" => $data["description"],
                "coin_currency" => $data["coin_currency"],
                "coin_address" => $data["coin_address"],
                "coin_layer" => $data["coin_layer"],
            ]);
        }
        return $this->client->post("merchant/merchant_charges", [
            "coin_currency" => $data["coin_currency"],
            "coin_amount" => $data["coin_amount"],
            "cancelled_or_completed_callback_url" => $data["cancelled_or_completed_callback_url"],
            "cancelled_or_completed_redirect_url" => $data["cancelled_or_completed_redirect_url"],
            "description" => $data["description"],
            "coin_address" => $data["coin_address"],
            "coin_layer" => $data["coin_layer"],
        ]);
    }
}
