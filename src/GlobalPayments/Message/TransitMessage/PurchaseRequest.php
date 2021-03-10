<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use Exception;

class PurchaseRequest extends AuthorizeRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));
        
        $chargeMe = $this->gpCardObj;

        try {
            return $chargeMe->charge($this->getAmount())
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
