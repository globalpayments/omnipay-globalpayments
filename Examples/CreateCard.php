<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_McU0AgBkx2EAldEfhhtolMw0RnvahBQAnXFdLYga-Q');

/**
 * 'Card reference' in the context of Omnipay/Global-Payments integrations is
 * synonymous with Multi-Use Tokens. For Heartland, a MUT can
 * represent the card number and exipration date.
 */


$formData = array(
    'number' => '5454545454545454',
    'expiryMonth' => '12',
    'expiryYear' => '2025',
    'cvv' => '123',
    'type' => CardType::MASTERCARD, // required for Transit gateway only
    'firstName' => 'Tony',
    'lastName' => 'Smedal',
    'billingAddress1' => '1 Heartland Way',
    'billingCity' => 'Jeffersonville',
    'billingState' => 'IN',
    'billingCountry' => 'USA',
    'billingPostCode' => '47130'
);

$response = $gateway->createCard(
    array(
        'card' => $formData,
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! Card-reference successfully generated. Card reference is: ' . $response->getCardReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
