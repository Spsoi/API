<?php
// любое событие перед отправкой по почте
AddEventHandler("main", "OnBeforeEventAdd", array("CustomEventHandlersClass", "OnBeforeEventAdd"));
class CustomEventHandlersClass{
	function OnBeforeEventAdd(&$event, &$lid, &$arFields, &$messageId, &$files, &$languageId){
	$data = [
		'event' => $event,
		'arFields' => $arFields,
		'messageId' => $messageId,
		'files' => $files,
		'languageId' => $languageId,
	];

	self::curl($data);

	    switch ($event){
	        case 'USER_PASS_CHANGED':
	            self::SendNewPass($lid, $arFields);
	            break;
	    }
		
        if( in_array($messageId, array(92))){
	       self::AddPriceListFileForMail($event, $lid, $arFields, $messageId, $files, $languageId);
	    }
	}
}
