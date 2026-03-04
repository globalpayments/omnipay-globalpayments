<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

class AuthorizeRequest extends AbstractGpApiRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('SUCCESS'));

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

        return $chargeMe->execute();
    }
}
