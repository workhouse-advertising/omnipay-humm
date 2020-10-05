<?php

namespace Omnipay\Humm\Message;

use Omnipay\Humm\Helper\Crypto as CryptoHelper;
use Omnipay\Humm\Message\RefundResponse;

class RefundRequest extends AbstractRequest
{
    // TODO: Consider adding support for Oxipay too. i.e: `secure.oxipay` and `securesandbox.oxipay`.
    protected $liveEndpoint = 'https://buyerapi.shophumm.com.au/api/ExternalRefund/v1/processrefund';
    protected $testEndpoint = 'https://integration-buyerapi.shophumm.com.au/api/ExternalRefund/v1/processrefund';

    /**
     * @inheritDoc
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @inheritDoc
     */
    public function setRefundReason($value)
    {
        return $this->setParameter('refundReason', $value);
    }

    /**
     * @inheritDoc
     */
    protected function getRefundReason()
    {
        return $this->getParameter('refundReason');
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'amount',
            'transactionReference',
            // TODO: Consider if `refundReason` should be made required. The Humm documentation doesn't specify if
            //       it's required or not. See https://docs.shophumm.com.au/custom_integration/refund_api/
            // 'refundReason',
        );

        $data = [
            'x_merchant_number' => $this->getMerchantId(),
            'x_purchase_number' => $this->getTransactionReference(),
            'x_amount' => $this->getAmount(),
            'x_reason' => $this->getRefundReason() ?? 'Refunded via Omnipay package',
        ];
        
        $data['signature'] = CryptoHelper::generateSignature($data, $this->getGatewayKey());
        
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), $headers, json_encode($data));
        $responseData = json_decode($httpResponse->getBody(), true);

        $response = new RefundResponse($this, $responseData);
        $response->setHttpResponse($httpResponse);

        return $response;
    }
}
