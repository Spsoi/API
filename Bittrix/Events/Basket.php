<?php
// После добавления в корзину
AddEventHandler("sale", "OnBasketAdd", array("AmoElementAddAfter", "OnAfterIBlockElementAddHandler")); // кастом
// Изменение корзины
AddEventHandler("sale", "OnBasketUpdate", array("AmoElementAddAfter", "OnAfterIBlockElementAddHandler")); // кастом

class AmoElementAddAfter // любое имя
{
    function OnAfterIBlockElementAddHandler(&$arFields) // любое имя
    {
        global $USER; // глобалка
        $ID = $USER->GetID(); // получаем ID юзера
        $rsUser = CUser::GetByID($ID);   // return array
        $arUser = $rsUser->Fetch();                 //return bject
            
        $r = parse_url($_SERVER['HTTP_REFERER']);
        $url = $r['host'] . $r['path'];
    
        $data = [
            'request' => $_REQUEST,
            'server' => $_SERVER,
            'url' => $url,
            'files' => $_FILES,
            'arFields' => $arFields,
            'email' => $USER->GetEmail(),
            'user' => $arUser,
        ];
    
        $request = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'host.ru);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1100);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  ['data' => $request]);
        curl_exec($curl);
        curl_close($curl);
    }
}
