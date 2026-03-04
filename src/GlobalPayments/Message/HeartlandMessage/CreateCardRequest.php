<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class CreateCardRequest extends AbstractHeartlandRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00', '85'));

        $chargeMe = $this->gpCardObj->verify()->withRequestMultiUseToken(true);

        if (!empty($this->gpBillingAddyObj)) {
            $chargeMe = $chargeMe->withAddress($this->gpBillingAddyObj);
        }
        if (!empty($this->getDescription())) {
            $chargeMe = $chargeMe->withDescription($this->getDescription());
        }
        if (!empty($this->getTransactionId())) {
            $chargeMe = $chargeMe->withClientTransactionId($this->getTransactionId());
        }

        return $chargeMe->execute();
    }
}
