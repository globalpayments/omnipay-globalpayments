<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use Exception;

class AuthorizeRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));
        
        $chargeMe = $this->gpCardObj;

        try {
            return $chargeMe->authorize($this->getAmount())
                ->withAddress($this->gpBillingAddyObj)
                ->withCurrency($this->getCurrency())
                ->withDescription($this->getDescription())
                ->withClientTransactionId($this->getTransactionId())
                ->withStoredCredential($this->gpStoredCredObj)
                ->execute();
        } catch (Exception $e) {
            return $e;
        }
    }
}
