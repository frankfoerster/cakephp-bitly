<?php
/**
 * CakePHP Bitly Plugin
 * Copyright (c) Frank Förster (http://frankfoerster.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Frank Förster (http://frankfoerster.com)
 * @homepage      http://www.github.com/frankfoerster/cakephp-bitly
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * CakePHP Bitly Plugin config.
 * Replace YOUR_LOGIN and YOUR_API_KEY with your bitly.com credentials.
 */
return [
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
    ]
];
