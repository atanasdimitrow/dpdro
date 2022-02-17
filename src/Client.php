<?php

namespace Omniship\Dpdro;

use GuzzleHttp\Client AS HttpClient;
//use http\Client\Response;
//use Omniship\Helper\Collection;

class Client
{
    protected $username;
    protected $password;
    protected $error;
    protected $base_url;
    protected $barear_token;
    protected $request_type;
    protected $url_path;
    protected $cust_id;
    protected $cust_name;

    const SERVICE_PRODUCTION_URL = '%s/';


    public function __construct($username, $password, $base_url)
    {
        $this->username = $username;
        $this->password = $password;
        $this->base_url = $base_url;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getCountryById($country_id = 642, $path, $method)
    {
        $data = [
            "userName" => $this->username,
            "password" => $this->password,
        ];

        $response = $this->getResponse($method, $path . $country_id, $data);

        return $this->returnFormatedJsonContent($response);
    }

    public function getCountryByName($name, $path, $method)
    {
        $data = [
            "userName" => $this->username,
            "password" => $this->password,
            "name"     => $name,
        ];

        $response = $this->getResponse($method, $path , $data);
        return $this->returnFormatedJsonContent($response);
    }

    public function getSitesInCountry($country, $search)
    {
        $data = [
            "userName" => $this->username,
            "password" => $this->password,
            "countryId" => $country,
            "name" => $search
        ];
        $response = $this->getResponse('POST', 'location/site' , $data);
        return $this->returnFormatedJsonContent($response);
    }

    public function getStreetInCity($site, $search)
    {
        $data = [
            "userName" => $this->username,
            "password" => $this->password,
            "siteId" => $site,
            "name" => $search
        ];
        $response = $this->getResponse('POST', 'location/street' , $data);
        return $this->returnFormatedJsonContent($response);
    }

    public function getComplexInCity($site, $search)
    {
        $data = [
            "userName" => $this->username,
            "password" => $this->password,
            "siteId" => $site,
            "name" => $search
        ];
        $response = $this->getResponse('POST', 'location/complex' , $data);
        return $this->returnFormatedJsonContent($response);
    }

    private function getResponse($method, $path, $data)
    {
        $client = new HttpClient(['base_uri' => $this->base_url]);
        $response = $client->request($method, $path, [
            'json' => $data,
            'headers' =>  [
                'Content-Type' => 'application/json',
            ]
        ]);
        return $response;
    }

    private function returnFormatedJsonContent($response)
    {
        return json_decode( $response->getBody()->getContents(), true );
    }

}
