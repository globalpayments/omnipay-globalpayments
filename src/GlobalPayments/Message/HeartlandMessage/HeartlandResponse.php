<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use Omnipay\GlobalPayments\Message\AbstractResponse;
use Omnipay\GlobalPayments\Message\HeartlandMessage\DeleteCardRequest as HeartlandDeleteCardRequest;
use Omnipay\GlobalPayments\Message\HeartlandMessage\UpdateCardRequest as HeartlandUpdateCardRequest;
use GlobalPayments\Api\Entities\Transaction;

class HeartlandResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        if ($this->response instanceof Transaction) {
            return in_array(
                $this->response->responseCode, $this->request->getGoodReponseCodes()
            );
        } elseif ($this->request instanceof HeartlandDeleteCardRequest || $this->request instanceof HeartlandUpdateCardRequest) {
            return $this->response;
        }

        return false;
    }
}
