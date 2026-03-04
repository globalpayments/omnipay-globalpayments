<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

use GlobalPayments\Api\Entities\Transaction;

class CaptureRequest extends AbstractGpApiRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('SUCCESS'));

        return Transaction::fromId($this->getTransactionReference())
            ->capture($this->getAmount())
            ->execute();
    }
}
