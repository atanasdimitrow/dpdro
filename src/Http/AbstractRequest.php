<?php

namespace Omniship\Dpdro\Http;

use Omniship\Interfaces\RequestInterface;
use Omniship\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest implements RequestInterface
{

    protected function validateLanguage(){
        $language = $this->getLanguageCode();
        if(strtolower($language) != 'mk'){
            if( strtolower($language) == 'bg' )
                return 'bg';
            else
                return 'en';
        }
        return 'mk';
    }

    public function getBaseUrl(){

        return $this->getParameter('base_url');
    }

    public function setBaseUrl($value){
        return $this->setParameter('base_url', $value);
    }

    /**
     * @return mixed
     */
    public function getBarear()
    {
        return $this->getParameter('barear_token');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setBarear($value)
    {
        return $this->setParameter('barear_token', $value);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }


    abstract protected function createResponse($data);

}
