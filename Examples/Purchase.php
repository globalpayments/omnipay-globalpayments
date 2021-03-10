<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Transit');
$gateway->setDeviceId('88500000322601');
$gateway->setMerchantId('885000003226');
$gateway->setUserName('TA5748226');
$gateway->setTransactionKey('DPJLWWAD1MOAX8XPCHZAXP15U0UME5U0');

/**
 * Card transactions can be processed using the core parameters from Omnipay's
 * CreditCard class. However, when using the Transit gateway specifically (as
 * this example does) it is important to use one additional parameter: 'type'.
 * This allows the proper elements to be sent for specific card brands as required
 * by the Transit gateway. 
 */

$formData = array(
    'number' => '4012000098765439',
    // 'number' => '5454545454545454', // will result in a DNH decline when used w/Transit gateway
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

$response = $gateway->purchase(
    array(
        'card' => $formData,
        'currency' => 'USD',
        'amount' => '45.67',
        'description' => 'Purchase.php example'
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! Credit card transaction processed via Transit gateway. Transaction ID is: ' . $response->getTransactionReference();
} else {
    echo 'Failure! Something went wrong: ' . $response->getMessage();
}
