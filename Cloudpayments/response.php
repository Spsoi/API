<?php
Ответ на запрос отправлять сразу и выполнять работу дальше

  ignore_user_abort(true);
  set_time_limit(0);
  ob_start();
  echo json_encode(['code' => 0]); // если нужно вернуть какие-то данные
  header('Connection: close');
  header('Content-Length: '.ob_get_length());
  ob_end_flush();
  ob_flush();
  flush();

//  .... тут код
return json_encode(['code' => 0]);
