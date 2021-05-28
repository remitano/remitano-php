<?php
namespace Remitano\Api\Merchant;

class Withdrawal
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function get($id)
    {
        return $this->client->get("merchant/merchant_withdrawals/$id");
    }

    public function create($data)
    {
        $withdrawal = $this->client->post("merchant/merchant_withdrawals", [
            "merchant_withdrawal_ref" => $data["merchant_withdrawal_ref"],
            "coin_currency" => $data["coin_currency"],
            "coin_amount" => $data["coin_amount"],
            "receiver_pay_fee" => $data["receiver_pay_fee"],
            "cancelled_or_completed_callback_url" => $data["cancelled_or_completed_callback_url"],
            "coin_address" => $data["coin_address"],
            "destination_tag" => $data["destination_tag"],
            "remitano_username" => $data["remitano_username"],
            "remitano_phone_number" => $data["remitano_phone_number"]
        ]);

        if ($withdrawal->action_confirmation_id) {
            print_r($this->client->action_confirmations()->confirm_by_hotp($withdrawal->action_confirmation_id, $withdrawal->otp_counter));
        }

        return $withdrawal;
    }
}
