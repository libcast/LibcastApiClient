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

use Guzzle\Service\ClientInterface;
use Guzzle\Service\Client;

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
class GuzzleHttpAdapter implements HttpAdapterInterface
{
    protected $client;

    /**
     *
     * @param ClientInterface $client 
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = null === $client ? new Client() : $client;
    }

    /**
     * Return the content of the page pointed by the given $url
     * 
     * @param string $url
     * @return string 
     */    
    public function getContent($url)
    {
        $response = $this->client->get($url)->send();
        if ($response->getStatusCode() == 404) {
           throw new \Exception('The URL requested does not exist.');    
        }
        
        return (string) $response->getBody();
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'guzzle';
    }
}
