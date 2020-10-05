<?php

namespace Omnipay\Humm;

use Omnipay\Common\AbstractGateway;
use Omnipay\Humm\Message\AuthorizeRequest;
use Omnipay\Humm\Message\CompleteAuthorizeRequest;
use Omnipay\Humm\Message\CaptureRequest;
use Omnipay\Humm\Message\CancelRequest;
use Omnipay\Humm\Message\RefundRequest;
use Omnipay\Humm\Traits\GatewayParameters;

class Gateway extends AbstractGateway
{
    use GatewayParameters;

    public function getName()
    {
        return 'Humm';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'gatewayKey' => '',
            'shopName' => '',
            'testMode' => false,
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function completeAuthorize(array $options = [])
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $options);
    }

    // TODO: It doesn't look like there are any capture or void endpoints for Humm.
    //       Confirm that this is the case. See https://docs.shophumm.com.au/custom_integration/checkout_api/

    // public function capture(array $options = [])
    // {
    //     return $this->createRequest(CaptureRequest::class, $options);
    // }

    // public function void(array $options = [])
    // {
    //     return $this->createRequest(CancelRequest::class, $options);
    // }

    /**
     * @inheritDoc
     */
    public function refund(array $options = [])
    {
        return $this->createRequest(RefundRequest::class, $options);
    }
}
