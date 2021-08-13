<?php
// https://хост.ru/wp-admin
// Внешний вид -> Редактор Тем -> Функции Темы
// если работает плагин Contact From 7
//https://moometric.com/integrations/wp/contact-form-7-zapier-webhook-json-post/

add_action( 'wpcf7_mail_sent', 'custom_name' );
function custom_name( $form ){
	$submission = WPCF7_Submission::get_instance();
    $data = $submission->get_posted_data();
// 	$request = [];
// 	$request[] = $data;
	$url = 'https://host.ngrok.io/path/path';
	wp_remote_post($url, array(
        'method' => 'POST',
//         'headers' => $headers,
        'httpversion' => '1.0',
        'sslverify' => false,
        'body' => json_encode($data))
    );
}
