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
class CurlHttpAdapter implements HttpAdapterInterface
{
    /**
     * Return the content of the page pointed by the given $url
     * 
     * @param string $url
     * @return string 
     */    
    public function getContent($url)
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('cURL has to be enabled.');
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        $content = curl_exec($c);
        $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
        if($httpCode == 404) {
            throw new \Exception('The URL requested does not exist.');
        }
        curl_close($c);

        if (false === $content) {
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
        return 'curl';
    }
}
