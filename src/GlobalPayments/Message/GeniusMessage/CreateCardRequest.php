<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

class CreateCardRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        $chargeMe = $this->gpCardObj;

        return $chargeMe->verify()
            ->withRequestMultiUseToken(true)
            ->withAddress($this->gpBillingAddyObj)
            ->withDescription($this->getDescription())
            ->withClientTransactionId($this->getTransactionId())
            ->execute();
    }    
}
