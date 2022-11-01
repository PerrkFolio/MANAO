<?php
  $paymentId = $_POST['payment_id'];
  $idempotenceKey = uniqid('', true);

  $response = $client->cancelPayment(
      $paymentId,
      $idempotenceKey
  );
?>
