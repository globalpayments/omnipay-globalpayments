<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class CaptureRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        return Transaction::fromId($this->getTransactionReference())
            ->capture($this->getAmount())
            ->execute();
    }
}
