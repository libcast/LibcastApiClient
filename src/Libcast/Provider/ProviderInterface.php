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

/**
 * @author Libcast <team-dev@libcast.com>
 */ 
interface ProviderInterface
{
  function getLibcastData($url);
  function getName();
}
