<?php

namespace Omniship\Dpdro\Http;

use Carbon\Carbon;
use Omniship\Common\Bill\Create;

class CreateBillOfLadingResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function getData()
    {
        if((int)$this->data == 0) {
            return false;
        }

        return $this->data;
    }

}
