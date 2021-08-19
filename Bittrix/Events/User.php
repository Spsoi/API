<?php
// https://dev.1c-bitrix.ru/api_help/main/events/index.php
// после того как вышел из аккаунта
AddEventHandler("main", "OnAfterUserLogin", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом
