<?php
// после оформление заказа
AddEventHandler("sale", "OnOrderAdd", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом

class AmoAfterUserRegister
{
    function OnAfterIBlockElementAddHandler($arFields)
    {
        $data = [
            'request' => $_REQUEST,
            'server' => $_SERVER,
            'files' => $_FILES,
            'arFields' => $arFields,
            // 'rs' => $rs
        ];

        $curl = new Curl;
        $req = $curl->WebHook($data);
        return $req;
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
// Получение заказа из карзины
$eventManager = EventManager::getInstance();
$eventManager->addEventHandler(
    "sale",
    "OnSaleOrderSaved",
    "AmoSaleOrderAjaxHandler"
);

function AmoSaleOrderAjaxHandler(Main\Event $event)
{
    $order = $event->getParameter("ENTITY");
    $oldValues = $event->getParameter("VALUES");
    $isNew = $event->getParameter("IS_NEW");

    if ($isNew) {
        $sum = $order->getPrice();
        $data = [
            'request' => $_REQUEST,
            'server' => $_SERVER,
            'cookies' => $_COOKIE,
            'order' => $order,
            'oldValues' => $oldValues,
            'isNew' => $isNew,
            'sum' => $sum,
            'propertyCollection' => $order->getPropertyCollection(),
            'basket' => $order->getBasket(),
            'myorderid' => $order->getId()
        ];
        $curl = new myCurl;
        $req = $curl->WebHook($data);
    }
}
