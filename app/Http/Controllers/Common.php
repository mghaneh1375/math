<?php

function generateActivationCode() {
    return rand(10000, 99999);
}


function sendSMS($destNum, $text, $templateId, $text2 = "", $text3 = "") {
    return;

    if($destNum[0] == "0" && $destNum[1] == "9") {

        require __DIR__ . '/../../../vendor/autoload.php';

        try {
            $api = new \Kavenegar\KavenegarApi("4B6A58494B6A5A6C6D68426D34777059397239587746754A5A394577596D5046684F6F63684934652F45343D");
            $result = $api->VerifyLookup($destNum, $text, $text2, $text3, $templateId);

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
