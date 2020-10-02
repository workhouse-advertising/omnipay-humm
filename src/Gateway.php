<?php

namespace Omnipay\Humm;

use Omnipay\Common\AbstractGateway;
use Omnipay\Humm\Message\AuthorizeRequest;
use Omnipay\Humm\Message\CompleteAuthorizeRequest;
use Omnipay\Humm\Message\CaptureRequest;
use Omnipay\Humm\Message\CancelRequest;
use Omnipay\Humm\Message\RefundRequest;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Humm';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'gatewayKey' => '',
            'testMode' => false,
        ];
    }

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

    public function authorize(array $parameters = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function completeAuthorize(array $options = [])
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $options);
    }

    public function capture(array $options = [])
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    public function void(array $options = [])
    {
        return $this->createRequest(CancelRequest::class, $options);
    }

    public function refund(array $options = [])
    {
        return $this->createRequest(RefundRequest::class, $options);
    }
}
