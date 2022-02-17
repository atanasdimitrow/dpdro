<?php

namespace Omniship\Dpdro\Http;
use Omniship\Message\AbstractResponse AS BaseAbstractResponse;
abstract class AbstractResponse extends BaseAbstractResponse
{
    /**
     * Get the initiating request object.
     *
     * @return AbstractRequest
     */


    public function getRequest()
    {
        return $this->request;
    }
    /**
     * @return null|string
     */
    public function getMessage()
    {
        if(isset($this->data[0]['error_message'])) {
            return $this->data[0]['error_message'];
        }
        return null;
    }
    /**
     * @return null|string
     */
    public function getCode()
    {
        return null;
    }


    public function getClientId() { return ''; }


}
