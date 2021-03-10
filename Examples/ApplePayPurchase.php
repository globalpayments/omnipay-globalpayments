<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\MobilePaymentMethodType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Genius');
$gateway->setMerchantName('Test Shane Logsdon');
$gateway->setMerchantSiteId('BKHV2T68');
$gateway->setMerchantKey('AT6AN-ALYJE-YF3AW-3M5NN-UQDG1');

$formData = array(
    'mobileType' => MobilePaymentMethodType::APPLEPAY, // required for Apple Pay
    'firstName' => 'Tony',
    'lastName' => 'Smedal',
    'billingAddress1' => '1 Heartland Way',
    'billingCity' => 'Jeffersonville',
    'billingState' => 'IN',
    'billingCountry' => 'USA',
    'billingPostCode' => '47130'
);

$response = $gateway->purchase(
    array(
        'card' => $formData,
        'currency' => 'USD',
        'amount' => '56.78',
        'token' => 'ew0KCSJ2ZXJzaW9uIjogIkVDX3YxIiwNCgkiZ==',
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! Credit card transaction processed via Transit gateway. Transaction ID is: ' . $response->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
