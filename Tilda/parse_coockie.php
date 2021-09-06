<?php
$rawData = \file_get_contents('php://input');
$str = urldecode($rawData);
$l->log($str);

parse_str($rawData, $array);
$l->log($array);
$data['rawCOOKIES']   = !empty( $array['COOKIES']) ? $array['COOKIES'] : null;
if (isset($data['rawCOOKIES'])) {
    $rawCookie = explode(';',$data['rawCOOKIES'] );
    $rawArrCookies = [];
    foreach ($rawCookie as $key => $cookie) {
        $rawArrCookies[$key] = explode('=', $rawCookie[$key]);
    }
    foreach ($rawArrCookies as $cookies) {
        $data['COOKIES'][ trim($cookies[0])] = trim($cookies[1]);
    }
    $data = $data['COOKIES'];
}
