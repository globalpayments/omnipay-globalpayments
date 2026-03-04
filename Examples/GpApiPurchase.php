<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\GpApi');
$gateway->setAppId('your-app-id');
$gateway->setAppKey('your-app-key');
$gateway->setChannel('CNP'); // Card Not Present
$gateway->setCountry('US');
$gateway->setEnvironment('TEST'); // or 'PRODUCTION'

/**
 * Card transactions can be processed using the core parameters from Omnipay's
 * CreditCard class. The GpApi gateway supports standard credit card processing
 * through the Global Payments Unified Commerce Platform.
 */

$formData = array(
    'number' => '4263970000005262',
    'expiryMonth' => '12',
    'expiryYear' => '2026',
    'cvv' => '123',
    'firstName' => 'Joe',
    'lastName' => 'Smith',
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
        'amount' => '45.67',
        'description' => 'GpApiPurchase.php example'
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! Credit card transaction processed via GpApi gateway. Transaction ID is: ' . $response->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
