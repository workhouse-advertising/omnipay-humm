<?php

namespace Omnipay\Humm\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Humm\Traits\GatewayParameters;

abstract class AbstractRequest extends BaseAbstractRequest
{
    use GatewayParameters;

    // TODO: Consider adding support for Oxipay too.
    //       `secure.oxipay` and `securesandbox.oxipay`.
    protected $liveEndpoint = 'https://cart.shophumm.com.au/Checkout?platform=Default';
    protected $testEndpoint = 'https://integration-cart.shophumm.com.au/Checkout?platform=Default';

    public function getHttpMethod()
    {
        return 'POST';
    }

    protected function getBaseData()
    {
        return [
            'x_shop_name' => $this->getShopName(),
            // TODO: Make this configurable.
            'x_shop_country' => 'AU',
            'x_account_id' => $this->getMerchantId(),
            // TODO: Consider having an actualy version number, or is this superfluous?
            'version_info' => 'Humm_Omnipay_0.1',
            'x_test' => $this->getTestMode() ? true : false,
            // TODO: Consider making this configurable.
            'x_transaction_timeout' => 1440,
        ];
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
