<?php
namespace Omnipay\Humm\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Humm\Helper\Crypto as CryptoHelper;
use Omnipay\Humm\Message\CompleteAuthorizeResponse;

class CompleteAuthorizeRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->httpRequest->query->all();
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        if (!CryptoHelper::isValidSignature($data, $this->getGatewayKey())) {
            throw new InvalidRequestException(
                'Incorrect signature; server request may have been tampered.'
            );
        }

        return new CompleteAuthorizeResponse($this, $data);
    }
}
