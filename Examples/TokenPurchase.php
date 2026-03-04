<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/Utilities/Utils.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_McU0AgBkx2EAldEfhhtolMw0RnvahBQAnXFdLYga-Q');

/**
 * 'Token' in the context of Omnipay/Global-Payments integrations refers to
 * Single-Use Tokens. Usually a SUT is generated client-side and then used in
 * place of raw card data (mainly the card number). For Heartland, a SUT can
 * represent the number, exipration date, and CVV.
 */


$formData = array(
    // 'number' => '5454545454545454',
    // 'expiryMonth' => '12',
    // 'expiryYear' => '2025',
    // 'cvv' => '123',
    'type' => CardType::MASTERCARD, // required for Transit gateway only
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
        'token' => getSingleUseToken(),
        'card' => $formData,
        'currency' => 'USD',
        'amount' => '45.67',
        'description' => 'TokenPurchase.php example'
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! Credit card transaction processed via Heartland gateway. Transaction ID is: ' . $response->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
