# cakephp-bitly
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Total Downloads](https://img.shields.io/packagist/dt/frankfoerster/cakephp-bitly.svg?style=flat-square)](https://packagist.org/packages/frankfoerster/cakephp-bitly)
[![Latest Stable Version](https://img.shields.io/packagist/v/frankfoerster/cakephp-bitly.svg?style=flat-square&label=stable)](https://packagist.org/packages/frankfoerster/cakephp-bitly)

The cakephp-bitly plugin provides a wrapper for the bit.ly API to shorten long urls.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

Run the following command
```sh
composer require frankfoerster/cakephp-bitly
```

## Configuration

You can load the plugin using the shell command:

```
bin/cake plugin load FrankFoerster/Bitly
```

Or you can manually add the loading statement in the **config/boostrap.php** file of your application:

```php
Plugin::load('FrankFoerster/Bitly');
```

## Configure the Plugin

To use the UrlShortener you have to provide your bitly login name and your bitly API key as config entries within ``/config/app.php``.

```php
return [
    ...
    
    'Bitly' => [
        'login' => 'YOUR_LOGIN',
        'apiKey' => 'YOUR_API_KEY',

        /**
         * @link: http://book.cakephp.org/3.0/en/core-libraries/httpclient.html#proxy-authentication
         *
         * e.g.:
         * -----
         * 'proxy' => [
         *   'username' => 'foo', // optional username set in request header
         *   'password' => 'bar', // optional password set in request header
         *   'proxy' => 'tcp://localhost:9000'
         * ]
         */
        'proxy' => false
    ],
    
    ...
];
```

To obtain an api key sign up at https://bitly.com/a/sign_up .

## Use the UrlShortener

To use the url shortener you have to instatiate a new UrlShortener instance. It will setup your instance with the configured parameters automatically.

You can wrap your calls in a try catch block (see below), because the cakephp-bitly plugin throws custom exceptions that represent all possible error responses from the bitly API.
They all extend from the BitlyException and can be handled separately via multiple catch blocks.

```php
use FrankFoerster\Bitly\Exception\BitlyException;
use FrankFoerster\Bitly\UrlShortener;

$urlShortener = new UrlShortener();

try {
    $shortUrl = $urlShortener->shorten($myLongUrl);
} catch (BitlyException $e) {
    // handle any of the exceptions
}
```
