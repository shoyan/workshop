<?php
require 'vendor/autoload.php';

if (empty($_ENV['STRIPE_API_KEY'])) {
    echo "STRIPE_API_KEY not found. Please set STRIPE_API_KEY your environment.\n\n";
    echo "export STRIPE_API_KEY=\"your stripe api key\"\n";
    exit(1);
}

$stripe = new \Stripe\StripeClient($_ENV['STRIPE_API_KEY']);
$data = $stripe->charges->retrieve(
  'ch_3NmGmrKFTs0Yrp0j1LZamuIp',
  []
);

var_dump($data);