<?php
if ($_GET['access_key'] !== "12131"){
	wp_die('У вас нет доступа');
}
require dirname( __FILE__, 3 ) . '/plugins/yoomoney-wp/includes/yookassa/lib/autoload.php';
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationCanceled;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;


$source = file_get_contents('php://input');
$json = json_decode($source, true);
$client = new Client();
$client->setAuth(get_option('shopid'), get_option('secretkey'));


if ($json['event'] === 'payment.canceled') {
	$paymentId = $json['object']['id'];
	$idempotenceKey = uniqid('', true);

	$response = $client->cancelPayment(
	  $paymentId,
	  $idempotenceKey
	);
}

elseif ($json['event'] === 'payment.waiting_for_capture') {
	$paymentId = $json['object']['id'];
	$idempotenceKey = uniqid('', true);
	$response = $client->capturePayment(
	  array(
	      'amount' => array(
	          'value' => $json['amount']['value'],
	          'currency' => $json['amount']['currency'],
	      	),
	  	),
	  $paymentId,
	  $idempotenceKey
	);
}

elseif ($json['event'] === 'payment.succeeded') {
	# code...
}

else {
	echo "Ошибка";
}