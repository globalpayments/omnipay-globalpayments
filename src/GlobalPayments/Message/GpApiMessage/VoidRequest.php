<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractGpApiRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('SUCCESS'));

        return Transaction::fromId($this->getTransactionReference())
            ->reverse()
            ->execute();
    }
}
