<?php

namespace Classes\Tilda;
use \Exception;

class UploadTildaJs 
{
    public $amo;

    public function __construct()
    {
        $this->l = logger('crm/AMOCRM');
    }

    public function uploadJs()
    {
        $attachment_location = ROOT . "/insert.js.js";
        if (file_exists($attachment_location)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: text/javascript");
            header("Content-Length:".filesize($attachment_location));
            header("Content-Disposition: attachment; filename=basketFormSubmitting.js");
            readfile($attachment_location);
            die();        
        } else {
            die("Error: File not found.");
        }
    }
}
