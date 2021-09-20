<?php
// Подписка, удаление, получение данных
// Роут
// Подписка на вебхук для бота
// https://domain?url=https://domain
$route->get('webhook', 'App\Controllers\Crm\Controller@setWebHook');
// отписка от вебхук для бота
$route->get('delwebhook', 'App\Controllers\Crm\Controller@deleteWebHook');
// отписка от вебхук для бота
$route->get('data', 'App\Controllers\Crm\Controller@telegramPackage');

// Контроллер
namespace App\Controllers\Crm;
use Components\Auth;
use App\Controllers\Authenticate;
use App\Jobs\DataBase\DataBaseJob;
use App\Jobs\TelegramApi\TelegramApiJob;
use Components\Request;

class Controller extends \Core\Controllers\Controller
{
    public function setWebHook() {
        $this->l->log('ConnectController->setWebHook');
        $job = new TelegramApiJob;
        $job->setWebHookJob();
        return true;
    }

    public function deleteWebHook() {
        $job = new TelegramApiJob;
        $job->deleteWebHookJob();
        return true;
    }

    public function telegramPackage() {
        $job = new TelegramApiJob;
        $job->telegramPackageJob();
        return true;
    }

}

namespace Classes\TelegramApi;
use App\Models\Manager;
use \Exception;
use Components\Request;
use Components\Curl\Query;

class TelegramApiClass
{
    public  $prefix = 'bot';
    public  $token = 'tokenbot';

    public function __construct()
    {
        $this->l = logger('path');
    }

    public function setWebHookClass () {
        $this->l->log('setWebHookClass');
        $url = $_REQUEST['url'];
        $this->l->log($url);
        $this->l->log( $this->token);
        $url = 'https://api.telegram.org/'. $this->prefix. $this->token.'/setwebhook?url='.$url;
        $this->l->log('url');
        $query = new Query($url);
        $set = $query->get();
        $this->l->log($set);
    }

    public function deleteWebHookClass () {
        $this->l->log('deleteWebHookClass');
        $url = 'https://api.telegram.org/'. $this->prefix. $this->token.'/deleteWebhook';
        $query = new Query($url);
        $del = $query->get();
        $this->l->log($del);
    }

    public function telegramPackageClass () {
        $this->l->log('telegramPackageClass');
        $fromTelegram = json_decode(file_get_contents('php://input'), TRUE);
        $this->l->log('fromTelegram');
        $this->l->log($fromTelegram);
        $this->l->log($fromTelegram['message']);

        // $url = $request->input('url');
        // $query = new Query;
        // $query->get();
    }
}
?>
