<?php

namespace Omnipay\Humm\Message;

use Omnipay\Humm\Message\Response;

class RefundResponse extends Response
{
    // TODO: Translate errors to messages.
    protected $errorCodes = [
        'MERR0001' => 'API Key Not found',
        'MERR0003' => 'Refund Failed',
        'MERR0004' => 'Invalid Request',
    ];

    protected $httpResponse;

    public function isSuccessful()
    {
        return $this->getHttpResponse() && $this->getHttpResponse()->getStatusCode() == 204;
    }

    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    public function setHttpResponse($httpResponse)
    {
        $this->httpResponse = $httpResponse;
        return $this;
    }
}
