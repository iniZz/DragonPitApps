<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class Webhook
{

    private $webhookacc = "https://discord.com/api/webhooks/878706457854488597/oww2SsCjGkYcRRwzAy3g5Y7CPWRlOJ4ZFx-ifOn6jj02S8_hxFHo1PGbQ98c-8btDJo1";
    private $webhookrej = "https://discord.com/api/webhooks/878706457854488597/oww2SsCjGkYcRRwzAy3g5Y7CPWRlOJ4ZFx-ifOn6jj02S8_hxFHo1PGbQ98c-8btDJo1";

    public function Accepted($userInfo, $userID, $hex)
    {
        $myid = $userInfo['id'];

        $json_data = json_encode([
            "content" => "Podanie <@$userID> przyjęte przez <@$myid> \n**ID:**$myid \n**Steamhex:**$hex",
            "username" => "Podanie przyjęte",
            "avatar_url" => "https://atlantisrp.gg/images/logo.png",

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $this->Send($this->webhookacc, $json_data);
    }

    public function Rejected($userInfo, $userID, $reason)
    {
        $myid = $userInfo['id'];
        if ($reason != '...') {
            $json_data = json_encode([
                "content" => "Podanie <@$userID> zostało odrzucone przez <@$myid>\n**Powód:** $reason",
                "username" => "Podanie odrzucone",
                "avatar_url" => "https://atlantisrp.gg/images/logo.png",

            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            $json_data = json_encode([
                "content" => "Podanie <@$userID> zostało odrzucone przez <@$myid>\n",
                "username" => "Podanie odrzucone",
                "avatar_url" => "https://atlantisrp.gg/images/logo.png",

            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }


        $this->Send($this->webhookrej, $json_data);
    }

    private function Send($webhookurl, $json_data)
    {

        $ch = curl_init($webhookurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);
    }
}
