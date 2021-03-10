<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_McU0AgBkx2EAldEfhhtolMw0RnvahBQAnXFdLYga-Q');

/**
 * Purchase example using a Card Reference as well as two key card-on-file elements
 */

$formData = array(
    'type' => CardType::VISA, // required for Transit gateway only
    'firstName' => 'Tony',
    'lastName' => 'Smedal',
    'billingAddress1' => '1 Heartland Way',
    'billingCity' => 'Jeffersonville',
    'billingState' => 'IN',
    'billingCountry' => 'USA',
    'billingPostCode' => '47130',
    'cardBrandTransId' => '123456789',
    'storedCredInitiator' => StoredCredentialInitiator::MERCHANT,
);

$response = $gateway->purchase(
    array(
        'cardReference' => 'E7LxbO22Af9gKxAECJC65454', // obtained using CreateCard.php
        'card' => $formData,
        'currency' => 'USD',
        'amount' => '45.67',
        'description' => 'Purchase.php example'
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! Credit card transaction processed via Heartland gateway. Transaction ID is: ' . $response->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
