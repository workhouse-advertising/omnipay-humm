<?php
namespace Omnipay\Humm\Message;

use Omnipay\Humm\Helper\Crypto as CryptoHelper;
use Omnipay\Humm\ItemInterface;
use Omnipay\Humm\ItemTypeInterface;
use Omnipay\Humm\Message\AuthorizeResponse;

/**
 * Authorize Request
 *
 * @method Response send()
 */
class AuthorizeRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getEndpoint($service = null)
    {
        // No endpoint as the response is a redirect.
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'amount',
            'currency',
            'shopName',
            'reference',
            'returnUrl'
        );

        $data = $this->getBaseData();

        $data = array_merge($data, [
            'x_currency' => $this->getCurrency(),
            'x_url_callback' => $this->getNotifyUrl(),
            'x_url_complete' => $this->getReturnUrl(),
            'x_url_cancel' => $this->getCancelUrl(),
            'x_reference' => $this->getReference(),
            // TODO: Check if `x_invoice` still exists, as it's not in the current documentation.
            //       See https://docs.shophumm.com.au/custom_integration/checkout_api/
            // 'x_invoice' => $this->getReference(),
            'x_amount' => $this->getAmount(),
        ]);

        $card = $this->getCard();
        if ($card) {
            $data = array_merge($data, [
                'x_customer_first_name' => $card->getFirstName(),
                'x_customer_last_name' => $card->getLastName(),
                'x_customer_email' => $card->getEmail(),
                'x_customer_phone' => $card->getPhone(),
                'x_customer_billing_address1' => $card->getAddress1(),
                'x_customer_billing_address2' => $card->getAddress2(),
                'x_customer_billing_city' => $card->getCity(),
                'x_customer_billing_state' => $card->getState(),
                'x_customer_billing_zip' => $card->getPostCode(),
                'x_customer_shipping_address1' => $card->getShippingAddress1(),
                'x_customer_shipping_address2' => $card->getShippingAddress2(),
                'x_customer_shipping_city' => $card->getShippingCity(),
                'x_customer_shipping_state' => $card->getShippingState(),
                'x_customer_shipping_zip' => $card->getShippingPostcode(),
            ]);
        }
        
        $data['x_signature'] = CryptoHelper::generateSignature($data, $this->getGatewayKey());
        
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        // The response is a redirect.
        return new AuthorizeResponse($this, $data);
    }
}
