<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\CreditCard as CommonCreditCard;

/**
 * Extends Omnipay\Common\CreditCard to add support for the below params
 */
class CreditCard extends CommonCreditCard
{
    /**
     * Get card brand.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * Sets card brand; required for TransIt Gateway
     * 
     * @param string $value card brand.
     * 
     * @return $this
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    /**
     * Get mobile type (ApplePay / GooglePay)
     *
     * @return string
     */
    public function getMobileType()
    {
        return $this->getParameter('mobileType');
    }

    /**
     * Sets mobile wallet type
     * 
     * @param string $value mobile type (ApplePay / GooglePay)
     * 
     * @return $this
     */
    public function setMobileType($value)
    {
        return $this->setParameter('mobileType', $value);
    }

    /**
     * Get card brand transaction id.
     *
     * @return string
     */
    public function getCardBrandTransId()
    {
        return $this->getParameter('cardBrandTransId');
    }

    /**
     * Sets card brand trans Id.
     * This is required for Card-On-File transactions
     * 
     * @param string $value card brand.
     * 
     * @return $this
     */
    public function setCardBrandTransId($value)
    {
        return $this->setParameter('cardBrandTransId', $value);
    }

    /**
     * Get stored StoredCredentialInitiator value.
     *
     * @return string
     */
    public function getStoredCredInitiator()
    {
        return $this->getParameter('storedCredInitiator');
    }

    /**
     * Set StoredCredentialInitiator value.
     * This is required for Card-On-File transactions.
     * 
     * @param string $value card brand.
     * 
     * @return $this
     */
    public function setStoredCredInitiator($value)
    {
        return $this->setParameter('storedCredInitiator', $value);
    }
}
