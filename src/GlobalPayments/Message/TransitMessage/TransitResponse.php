<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\Entities\Transaction;
use Omnipay\GlobalPayments\Message\AbstractResponse;

class TransitResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        if ($this->response instanceof Transaction) {
            return in_array(
                $this->response->responseCode, $this->request->getGoodReponseCodes()
            );
        }

        return false;
    }
}
