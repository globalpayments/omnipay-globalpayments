<?php

namespace Omnipay\GlobalPayments\Message\GpApiMessage;

use GlobalPayments\Api\Entities\Enums\Channel;
use GlobalPayments\Api\Entities\Enums\Environment;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpApiConfig;
use GlobalPayments\Api\ServicesContainer;
use Omnipay\GlobalPayments\Message\AbstractRequest;

abstract class AbstractGpApiRequest extends AbstractRequest
{
    protected function setServicesConfig()
    {
        $config = new GpApiConfig();
        $config->appId = $this->getAppId();
        $config->appKey = $this->getAppKey();
        $config->channel = $this->getChannel() ?? Channel::CardNotPresent;
        $config->country = $this->getCountry() ?? 'US';
        $config->environment = $this->getEnvironmentSetting();

        if (!empty($this->getMerchantId())) {
            $config->merchantId = $this->getMerchantId();
        }

        ServicesContainer::configureService($config);
    }

    protected function getEnvironmentSetting()
    {
        $env = $this->getEnvironment();

        return (!empty($env) && strtoupper($env) === 'PRODUCTION') ? Environment::PRODUCTION : Environment::TEST;
    }

    public function getAppId()
    {
        return $this->getParameter('appId');
    }

    public function setAppId($value)
    {
        return $this->setParameter('appId', $value);
    }

    public function getAppKey()
    {
        return $this->getParameter('appKey');
    }

    public function setAppKey($value)
    {
        return $this->setParameter('appKey', $value);
    }

    public function getChannel()
    {
        return $this->getParameter('channel');
    }

    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    public function getCountry()
    {
        return $this->getParameter('country');
    }

    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }

    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function sendData($data)
    {
        parent::sendData($data);

        return new GpApiResponse($this, $this->runTrans());
    }
}
