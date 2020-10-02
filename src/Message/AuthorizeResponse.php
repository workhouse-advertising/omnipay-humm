<?php

namespace Omnipay\Humm\Message;

/**
 * Send the user to the Hosted Payment Page to authorize their payment.
 */

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class AuthorizeResponse extends AbstractResponse implements RedirectResponseInterface
{
    // TODO: Consider adding support for Oxipay too. i.e: `secure.oxipay` and `securesandbox.oxipay`.
    protected $liveEndpoint = 'https://cart.shophumm.com.au/Checkout?platform=Default';
    protected $testEndpoint = 'https://integration-cart.shophumm.com.au/Checkout?platform=Default';

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        return ($this->getData()['x_test'] ?? false) ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array
     */
    public function getRedirectData()
    {
        return $this->getData();
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return false;
    }
}
