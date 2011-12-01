<?php

/**
 * This file is part of the LibcastApiClient package.
 * For the full copyright and license information, please view the LICENSE
 * that was distribued with this source code.
 * 
 * @license GNU LESSER GENERAL PUBLIC LICENSE Version 3
 * 
 */

namespace Libcast\HttpAdapter;

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
class ZendHttpAdapter implements HttpAdapterInterface
{
    protected $adapter;

    /**
     *
     * @param \Zend_Http_Client_Adapter_Interface $adapter 
     */
    public function __construct(\Zend_Http_Client_Adapter_Interface $adapter = null)
    {
        if (null === $adapter) {
            $this->adapter = new \Zend_Http_Client_Adapter_Socket();
        } else {
            $this->adapter = $adapter;
        }
    }

    /**
     * Return the content of the page pointed by the given $url
     * 
     * @param string $url
     * @return string 
     */    
    public function getContent($url)
    {
        try {
            $http = new \Zend_Http_Client($url, array(
                'adapter' => $this->adapter
            ));
            $reponse = $http->request();

            if ($reponse->isSuccessful()) {
                $content = $reponse->getBody();
            } else {
                throw new \Exception('The URL requested does not exist.');
            }
        } catch (\Zend_Http_Client_Exception $e) {
            $content = null;
        }

        return $content;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'zend';
    }
}
