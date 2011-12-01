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
interface HttpAdapterInterface
{
    function getContent($url);
    function getName();
}
