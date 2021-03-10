<?php

namespace Omnipay\GlobalPayments\Message;

use Omnipay\Common\Message\AbstractResponse as CommonAbstractResponse;

abstract class AbstractResponse extends CommonAbstractResponse
{
    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->response = $data;
    }

    abstract public function isSuccessful();

    public function getMessage()
    {
        return $this->response->responseMessage;
    }
    
    public function getCode()
    {
        return $this->response->responseCode;
    }

    public function getTransactionReference()
    {
        return $this->response->transactionId;
    }

    public function getCardReference()
    {
        return $this->response->token;
    }

    public function getCustomerReference()
    {
        return $this->response->id;
    }

    public function getPaymentMethodReference()
    {
        return $this->response->id;
    }
}
