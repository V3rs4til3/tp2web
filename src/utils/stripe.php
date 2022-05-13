<?php
require_once '../vendor/autoload.php';

$stripek_key = 'sk_test_51ENk8JEFQ1f9nnBcLnmatkKU7yQ12ZS8Tt60Cu3h2gcElVUKCx9Ocw25mjyghMgJTKPu6nf84ErNTXIJLUautw420026N5ZRRH';

$stripe = new \Stripe\StripeClient($stripek_key);

$payment = $stripe->paymentMethods->create([
    'type' => 'card',
    'card' => [
        'number' => '4242424242424242',
        'exp_month' => 12,
        'exp_year' => 2023,
        'cvc' => '123'
    ]
]);
$intent = $stripe->paymentIntents->create([
    'amount' => 4200,
    'currency' => 'cad',
    'confirm' => true,
    'description' => 'Facture - 1',
    'payment_method' => $payment->id
]);

$stripe->refunds->create(['payment_intent' => $intent->id]);

echo '<pre>';
var_dump($intent);