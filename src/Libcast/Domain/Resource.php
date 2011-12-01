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
class Resource
{
    protected
        $client,
        $title,
        $description,
        $streamUrl;

    /**
     *
     * @param \Libcast\LibcastClient $client 
     */
    public function __construct(\Libcast\LibcastClient $client)
    {
        $this->client = $client;
    }
    
    /**
     * Return the title of the resource
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return the description of the resource
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Return the parent Stream object of the resource
     * 
     * @return Stream
     */     
    public function getStream()
    {
        return $this->client->getStream($this->streamUrl);
    }
    
    /**
     *
     * @return string
     */
    public function __toString() {
        return $this->title;
    }
}