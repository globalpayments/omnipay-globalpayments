<?php

include_once 'vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\AccountType;
use GlobalPayments\Api\Entities\Enums\CheckType;
use GlobalPayments\Api\Entities\Enums\SecCode;
use Omnipay\GlobalPayments\ECheck;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_McU0AgBkx2EAldEfhhtolMw0RnvahBQAnXFdLYga-Q');

/**
 * For ACH transactions we try to mimic credit card handling as closely as possible.
 * However, since there are required data elements, such as 'SecCode', that do not
 * apply to credit/debit cards, some differences are unavoidable. These unique
 * data elements can set using the setter methods shown below, or as an array that
 * is passed as the argument for ECheck($arrayOfAchInfo).
 */

$eCheck = new ECheck();
$eCheck->setSecCode(SecCode::WEB);
$eCheck->setAccountType(AccountType::CHECKING);
$eCheck->setCheckType(CheckType::PERSONAL);
$eCheck->setBillingAddress1('6860 Dallas Pkwy');
$eCheck->setBillingPostcode('750241234');
$eCheck->setCheckHolderName('Tony Smedal');

/**
 * Account number and routing number can be omitted if using Heartland single-use
 * tokens in normal Omnipay fashion: 'token' => '$sut'
 */
$eCheck->setAccountNumber('1357902468');
$eCheck->setRoutingNumber('122000030');

$response = $gateway->purchase(
    array(
        'check' =>$eCheck,
        'currency' => 'USD',
        'amount' => '56.78',
        'description' => 'AchPurchase.php example'
    )
)->send();

if ($response->isSuccessful()) {
    echo 'Success! ACH transaction processed via Heartland gateway. Transaction ID is: ' . $response->getTransactionReference();
} else {
    echo 'Failure! Something went wrong.';
}
