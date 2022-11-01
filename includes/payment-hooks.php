<?php
////create payment link
function create_premium_checkout_link($premium_product_id, $item_id, $email, $price, $pay_title, $payment_method){
	return "";
	// $user_id = get_current_user_id();
	// echo $user_id;
	// // return "https://ya.ru";
	// require dirname( __FILE__, 4 ) . '/plugins/yoomoney-wp/includes/yookassa/lib/autoload.php';
	// use YooKassa\Client;

	// $user = get_userdata($user_id);

	// echo dirname( __FILE__, 4 ) . '/plugins/yoomoney-wp/includes/yookassa/lib/autoload.php';
	// $client = new Client();
	// $client->setAuth(get_option('shopid'), get_option('secretkey'));
	// //$price = the_field('premium_price', 'options');
	// //$price = $_POST['premium_price'];
	// $return_url = get_option('tyurl');

	// $wpdb->insert(
	// 	$wpdb->prefix . "payments",
	// 	array(
	// 		'payment_user_id' => $user_id,
	// 		'payment_amount' => $price,
	// 		'payment_title' => $pay_title
	// 	),
	// 	array(
	// 		'%d',
	// 		'%d',
	// 		'%s'
	// 	)
	// );
	// $payment_id = $wpdb->insert_id;

	// $payment_names = Array(
	// 	1 => 'webmoney',
	// 	2 => 'yandex_money',
	// 	3 => 'qiwi',
	// 	4 => 'bank_card',
	// 	5 => 'bank_card',
	// 	6 => '',
	// 	7 => 'mobile_balance',
	// 	8 => 'mobile_balance',
	// 	9 => 'mobile_balance',
	// 	10 => 'alfabank',
	// 	11 => 'sberbank'
	// );

	// switch ($payment_method) {
	//     case 1:
	//         $pay_method_type = $payment_names[4];
	//         break;

	//     case 2:
	//         $pay_method_type = $payment_names[3];
	//         break;

	//     case 3:
	//         $pay_method_type = $payment_names[1];
	//         break;

	//     case 4:
	//         $pay_method_type = $payment_names[2];
	//         break;

	//     case 5:
	//         $pay_method_type = $payment_names[10];
	//         break;
	    
	// }

 //  	$idempotenceKey = uniqid('', true);
 //  	$response = $client->createPayment(
 //      	array(
 //          	'amount' => array(
 //              	'value' => $price,
 //              	'currency' => 'RUB',
 //          	),
 //          	'payment_method_data' => array(
 //              	'type' => $pay_method_type,
 //          	),
 //          	'confirmation' => array(
 //              	'type' => 'redirect',
 //              	'return_url' => $return_url,
 //          	),
 //          	"receipt" => array(
 //          		"customer" => array(
 //          			"full_name" => $user->first_name && $user->last_name ? $user->first_name . ' ' . $user->last_name : $user->user_login,
 //          			"email" => $email
 //          		),
 //          		"items" => array(
 //          			array(
 //          				"description" => $pay_title,
 //          				"quantity" => "1.00",
 //          				"amount" => array(
 //          					"value" => $price,
 //          					"currency" => "RUB"
 //          				),
 //          				"vat_code" => "1",
 //          				"payment_mode" => "full_payment",
 //          				"payment_subject" => "service"
 //          			)
 //          		)
 //          	),
 //          	'description' => $pay_title,
 //          	'metadata' => array(
 //          		'user_id' => $user_id,
 //          		'payment_id' => $payment_id
 //          	)
 //      	),
 //      	$idempotenceKey
 //  	);

 //  	//get confirmation url
 //  	$confirmationUrl = $response->getConfirmation()->getConfirmationUrl();
 //  	$data['status'] = 200;
 //  	$data['url'] = $confirmationUrl;
 //  	//echo json_encode($data);
 //  	return $confirmationUrl;
}

//
////clear cart to ensure it is only one premium feature
//add_filter('woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart', 20, 3);
//function remove_cart_item_before_add_to_cart($passed, $product_id, $quantity)
//{
//    if (!WC()->cart->is_empty())
//        WC()->cart->empty_cart();
//    return $passed;
//}
//
//// Add custom note as custom cart item data
//add_filter('woocommerce_add_cart_item_data', 'get_custom_product_note', 30, 2);
//function get_custom_product_note($cart_item_data, $product_id)
//{
//    if (isset($_GET['post']) && !empty($_GET['post'])) {
//        $cart_item_data['post'] = sanitize_text_field($_GET['post']);
//    }
//    return $cart_item_data;
//}
//
//// Save and display product note in orders and email notifications (everywhere)
//add_action('woocommerce_checkout_create_order_line_item', 'add_custom_note_order_item_meta', 20, 4);
//function add_custom_note_order_item_meta($item, $cart_item_key, $values, $order)
//{
//    if (isset($values['post'])) {
//        $item->update_meta_data('post',  $values['post']);
//    }
//}
//
//add_filter('woocommerce_billing_fields', 'basic_billing_fields', 20);
//function basic_billing_fields($fields)
//{
//    foreach(array_keys($fields) as $one){
//        unset($fields[$one]);
//    }
//
//    return $fields;
//}
//
//
//add_action( 'template_redirect', 'woo_custom_redirect_after_purchase' );
//function woo_custom_redirect_after_purchase() {
//	global $wp;
//	if ( is_checkout() && !empty( $wp->query_vars['order-received'] ) ) {
//        wp_redirect(basic_get_template_page_link('page-thank-you.php'));
//		exit;
//	}
//}
//
if(!function_exists('basic_top_item_in_time')){
    function basic_top_item_in_time($item_id){
        $current_time = time();
        update_post_meta($item_id, 'item_updated_time', $current_time);
    }
}

////order completed, make premium
//add_action('woocommerce_order_status_completed', 'basic_order_completed', 10, 1);
//function basic_order_completed($order_id){
//    $order = wc_get_order($order_id);
//    $product = array_shift($order->get_items());
//    $item_id = $product->get_meta_data('post')[0]->value;
//    if($product->get_product_id() == get_field('premium_item_product', 'options')){
//        update_field('premium', true, $item_id);
//        update_post_meta($item_id, 'premium_start', time());
//    }else if($product->get_product_id() == get_field('to_top_item_product', 'options')){
//        basic_top_item_in_time($item_id);
//    }
//}

// basic_top_item_in_time(1547);