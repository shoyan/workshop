<?php
require 'vendor/autoload.php';

if (empty($_ENV['STRIPE_API_KEY'])) {
    echo "STRIPE_API_KEY not found. Please set STRIPE_API_KEY your environment.\n\n";
    echo "export STRIPE_API_KEY=\"your stripe api key\"\n";
    exit(1);
}

$stripe = new \Stripe\StripeClient($_ENV['STRIPE_API_KEY']);

$checkout_session = $stripe->checkout->sessions->create([
  'line_items' => [[
    'price_data' => [
      'currency' => 'jpy',
      'product_data' => [
        'name' => 'T-shirt',
      ],
      'unit_amount' => 2000,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => 'http://localhost:4242/success.html',
  'cancel_url' => 'http://localhost:4242/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
?>