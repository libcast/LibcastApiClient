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
class StreamProvider extends AbstractProvider implements ProviderInterface
{   
    /**
     *
     * @param type $object
     * @param type $field
     * @param type $value 
     */
    private function setObjectValue($object, $field, $value)
    {
        $ref = new \ReflectionClass('\Libcast\Domain\Stream');
        $reflectionProperty = $ref->getProperty($field);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }

    /**
     *
     * @param array $xml
     * @param Stream object $stream 
     */
    private function parseXML($xml, $stream)
    {
        if (!$xml->resources) {
            throw new \Exception('The requested URL is not a stream.');
        }
        if ($xml->title) {
            $this->setObjectValue($stream, 'title', trim(ltrim($xml->title)));           
        }
        if ($xml->description) {
            $this->setObjectValue($stream, 'description', trim(ltrim($xml->description)));
        }
        if ($xml->media->link) {
            $this->setObjectValue($stream, 'mediaUrl', trim(ltrim($xml->media->link->attributes()->href)));
        }
        if ($xml->resources) {
            $resources = array();
            foreach($xml->resources->resource as $link) {
                array_push($resources, trim(ltrim($link->attributes())));
            }
            $this->setObjectValue($stream, 'resourcesUrl', $resources);
        }        
    }
    
    /**
     *
     * @param array $json
     * @param Stream object $stream 
     */
    private function parseJSON($json, $stream)
    {
        if (!isset($json->{'resources'})) {
            throw new \Exception('The requested URL is not a stream.');
        }
        if (isset($json->{'title'})) {
            $this->setObjectValue($stream, 'title', $json->{'title'});
        }
        if (isset($json->{'description'})) {
            $this->setObjectValue($stream, 'description', $json->{'description'});
        }
        if (isset($json->{'media'})) {
            $this->setObjectValue($stream, 'mediaUrl', $json->{'media'});
        }
        if (isset($json->{'resources'})) {
            $resources = array();
            foreach($json->{'resources'} as $link) {
                array_push($resources, $link);
            }
            $this->setObjectValue($stream, 'resourcesUrl', $resources);
        }        
    }
    
    /**
     * Get the content of the page pointed by the given URL
     * and create then return the new associated stream object
     * 
     * @param string $url
     * @return Stream Object
     */
    public function getLibcastData($url)
    {
        $this->executeQuery($url);
        $stream = new \Libcast\Domain\Stream($this->getClient());
        $content = $this->getContent();
        if ($this->getClient()->getType() == 'xml') {
            $this->parseXML($content, $stream);
        }
        else {
            $this->parseJSON($content, $stream);
        }
        
        return $stream;
    }
    
    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'Stream';
    }
}