<?php

namespace Omniship\Dpdro;

use Carbon\Carbon;

use Omniship\Dpdro\Http\CreateBillOfLadingRequest;
use Omniship\Dpdro\Http\GetPdfRequest;
use Omniship\Dpdro\Http\TrackingParcelRequest;
use Omniship\Dpdro\Http\ValidateCredentialsRequest;
use Omniship\Dpdro\Http\ShippingQuoteRequest;
use Omniship\Dpdro\Http\ValidateAddressRequest;
use Omniship\Dpdro\Client;

use Omniship\Interfaces\RequestInterface;
use Omniship\Common\Address;
use Omniship\Common\AbstractGateway;

/**
 * @method RequestInterface deleteBillOfLading()
 * @method RequestInterface trackingParcels(array $bol_ids = [])
 * @method RequestInterface validatePostCode(Address $address)
 * @method RequestInterface requestCourier($bol_id, Carbon $date_start = null, Carbon $date_end = null)
 * @method RequestInterface codPayments(array $bol_ids)
 */
class Gateway extends AbstractGateway
{

    private $name = 'Dpdro';
    protected $client;
    const TRACKING_URL = '%s/order/status/%s';

    /**
     * @return stringc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'username' => '',
            'password' => '',
            'base_url' => '',
            'barear_token' => '',
            'request_type' => '',
            'reqeust_url' => ''
        ];
    }

    public function getBaseUrl()
    {
        return $this->getParameter('base_url');
    }

    public function setBaseUrl($value)
    {
        return $this->setParameter('base_url', $value);
    }

    public function getBarearToken()
    {
        return $this->getParameter('barear_token');
    }

    public function setBarearToken($value)
    {
        return $this->setParameter('barear_token', $value);
    }

    public function getRequestType()
    {
        return $this->getParameter('request_type');
    }

    public function setRequestType($value)
    {
        return $this->setParameter('request_type', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }


    public function getRequestURI()
    {
        return $this->getParameter('reqeust_url');
    }

    public function setRequestURI($value)
    {
        return $this->setParameter('reqeust_url', $value);
    }



    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client(     $this->getUsername(),
                                            $this->getPassword(),
                                            $this->getBaseUrl(),
                                            $this->getBarearToken(),
                                            $this->getRequestType(),
                                            $this->getRequestURI() );
        }
        return $this->client;
    }


    public function supportsValidateAddress()
    {
        return false;
    }
    public function validateAddress(Address $address)
    {
        return $this->createRequest(ValidateAddressRequest::class, $this->setAddress($address)->getParameters());
    }



    public function supportsValidateCredentials()
    {
        return true;
    }
    public function validateCredentials(array $parameters = [])
    {
        return $this->createRequest(ValidateCredentialsRequest::class, $parameters);
    }



    public function supportsCreateBillOfLading()
    {
        return true;
    }
    public function createBillOfLading($parameters = [])
    {
        if ($parameters instanceof CreateBillOfLadingRequest) {
            return $parameters;
        }
        if (!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(CreateBillOfLadingRequest::class, $this->getParameters() + $parameters);
    }


    public function supportsCashOnDelivery()
    {
        return true;
    }

    public function supportsInsurance()
    {
        return true;
    }

    public function trackingParcel($bol_id)
    {
        return $this->createRequest(TrackingParcelRequest::class, $this->setBolId($bol_id)->getParameters());
    }

    public function getQuotes($parameters = [])
    {
        if ($parameters instanceof ShippingQuoteRequest) {
            return $parameters;
        }
        if (!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(ShippingQuoteRequest::class, $this->getParameters() + $parameters);
    }

    public function getPdf($bol_id)
    {
        return $this->createRequest(GetPdfRequest::class, $this->setBolId($bol_id)->getParameters());
    }


}
