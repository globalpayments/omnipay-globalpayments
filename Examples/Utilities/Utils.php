<?php

/**
 * For testing purposes only. In production this should be handled client-side
 * using the Global Payments JS library (https://github.com/globalpayments/globalpayments-js).
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
        $curl,
        array(
            CURLOPT_URL => 'https://cert.api2.heartlandportico.com/Hps.Exchange.PosGateway.Hpf.v1/api/token?api_key=' . $publicKey,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"object":"token","token_type":"supt","card":{"number": ' . $cardNo . ', "cvc": ' . $cvv . ', "exp_month": ' . $expMonth . ', "exp_year": ' . $expYear . '}}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        )
    );

    $responseAsObj = json_decode(curl_exec($curl));

    curl_close($curl);

    return $responseAsObj->token_value;
}
