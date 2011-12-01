<?php

/**
 * This file is part of the LibcastApiClient package.
 * For the full copyright and license information, please view the LICENSE
 * that was distribued with this source code.
 *
 * @license GNU LESSER GENERAL PUBLIC LICENSE Version 3
 *
 */

namespace Libcast;

use Libcast\HttpAdapter\CurlHttpAdapter;

/**
 * @author Libcast <team-dev@libcast.com>
 */
class LibcastClient
{
    private $http;
    private $type;

    /**
     * Set the type of the content pointed by the given $url
     * 
     * @throws Exception when the given content type is different of xml or json
     * @param type $url 
     */
    private function setType($url)
    {
        if (pathinfo($url, PATHINFO_EXTENSION) == 'xml') {
            $this->type = 'xml';
        }
        else if (pathinfo($url, PATHINFO_EXTENSION) == 'json') {
            $this->type = 'json';
        }
        else {
            throw new \Exception('The URL requested does not exist.');
        }
    }

    /**
     *
     * @param HttpAdapterInterface $adapter
     */
    public function __construct($adapter = null)
    {
        if ($adapter == null) {
            $this->http = new \Libcast\HttpAdapter\CurlHttpAdapter();
        }
        else {
            $this->http = $adapter;
        }
    }

    /**
     * Return the HttpAdapter used
     * 
     * @return HttpAdapterInterface
     */
    public function getAdapter()
    {
        return $this->http;
    }

    /**
     * Return the media object pointed by the given URL
     *
     * @param string $url
     * @return Media Object
     */
    public function getMedia($url)
    {
        $this->setType($url);
        $media = new Provider\MediaProvider($this);

        return $media->getLibcastData($url);
    }

    /**
     * Return the stream object pointed by the given URL
     * 
     * @param string $url
     * @return Stream Object
     */
    public function getStream($url)
    {
        $this->setType($url);
        $stream = new Provider\StreamProvider($this);

        return $stream->getLibcastData($url);
    }

    /**
     * Return the resource object pointed by the given URL
     * 
     * @param string $url
     * @return Resource Object
     */
    public function getResource($url)
    {
        $this->setType($url);
        $resource = new Provider\ResourceProvider($this);
        
        return $resource->getLibcastData($url);
    }

    /**
     * Return the type of the last content given by the url
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}