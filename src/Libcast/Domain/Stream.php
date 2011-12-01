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
class Stream
{
    protected
        $client,
        $title,
        $description,
        $mediaUrl,
        $resourcesUrl;
    
    /**
     *
     * @param \Libcast\LibcastClient $client 
     */
    public function __construct(\Libcast\LibcastClient $client)
    {
        $this->client = $client;
    }
    
    /**
     * Return the title of the stream
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return the description of the stream
     * 
     * @return string
     */
    public function getDescription()
    {
         return $this->description;
    }

    /**
     * Return the parent media object of the stream
     * 
     * @return Media
     */ 
    public function getMedia()
    {
        return $this->client->getMedia($this->mediaUrl);
    }

    /**
     * Return an array of resource objects which are associated to the stream
     * 
     * @return array Resource[]
     */
    public function getResources()
    {
        $resources = array();
        foreach ($this->resourcesUrl as $resourceUrl) {
            array_push($resources, $this->client->getResource($resourceUrl));
        }
        return $resources;
    }
    
    /**
     *
     * @return string
     */
    public function __toString() {
        return $this->title;
    }
}