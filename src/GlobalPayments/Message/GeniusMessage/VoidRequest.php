<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        return Transaction::fromId($this->getTransactionReference())
            ->void()
            ->execute();
    }
}
