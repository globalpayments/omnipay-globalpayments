<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Genius');
$gateway->setMerchantName('Test Shane Logsdon');
$gateway->setMerchantSiteId('BKHV2T68');
$gateway->setMerchantKey('AT6AN-ALYJE-YF3AW-3M5NN-UQDG1');

/**
 * Voids are processed using basic Omnipay methodology, simply pass in
 * the target transaction's reference number. 
 */

$formData = array(
    'number' => '4012000098765439',
    'expiryMonth' => '12',
    'expiryYear' => '2025',
    'cvv' => '999',
    'type' => CardType::VISA, // required for Transit gateway only
    'firstName' => 'Tony',
    'lastName' => 'Smedal',
    'billingAddress1' => '1 Heartland Way',
    'billingCity' => 'Jeffersonville',
    'billingState' => 'IN',
    'billingCountry' => 'USA',
    'billingPostCode' => '47130'
);

// Purchase
$purchaseResponse = $gateway->purchase(
    array(
    'card' => $formData,
    'currency' => 'USD',
    'amount' => 11.20
    )
)->send();

sleep(1);

// Void
$voidResponse = $gateway->void(
    array(
        'transactionReference' => $purchaseResponse->getTransactionReference(),
    )
)->send();

if ($voidResponse->isSuccessful()) {
    echo 'Transaction successfully voided!' . PHP_EOL;
    echo 'Transaction ID for the purchase is: '. $purchaseResponse->getTransactionReference() . PHP_EOL;
    echo 'Transaction ID for the refund is: ' . $voidResponse->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
