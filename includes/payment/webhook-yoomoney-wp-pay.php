<?php
  use YooKassa\Client;
  use YooKassa\Model\NotificationEventType;

  $client = new Client();
  $client->setAuthToken('<Bearer Token>');

  $response = $client->addWebhook([
      "event" => NotificationEventType::PAYMENT_SUCCEEDED,
      "url"   => "https://www.merchant-website.com/notification_url",
  ]);
?>