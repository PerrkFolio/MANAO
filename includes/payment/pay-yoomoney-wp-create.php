<?php

/**
 * Получить ссылку на оплату
 * @param $premium_product_id - это типа платежа, Поднять в топ (1475) или Премиум размещение (1474)
 * @param $item_id
 * @param $email
 * @param $price
 * @param $pay_title
 * @param $payment_method
 * @return mixed
 * @throws \YooKassa\Common\Exceptions\ApiException
 * @throws \YooKassa\Common\Exceptions\BadApiRequestException
 * @throws \YooKassa\Common\Exceptions\ForbiddenException
 * @throws \YooKassa\Common\Exceptions\InternalServerError
 * @throws \YooKassa\Common\Exceptions\NotFoundException
 * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
 * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
 * @throws \YooKassa\Common\Exceptions\UnauthorizedException
 */
function get_pay_link($premium_product_id, $item_id, $email, $price, $pay_title, $payment_method){
    require dirname( YK_PLUGIN_FILE ) . '/includes/yookassa/lib/autoload.php';
    $client = new YooKassa\Client;
    $client->setAuth(get_option('shopid'), get_option('secretkey'));
	$user_id = get_current_user_id();
	$user = get_userdata($user_id);
	$return_url = get_option('tyurl'); // испраивть на thank_you_url

    global $wpdb;
	$wpdb->insert(
		$wpdb->prefix . "payments",
		array(
			'payment_user_id' => $user_id,
			'payment_amount' => $price,
			'payment_title' => $pay_title
		),
		array(
			'%d',
			'%d',
			'%s'
		)
	);
	$payment_id = $wpdb->insert_id;

	$payment_names = Array(
		1 => 'webmoney',
		2 => 'yandex_money',
		3 => 'qiwi',
		4 => 'bank_card',
		5 => 'bank_card',
		6 => '',
		7 => 'mobile_balance',
		8 => 'mobile_balance',
		9 => 'mobile_balance',
		10 => 'alfabank',
		11 => 'sberbank'
	);

//    $payment_names[$payment_method] - использовать так, не должен быть NULL!!!
	switch ($payment_method) {
	    case 1:
	        $pay_method_type = $payment_names[4];
	        break;

	    case 2:
	        $pay_method_type = $payment_names[3];
	        break;

	    case 3:
	        $pay_method_type = $payment_names[1];
	        break;

	    case 4:
	        $pay_method_type = $payment_names[2];
	        break;

	    case 5:
	        $pay_method_type = $payment_names[10];
	        break;

        default:
            $pay_method_type = 'bank_card';
            break;
	}

  	$idempotenceKey = uniqid('', true);

    $response = $client->createPayment(
      	array(
          	'amount' => array(
              	'value' => $price,
              	'currency' => 'RUB',
          	),
          	'payment_method_data' => array(
              	'type' => $pay_method_type,
          	),
          	'confirmation' => array(
              	'type' => 'redirect',
              	'return_url' => $return_url,
          	),
          	"receipt" => array(
          		"customer" => array(
          			"full_name" => $user->first_name && $user->last_name ? $user->first_name . ' ' . $user->last_name : $user->user_login,
          			"email" => $email
          		),
          		"items" => array(
          			array(
          				"description" => $pay_title,
          				"quantity" => "1.00",
          				"amount" => array(
          					"value" => $price,
          					"currency" => "RUB"
          				),
          				"vat_code" => "1",
          				"payment_mode" => "full_payment",
          				"payment_subject" => "service"
          			)
          		)
          	),
          	'description' => $pay_title,
          	'metadata' => array(
          		'user_id' => $user_id,
          		'payment_id' => $payment_id,
                'item_id' => $item_id,
                'payment_type' => $premium_product_id
          	)
      	),
      	$idempotenceKey
  	);

  	//get confirmation url
    return $response->getConfirmation()->getConfirmationUrl();
}
