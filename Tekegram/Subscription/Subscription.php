<?php
// Подписка на события для бота
// Что посылаем на роут
// https://domen.ru/webhook?url=https://domain
$route->get('webhook', 'Folder\folder\folder\Controller@setWebHook');

class Controller{
    public function setWebHook() {
        $this->l->log('ConnectController->setWebHook');
        $job = new TelegramApiClass;
        $job->setWebHookClass();
        return true;
    }
}

class Telegram
{
    public  $prefix = 'bot';
    public  $token = 'tokernbot';

    public function __construct()
    {
        $this->l = logger('crm/AMOCRM');
    }

    public function setWebHookClass () {
        $this->l->log('setWebHookClass');
        $url = $_REQUEST['url'];
        $url = 'https://api.telegram.org/'. $this->prefix. $this->token.'/setwebhook?url='.$url;
        $query = new Query($url);
        $set = $query->get();
    }
