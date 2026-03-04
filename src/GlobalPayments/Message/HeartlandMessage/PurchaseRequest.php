<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class PurchaseRequest extends AbstractHeartlandRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00', '10'));

        $chargeMe = $this->gpCardObj->charge($this->getAmount());

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

        return $chargeMe->execute();
    }
}
