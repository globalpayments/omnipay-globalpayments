<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

class CreateCardRequest extends AbstractGpApiRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('SUCCESS', 'VERIFIED'));

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
