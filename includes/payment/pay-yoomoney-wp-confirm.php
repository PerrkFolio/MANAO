<?php
  $price = the_field('premium_price', 'options');
  $paymentId = $_POST['payment_id'];
  $idempotenceKey = uniqid('', true);
  $response = $client->capturePayment(
      array(
          'amount' => array(
              'value' => $price,
              'currency' => 'RUB',
          ),
      ),
      $paymentId,
      $idempotenceKey
  );
?>
