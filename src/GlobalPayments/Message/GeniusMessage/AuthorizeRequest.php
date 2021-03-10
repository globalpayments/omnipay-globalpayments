<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

class AuthorizeRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        $chargeMe = $this->gpCardObj;

        return $chargeMe->authorize($this->getAmount())
            ->withAddress($this->gpBillingAddyObj)
            ->withCurrency($this->getCurrency())
            ->withDescription($this->getDescription())
            ->withClientTransactionId($this->getTransactionId())
            ->withStoredCredential($this->gpStoredCredObj)
            ->execute();
    }    
}
