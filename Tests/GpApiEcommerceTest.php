<?php

namespace Omnipay\GlobalPayments\Tests;

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\GlobalPayments\CreditCard;
use Omnipay\GlobalPayments\GpApiGateway;
use Omnipay\GlobalPayments\Tests\Utils\HelperMethods;
use Omnipay\GlobalPayments\Tests\Utils\TestCredentials;
use Omnipay\Omnipay;
use Omnipay\Tests\TestCase as OmniTests;

/**
 * Integration tests for the GpApi Gateway. These tests make real requests to GpApi sandbox environment
 */
class GpApiEcommerceTest extends OmniTests
{
    protected GpApiGateway $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = Omnipay::create('GlobalPayments\GpApi');
        $this->gateway->setAppId(TestCredentials::GPAPI_APP_ID);
        $this->gateway->setAppKey(TestCredentials::GPAPI_APP_KEY);
        $this->gateway->setChannel('CNP');
        $this->gateway->setCountry('US');
        $this->gateway->setEnvironment('TEST');
    }

    /**
     * Basic purchase attempts using raw card numbers
     */
    public function test01PurchaseVisaManualEntry()
    {
        $request = $this->gateway->purchase(
            array(
                'card' => $this->getVisa(),
                'currency' => 'USD',
                'amount' => $this->randAmount()
            )
        );

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test02PurchaseMastercardManualEntry()
    {
        $request = $this->gateway->purchase(
            array(
                'card' => $this->getMasterCard(),
                'currency' => 'USD',
                'amount' => '20.02'
            )
        );

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    public function test03PurchaseAmexManualEntry()
    {
        $request = $this->gateway->purchase(
            array(
                'card' => $this->getAmex(),
                'currency' => 'USD',
                'amount' => $this->randAmount()
            )
        );

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    /**
     * Authorization tests
     */
    public function test04AuthorizeVisaManualEntry()
    {
        $request = $this->gateway->authorize(
            array(
                'card' => $this->getVisa(),
                'currency' => 'USD',
                'amount' => $this->randAmount()
            )
        );

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getTransactionReference());
        $this->assertNotNull($response->getMessage());
        $this->assertNotNull($response->getCode());
    }

    /**
     * Auth and Capture test
     */
    public function test05AuthAndCapture()
    {
        // First authorize
        $authRequest = $this->gateway->authorize(
            array(
                'card' => $this->getVisa(),
                'currency' => 'USD',
                'amount' => '30.00'
            )
        );

        $authResponse = $authRequest->send();

        $this->assertTrue($authResponse->isSuccessful());

        // Then capture
        $captureRequest = $this->gateway->capture(
            array(
                'transactionReference' => $authResponse->getTransactionReference(),
                'amount' => '30.00'
            )
        );

        $captureResponse = $captureRequest->send();

        $this->assertTrue($captureResponse->isSuccessful());
    }

    /**
     * Purchase and void test
     */
    public function test06PurchaseAndVoid()
    {
        // First purchase
        $purchaseRequest = $this->gateway->purchase(
            array(
                'card' => $this->getVisa(),
                'currency' => 'USD',
                'amount' => '25.00'
            )
        );

        $purchaseResponse = $purchaseRequest->send();

        $this->assertTrue($purchaseResponse->isSuccessful());

        $purchaseTransactionReference = $purchaseResponse->getTransactionReference();

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertNotNull($purchaseResponse->getTransactionReference());
        $this->assertNotNull($purchaseResponse->getMessage());
        $this->assertNotNull($purchaseResponse->getCode());

        // Void
        $voidRequest = $this->gateway->void(
            array(
                'transactionReference' => $purchaseTransactionReference,
            )
        );

        $voidResponse = $voidRequest->send();

        $this->assertTrue($voidResponse->isSuccessful());
    }

    /**
     * Purchase and refund test
     */
    public function test07PurchaseAndRefund()
    {
        // First purchase
        $purchaseRequest = $this->gateway->purchase(
            array(
                'card' => $this->getVisa(),
                'currency' => 'USD',
                'amount' => '15.00'
            )
        );

        $purchaseResponse = $purchaseRequest->send();

        $this->assertTrue($purchaseResponse->isSuccessful());

        // Then refund
        $refundRequest = $this->gateway->refund(
            array(
                'transactionReference' => $purchaseResponse->getTransactionReference(),
                'currency' => 'USD',
                'amount' => '15.00'
            )
        );

        $refundResponse = $refundRequest->send();

        $this->assertTrue($refundResponse->isSuccessful());
    }

    /**
     * Create card (tokenization) test
     */
    public function test08CreateCard()
    {
        $request = $this->gateway->createCard(
            array(
                'card' => $this->getVisa()
            )
        );

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getCardReference());
    }

    /**
     * Token purchase test
     */
    public function test09TokenPurchase()
    {
        // First create a token
        $createCardRequest = $this->gateway->createCard(
            array(
                'card' => $this->getVisa()
            )
        );

        $createCardResponse = $createCardRequest->send();

        $this->assertTrue($createCardResponse->isSuccessful());
        $token = $createCardResponse->getCardReference();

        // Then purchase with token
        $purchaseRequest = $this->gateway->purchase(
            array(
                'token' => $token,
                'currency' => 'USD',
                'amount' => $this->randAmount()
            )
        );

        $purchaseResponse = $purchaseRequest->send();

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertNotNull($purchaseResponse->getTransactionReference());
    }

    /**
     * Utility Methods
     */
    protected function randAmount()
    {
        return (string) round(rand(10, 10000) / 100, 2);
    }

    private function getMasterCard()
    {
        $card = array(
            'number' => '5425230000004415',
            'expiryMonth' => 12,
            'expiryYear' => HelperMethods::getValidExpYear(),
            'cvv' => 123,
            'type' => CardType::MASTERCARD,
            'billingAddress1' => '6860 Dallas Pkwy',
            'billingPostcode' => '75024'
        );

        return new CreditCard($card);
    }

    private function getAmex()
    {
        $card = array(
            'number' => '374101000000608',
            'expiryMonth' => 12,
            'expiryYear' => HelperMethods::getValidExpYear(),
            'cvv' => 1234,
            'type' => CardType::AMEX,
            'billingAddress1' => '6860',
            'billingPostcode' => '75024'
        );

        return new CreditCard($card);
    }

    private function getVisa()
    {
        $card = array(
            'number' => '4263970000005262',
            'expiryMonth' => 12,
            'expiryYear' => HelperMethods::getValidExpYear(),
            'cvv' => 123,
            'type' => CardType::VISA,
            'billingAddress1' => '6860 Dallas Pkwy',
            'billingPostcode' => '750241234'
        );

        return new CreditCard($card);
    }
}
