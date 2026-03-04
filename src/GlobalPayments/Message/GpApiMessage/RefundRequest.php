<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

use GlobalPayments\Api\Entities\Transaction;

class RefundRequest extends AbstractGpApiRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('SUCCESS'));

        return Transaction::fromId($this->getTransactionReference())
            ->refund($this->getAmount())
            ->withCurrency($this->getCurrency())
            ->execute();
    }
}
