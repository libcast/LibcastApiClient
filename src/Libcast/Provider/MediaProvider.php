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
class MediaProvider extends AbstractProvider implements ProviderInterface
{
    /**
     *
     * @param type $object
     * @param type $field
     * @param type $value 
     */
    private function setObjectValue($object, $field, $value)
    {
        $ref = new \ReflectionClass('\Libcast\Domain\Media');
        $reflectionProperty = $ref->getProperty($field);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }
    
    /**
     *
     * @param array $xml
     * @param Media object $media 
     */
    private function parseXML($xml, $media)
    {
        if (!$xml->streams) {
            throw new \Exception('The requested URL is not a media.');
        }
        if ($xml->name) {
            $this->setObjectValue($media, 'name', trim(ltrim($xml->name)));
        }
        if ($xml->description) {
            $this->setObjectValue($media, 'description', trim(ltrim($xml->description)));
        }
        if ($xml->streams) {
            $streams = array();
            foreach($xml->streams->stream as $link) {
                array_push($streams, $link->attributes()->href);
            }
            $this->setObjectValue($media, 'streamsUrl', $streams);
        } 
    }
    
    /**
     *
     * @param array $json
     * @param Media object $media 
     */
    private function parseJSON($json, $media)
    {
        if (!isset($json->{'streams'})) {
            throw new \Exception('The requested URL is not a media.');
        }
        if (isset($json->{'name'})) {
            $this->setObjectValue($media, 'name', $json->{'name'});
        }
        if (isset($json->{'description'})) {
            $this->setObjectValue($media, 'description', $json->{'description'});
        }
        if (isset($json->{'streams'})) {
            $streams = array();
            foreach($json->{'streams'} as $link) {
                array_push($streams, $link);
            }
            $this->setObjectValue($media, 'streamsUrl', $streams);
        }      
    }
    
    /**
     * Get the content of the page pointed by the given URL
     * and create then return the new associated media object
     * 
     * @param string $url
     * @return Media Object
     */
    public function getLibcastData($url)
    {
        $this->executeQuery($url);
        $media = new \Libcast\Domain\Media($this->getClient());
        $content = $this->getContent();
        if ($this->getClient()->getType() == 'xml') {
            $this->parseXML($content, $media);
        }
        else {
            $this->parseJSON($content, $media);
        }
        
        return $media;
    }
    
    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'Media';
    }
}