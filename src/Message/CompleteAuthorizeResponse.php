<?php

namespace Omnipay\Humm\Message;

use Omnipay\Humm\Message\Response;

class CompleteAuthorizeResponse extends Response
{
    const RESULT_COMPLETE = 'completed';

    public function isSuccessful()
    {
        return ($this->getData()['x_result'] ?? null) === static::RESULT_COMPLETE;
    }

    // TODO: Check available statuses and add checks here.

    // public function isPending()
    // {
    //     return false;
    // }

    // public function isCancelled()
    // {
    //     return false;
    // }

    public function getTransactionId()
    {
        return ($this->getData()['x_reference'] ?? null);
    }

    public function getTransactionReference()
    {
        // return ($this->getData()['x_gateway_reference'] ?? null);
        // NOTE: The purchase number is what is used for refunds.
        return ($this->getData()['x_purchase_number'] ?? null);
    }
}
