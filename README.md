LibcastApiClient
================

[LibcastApiClient](https://github.com/libcast/LibcastApiClient 'LibcastApiClient')
provides a thin PHP client for the Libcast public API.
It helps you to retrieve objects from the Libcast domain (media, stream or resource)
and use them in your application, or create a frontoffice layer upon the data
available through the public API.


Installation
------------

Requirements: PHP 5.3 or higher

An `autoload.php` is available if you don't have *ClassLoader* in your project.
Just require it as shown below:

    <?php
    
    require_once 'src/autoload.php';


Usage
-----

The first step to access the data is to instantiate the `LibcastClient`:

    <?php
    
    $libcast = new Libcast\LibcastClient();

Since the API is public and open, there is not need to have an API key.

You can then retrieve data from the Libcast website:

    <?php
    
    $stream = $libcast->getStream('http://api.libcast.tv/stream/birds');
    echo $stream->getDescription();

The public API is designed only to retrieve data, it can't create nor modify data.


API
---

Libcast public API provides 3 services at the moment: media, stream and resource.
Each service (media, stream and resource) is available in both JSON and XML formats.

In the LibcastClient class, you have 3 methods available for each types of content:

  * `getMedia($url)` retrieves a `Media` from its URL
  * `getStream($url)` retrieves a `Stream` from its URL
  * `getResource($url)` retrieves a `Resource` from its URL

You can provide both XML or JSON URL.

`Media` class:

  * `getName()` returns the name of the media (string)
  * `getDescription()` returns the description of the media (string)
  * `getStreams()` returns the streams bound to the media (array of `Stream`)

`Stream` class

  * `getTitle()` returns the title of the stream (string)
  * `getDescription()` returns the description of the stream (string)
  * `getMedia()` returns the media of the stream (`Media`)
  * `getResources()` returns the resources bound to the stream (array of `Resource`)

`Resource` class

  * `getTitle()` return the title of the resource (string)
  * `getDescription()` return the description of the resource (string)
  * `getStream()` return the stream parent of the resource (`Stream`)


### Exceptions

  * If the provided URL is invalid, an exception is thrown:
    `The URL requested does not exist`.
  * If the URL don't fit the requested data type, an exception is thrown:
    `The requested URL is not a stream`


### Adapters

If you don't give any parameter during the `LibcastClient` instantiation, the
default `HttpAdapter`, [cURL](http://php.net/manual/book.curl.php 'cURL'), will
be used. You can use another adapter:

    <?php
    
    $adapter = new Libcast\HttpAdapter\BuzzHttpAdapter();
    $libcast = new Libcast\LibcastClient($adapter);

At the moment, available adapters are:

  * [Buzz](https://github.com/kriswallsmith/Buzz 'Buzz')
  * [cURL](http://php.net/manual/book.curl.php 'cURL')
  * [Guzzle](https://github.com/guzzle/guzzle 'Guzzle')
  * [Zend Http Client](http://framework.zend.com/manual/en/zend.http.client.html 'Zend_Http_Client')

You can also create your own adapter by implementing `HttpAdapterInterface`.


Credits and license
-------------------

Libcast (contact@libcast.com)

`LibcastApiClient` is released under the [LGPL License](http://www.gnu.org/licenses/lgpl.html 'LGPL License').
See the bundled LICENSE file for details.