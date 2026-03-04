<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\AbstractGateway;

class GpApiGateway extends AbstractGateway
{
    private $gpApiMessagePath = '\Omnipay\GlobalPayments\Message\GpApiMessage';

    public function getName()
    {
        return 'GpApi';
    }

    public function getDefaultParameters()
    {
        return array(
            'appId' => '',
            'appKey' => '',
            'channel' => 'CNP',
            'country' => 'US',
            'environment' => 'TEST',
        );
    }

    // Methods for setting Gateway Authentication properties

    public function setAppId($value)
    {
        return $this->setParameter('appId', $value);
    }

    public function setAppKey($value)
    {
        return $this->setParameter('appKey', $value);
    }

    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    // Transactions

    public function purchase($options = array())
    {
        return $this->createRequest(
            $this->gpApiMessagePath . '\PurchaseRequest',
            $options
        );
    }

    public function authorize($options = array())
    {
        return $this->createRequest(
            $this->gpApiMessagePath . '\AuthorizeRequest',
            $options
        );
    }

    public function capture($options = array())
    {
        return $this->createRequest(
            $this->gpApiMessagePath . '\CaptureRequest',
            $options
        );
    }

    public function void($options = array())
    {
        return $this->createRequest(
            $this->gpApiMessagePath . '\VoidRequest',
            $options
        );
    }

    public function refund($options = array())
    {
        return $this->createRequest(
            $this->gpApiMessagePath . '\RefundRequest',
            $options
        );
    }

    public function createCard($options = array())
    {
        return $this->createRequest(
            $this->gpApiMessagePath . '\CreateCardRequest',
            $options
        );
    }
}
