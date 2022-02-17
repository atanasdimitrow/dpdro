<?php

namespace  Omniship\Dpdro\Http;
use Omniship\Dpdro\Client;


class CreateBillOfLadingRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData() {
        if($this->getPayer() == 'SENDER'){
            $payer = 1;
        } else{
            $payer = 2;
        }

        $data = [];
        $data["sender_id"] = "92518";
        $data["pickup_city"] = "Дебар";
        $data["pickup_address"] = "Скопска 1, Дебар";
        $data["pickup_zip"] = "1250";
        //$data["pickup_hub_id"] = "";
        
        $data["recipient_id"] = 2;
        $data["delivery_city"] = "Karposh, Skopje";
        $data["delivery_address"] = "Neveska 1 2/10";
        $data["delivery_zip"] = "1001";
        //$data["delivery_hub_id"] = "";
        $data["product_id"] = 1;
        $data["return_document"] = 0;
        $data["weight"] = 11;
        $data["cod_amount"] =1324;
        $data["shipping_payer"] = $payer;
        $data["redemption_payer"] = 2;
        $data["return_document_payer"] = 2;
        $data["insurance_payer"] = 2;

        return $data;
    }

    public function sendData($data) {
        $params = $this->parameters->all();
        $services = (new Client( $params['username'], $params['password'], $params['base_url'] ));
        $services = $services->SendRequest( $this->getData(), 'POST', '/orders' );
        return $this->createResponse($services);
    }

    /**
     * @param $data
     * @return ShippingQuoteResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CreateBillOfLadingResponse($this, $data);
    }

}
