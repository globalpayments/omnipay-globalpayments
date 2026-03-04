<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

use GlobalPayments\Api\Entities\Transaction;
use Omnipay\GlobalPayments\Message\AbstractResponse;

class GpApiResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        if ($this->response instanceof Transaction) {
            return in_array(
                $this->response->responseCode,
                $this->request->getGoodReponseCodes()
            );
        }

        return false;
    }
}
