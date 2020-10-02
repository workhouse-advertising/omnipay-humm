<?php
namespace Omnipay\Humm\Message;

class CancelRequest extends AbstractRequest
{
    protected function getEndpoint()
    {

    }

    public function getData()
    {
        return $this->getBaseData();
    }
}
