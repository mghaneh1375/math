<?php

use Kavenegar\Laravel\Facade as Kavenegar;

function generateActivationCode() {
    return rand(10000, 99999);
}

function sendSMS($destNum, $text, $templateId, $text2 = "", $text3 = "") {
    if($destNum[0] == "0" && $destNum[1] == "9") {
        try {
            $result = Kavenegar::VerifyLookup($destNum, $text, $text2, $text3, $templateId);

            if ($result) {
                foreach ($result as $r) {
                    return $r->messageid;
                }
            }
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            return -1;
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            return -1;
        }
        return -1;
    }

    return -1;
}