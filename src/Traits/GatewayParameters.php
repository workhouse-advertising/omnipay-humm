<?php

namespace Omnipay\Humm\Traits;

trait GatewayParameters
{
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getGatewayKey()
    {
        return $this->getParameter('gatewayKey');
    }

    public function setGatewayKey($value)
    {
        return $this->setParameter('gatewayKey', $value);
    }

    public function getShopName()
    {
        return $this->getParameter('shopName');
    }

    public function setShopName($value)
    {
        return $this->setParameter('shopName', $value);
    }

    public function getReference()
    {
        return $this->getParameter('reference');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }
}
