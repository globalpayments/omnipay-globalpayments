<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use Omnipay\GlobalPayments\Message\AbstractResponse;

class GeniusResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        if (!empty($this->getTransactionReference()) && strpos($this->response->responseMessage, 'FAILED') === false) {
            return true;
        } elseif($this->request instanceof CreateCardRequest) {
            return !empty($this->getCardReference());
        }

        return false;
    }
}
