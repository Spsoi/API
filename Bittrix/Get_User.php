<?php
// получаем Юзера по ID
global $USER;
$ID = $USER->GetID();
$rsUser = CUser::GetByID($ID);   // return array
$arUser = $rsUser->Fetch();                 //return bject
