<?php
// https://dev.1c-bitrix.ru/api_help/main/events/index.php
// после того как вышел из аккаунта
AddEventHandler("main", "OnAfterUserLogin", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом
// После регистрации
AddEventHandler("main", "OnAfterUserAdd", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом

class AmoAfterUserRegister
{
    function OnAfterIBlockElementAddHandler($arFields)
    {
        $data = [
            // 'request' => 'Пришло ушло',
            'server' => $_SERVER,
            'url' => $url,
            'files' => $_FILES,
            'arFields' => $arFields,
        ];

        $curl = new Curl;
        $curl->WebHook($data);
    }
}

class Curl
{
    public function WebHook($data) {
       

        $request = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'host.ru');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1100);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  ['data' => $request]);
        $result = curl_exec($curl);
        curl_close($curl);
        curl_close ($ch);
        return $result;
    }
}
