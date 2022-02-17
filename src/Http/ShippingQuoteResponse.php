<?php

namespace Omniship\Dpdro\Http;
use Omniship\Common\ShippingQuoteBag;

class ShippingQuoteResponse extends AbstractResponse
{
    public function getData()
    {
        $result = new ShippingQuoteBag();

        foreach ($this->data as $data){
            $result->push([
                'customer_id' => $data->customer_id,
                'name' => '',
                'description' => $data->description,
                'price' => (float)$data->price,
                'unit_price' => (float)$data->unit_price,
                'pickup_time' => null,
                'delivery_date' => null,
                'delivery_time' => null,
                'currency' => 'MKD',
                'tax' => null,
                'insurance' => 0,
                'exchange_rate' => 1,
                'payer' =>null,
                'service_id' => $data->service_id,
                'service_name' => $data->service_name,
                'created' => $data->created
            ]);
        }
        return $result;
    }
}
