<?php

include_once 'vendor/autoload.php';

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

/**
 * For testing purposes only. In production this should be handled client-side
 * using the Global Paymens JS library (https://github.com/globalpayments/globalpayments-js).
 */
function getSingleUseToken()
{
    $publicKey = 'pkapi_cert_3ZjQJbCO9rygPdXFkd';
    $cardNo = '5454545454545454';
    $expMonth = '12';
    $expYear = '2025';
    $cvv = '123';

    $curl = curl_init();

    curl_setopt_array(
        $curl, array(
        CURLOPT_URL => 'https://cert.api2.heartlandportico.com/Hps.Exchange.PosGateway.Hpf.v1/api/token?api_key=' . $publicKey,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"object":"token","token_type":"supt","card":{"number": ' . $cardNo . ', "cvc": ' . $cvv . ', "exp_month": ' . $expMonth . ', "exp_year": ' . $expYear . '}}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        )
    );

    $responseAsObj = json_decode(curl_exec($curl));

    curl_close($curl);

    return $responseAsObj->token_value;
}
