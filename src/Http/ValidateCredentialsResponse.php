<?php

namespace Omniship\Dpdro\Http;

class ValidateCredentialsResponse extends AbstractResponse
{

    /**
     * @return bool
     */
    public function getData()
    {
        if($this->data){
            return $this->data;
        }
        return false;
    }

}
