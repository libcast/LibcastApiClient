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
use Libcast\Provider\ProviderInterface;

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
class ResourceProvider extends AbstractProvider implements ProviderInterface
{
    /**
     *
     * @param type $object
     * @param type $field
     * @param type $value 
     */
    private function setObjectValue($object, $field, $value)
    {
        $ref = new \ReflectionClass('\Libcast\Domain\Resource');
        $reflectionProperty = $ref->getProperty($field);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }
    
    /**
     *
     * @param array $xml
     * @param Resource object $resource 
     */
    private function parseXML($xml, $resource)
    {
        if (!$xml->stream) {
            throw new \Exception('The requested URL is not a resource.');
        }
        if ($xml->title) {
            $this->setObjectValue($resource, 'title', trim(ltrim($xml->title)));
        }
        if ($xml->description) {
            $this->setObjectValue($resource, 'description', trim(ltrim($xml->description)));
        }
        if ($xml->stream->link) {
            $this->setObjectValue($resource, 'streamUrl', trim(ltrim($xml->stream->link->attributes()->href)));
        }       
    }
    
    /**
     *
     * @param array $json
     * @param Resource object $resource 
     */
    private function parseJSON($json, $resource)
    {
        if (!isset($json->{'resource'})) {
            throw new \Exception('The requested URL is not a resource.');
        }
        if (isset($json->{'title'})) {
            $this->setObjectValue($resource, 'title', $json->{'title'});
        }
        if (isset($json->{'description'})) {
            $this->setObjectValue($resource, 'description', $json->{'description'});
        }
        if (isset($json->{'stream'})) {
            $this->setObjectValue($resource, 'streamUrl', $json->{'stream'});
        }       
    }
    
    /**
     * Get the content of the page pointed by the given URL
     * and create then return the new associated resource object
     * 
     * @param string $url
     * @return Resource
     */
    public function getLibcastData($url)
    {
        $this->executeQuery($url);
        $resource = new \Libcast\Domain\Resource($this->getClient());
        $content = $this->getContent();
        if ($this->getClient()->getType() == 'xml') {
            $this->parseXML($content, $resource);
        }
        else {
            $this->parseJSON($content, $resource);
        }
        
        return $resource;       
    }
    
    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'Resource';
    }
}