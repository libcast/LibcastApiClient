<?php

/**
 * This file is part of the LibcastApiClient package.
 * For the full copyright and license information, please view the LICENSE
 * that was distribued with this source code.
 * 
 * @license GNU LESSER GENERAL PUBLIC LICENSE Version 3
 * 
 */

namespace Libcast\Domain;

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
class Media
{
    protected
        $client,
        $name,
        $description,
        $streamsUrl;

    /**
     *
     * @param \Libcast\LibcastClient $client 
     */
    public function __construct(\Libcast\LibcastClient $client)
    {
        $this->client = $client;
    }
    
    /**
     * Return the name of the media
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the description of the media
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Return an array of stream objects which are associated to the media
     * 
     * @return array Stream[]
     */  
    public function getStreams()
    {
        $streams = array();
        foreach ($this->streamsUrl as $streamUrl) {
            array_push($streams, $this->client->getStream($streamUrl));
        }
        return $streams;
    }
    
    /**
     *
     * @return string 
     */
    public function __toString() {
        return $this->name;
    }
}