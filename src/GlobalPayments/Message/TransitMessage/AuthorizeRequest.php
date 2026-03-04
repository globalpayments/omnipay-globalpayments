<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use Exception;

class AuthorizeRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        $chargeMe = $this->gpCardObj->authorize($this->getAmount());

        if (!empty($this->getCurrency())) {
            $chargeMe = $chargeMe->withCurrency($this->getCurrency());
        }
        if (!empty($this->gpBillingAddyObj)) {
            $chargeMe = $chargeMe->withAddress($this->gpBillingAddyObj);
        }
        if (!empty($this->getDescription())) {
            $chargeMe = $chargeMe->withDescription($this->getDescription());
        }
        if (!empty($this->getTransactionId())) {
            $chargeMe = $chargeMe->withClientTransactionId($this->getTransactionId());
        }
        if (!empty($this->gpStoredCredObj)) {
            $chargeMe = $chargeMe->withStoredCredential($this->gpStoredCredObj);
        }

        try {
            return $chargeMe->execute();
        } catch (Exception $e) {
            return $e;
        }
    }
}
