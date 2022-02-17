<?php
namespace Omniship\Dpdro\Http;
use Omniship\Dpdro\Client;


class GetPdfRequest extends AbstractRequest
{
    /**
     * @return integer
     */
    public function getData() {
        return [  ];
    }

    /**
     * @param mixed $data
     * @return GetPdfResponse
     */
    public function sendData($data) {

        $params = $this->parameters->all();
        $services = (new Client( $params['username'], $params['password'], $params['base_url'], '', "POST", '/pdf' )); //not avilable functionality
        $services = $services->SendRequest( $this->getData() );
        return $this->createResponse($services);

    }

    /**
     * @param $data
     * @return GetPdfResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new GetPdfResponse($this, $data);
    }

}
