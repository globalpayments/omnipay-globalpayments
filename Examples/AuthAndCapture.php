<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Genius');
$gateway->setMerchantName('Test Shane Logsdon');
$gateway->setMerchantSiteId('BKHV2T68');
$gateway->setMerchantKey('AT6AN-ALYJE-YF3AW-3M5NN-UQDG1');

/**
 * An 'authorize' transaction behaves the same was a 'purchase' except that the
 * transaction is not automatically captured (finalized). A subsequent 'capture'
 * transaction is required to receive funding for an 'authozize' transaction.
 */

$formData = array(
    'number' => '5454545454545454',
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

$authReponse = $gateway->authorize(
    array(
        'card' => $formData,
        'currency' => 'USD',
        'amount' => '45.67',
        'description' => 'AuthAndCapture.php example'
    )
)->send();

sleep(5);

$captureResponse = $gateway->capture(
    array(
        'transactionReference' => $authReponse->getTransactionReference(),
        'amount' => '5.00', // optional; used for specifying an amount different than the original auth
    )
)->send();

if ($captureResponse->isSuccessful()) {
    echo 'Success! Credit card transaction captured via Genius gateway. Transaction ID is: ' . $authReponse->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $captureResponse->getMessage();
}
