<?php

/**
 * This file is part of the LibcastApiClient package.
 * For the full copyright and license information, please view the LICENSE
 * that was distribued with this source code.
 * 
 * @license GNU LESSER GENERAL PUBLIC LICENSE Version 3
 * 
 */

namespace Libcast\Provider;

use Libcast\HttpAdapter\HttpAdapterInterface;

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
abstract class AbstractProvider
{
    private $client;
    private $content;
    
    /**
     *
     * @param \Libcast\LibcastClient $client 
     */
    public function __construct(\Libcast\LibcastClient $client)
    {
        $this->client = $client;
    }

    /**
     * Return the instance of the Libcast client used
     * 
     * @return LibcastClient Object
     */
    protected function getClient()
    {
        return $this->client;
    }
    
    /**
     * Return the content of the $url given to the executeQuerry method.
     * 
     * @return string $content
     */
    protected function getContent()
    {
        return $this->content;
    }
    
    /**
    * Put the content of the page pointed by the given $url in a private attribute.
     * 
    * @param string $url 
    * @throws Exception when the given content type is different of xml or json
    */    
    protected function executeQuery($url)
    {
      $content = $this->client->getAdapter()->getContent($url);
      if ($this->client->getType() == 'xml') {
          $this->content = new \SimpleXMLElement($content);
      }
      else if ($this->client->getType() == 'json') {
          $this->content = json_decode($content);
      }
      else {
          throw new \Exception($this->client->getType().': unknown type');
      }  
    }
}