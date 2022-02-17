<?php

namespace Omniship\Dpdro\Http;

use Google\Service\CloudSearch\PushItem;
use Omniship\Dpdro\Client;
use PhpParser\Node\Expr\Cast\Array_;

class ShippingQuoteRequest extends AbstractRequest
{

    public function getData()
    {

        if($this->getPayer() == 'SENDER'){
            $payer = 1;
        } else{
            $payer = 2;
        }

        $Receiverline1 = '';
        $Receiverline2 = '';
        $Sender_city = '';

        $is_office_pickup = $this->getReceiverAddress()->getParameter("send_type");
        if( $is_office_pickup == 'office' ){
            $pick_office_id = $this->getReceiverAddress()->getParameter("office_id");
            //$Sender_city
        }




        $ReceiverAddress = $this->getReceiverAddress();
        $is_office_drop = $ReceiverAddress->getOffice();
        if( $is_office_drop ){

        }else{
            $Receiverline1 =  $ReceiverAddress->getStreet()->getName().' '.$ReceiverAddress->getStreetNumber();
            $Receiverline2 = !empty($ReceiverAddress->getQuarter()) ? $ReceiverAddress->getQuarter()->getName().', ' : '';
            $Receiverline2 .= !empty($ReceiverAddress->getBuilding()) ? $ReceiverAddress->getBuilding().', ' : '';
            $Receiverline2 .= !empty($ReceiverAddress->getEntrance()) ? $ReceiverAddress->getEntrance().', ' : '';
            $Receiverline2 .= !empty($ReceiverAddress->getFloor()) ? $ReceiverAddress->getFloor().', ' : '';
            $Receiverline2 .= !empty($ReceiverAddress->getApartment()) ? $ReceiverAddress->getApartment() : '';
        }

        dd("offi", $pick_office_id, $is_office_pickup);

        $data = [];
        $data["pickup_city"] = $this->getReceiverAddress()->getParameter("pickup_city");
        if($pick_office_id) $data["pickup_hub_id"] = $pick_office_id;
        $data["recipient_id"] = 2;
        $data["delivery_city"] = $this->getReceiverAddress()->getCity()->getName();
        $data["delivery_address"] = $Receiverline1.' '.$Receiverline2;
        $data["delivery_zip"] = $this->getReceiverAddress()->getParameter('post_code');
        //$data["delivery_hub_id"] = "";
        $data["product_id"] = 1;
        $data["return_document"] = 0;
        $data["weight"] = $this->getWeight();
        $data["cod_amount"] = 1;
        $data["shipping_payer"] = $payer;
        $data["redemption_payer"] = 2;
        $data["return_document_payer"] = 2;
        $data["insurance_payer"] = 2;

        //dd( $data, "AA: ", $this->getReceiverAddress() );

        return $data;

    }

    public function sendData($data)
    {
        dd("TTTT",$data);
        $params = $this->parameters->all();
        $services = (new Client( $params['username'], $params['password'], $params['base_url'] ));
        $data = $this->getData();
        $services = $services->SendRequest( $data , 'POST', '/orders/calculator');
        return $this->createResponse($services);
    }

    protected function createResponse($data)
    {
        return $this->response = new ShippingQuoteResponse($this, $data);
    }
}
