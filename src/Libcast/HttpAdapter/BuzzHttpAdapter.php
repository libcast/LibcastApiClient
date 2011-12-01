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

use Buzz\Browser;

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
class BuzzHttpAdapter implements HttpAdapterInterface
{
    protected $browser;

    /**
     *
     * @param Browser $browser 
     */
    public function __construct(Browser $browser = null)
    {
        if (null === $browser) {
            $this->browser = new Browser();
        } else {
            $this->browser = $browser;
        }
    }

    /**
     * Return the content of the page pointed by the given $url
     * 
     * @param string $url
     * @return string 
     */
    public function getContent($url)
    {
        try {
            $response = $this->browser->get($url);
            if ($response->getStatusCode() == 404) {
                throw new \Exception('The URL requested does not exist.');    
            }            
            $content  = $response->getContent();              
        } catch (\Exception $e) {
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
        return 'buzz';
    }
}
