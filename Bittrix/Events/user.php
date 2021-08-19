<?php
// https://dev.1c-bitrix.ru/api_help/main/events/index.php
// перед тем как выйдет из аккаунта
AddEventHandler("main", "OnAfterUserLogin", array("AmoAfterUserRegister", "OnAfterIBlockElementAddHandler")); // кастом
