<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_McU0AgBkx2EAldEfhhtolMw0RnvahBQAnXFdLYga-Q');

/**
 * Refunds are processed using basic Omnipay methodology, simply pass in
 * the target transaction's reference number. 
 */

$formData = array(
    'number' => '5454545454545454',
    'expiryMonth' => '12',
    'expiryYear' => '2025',
    'cvv' => '999',
    'type' => CardType::MASTERCARD, // required for Transit gateway only
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
$refundResponse = $gateway->refund(
    array(
        'transactionReference' => $purchaseResponse->getTransactionReference(),
        'amount' => '5.00', // required; refund-amount <= purchase-amount
        'description' => 'Customer returned merchandise.', // optional
        'currency' => 'USD' // required
    )
)->send();

if ($refundResponse->isSuccessful()) {
    echo 'Transaction successfully refunded!' . PHP_EOL;
    echo 'Transaction ID for the purchase is: '. $purchaseResponse->getTransactionReference() . PHP_EOL;
    echo 'Transaction ID for the refund is: ' . $refundResponse->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
