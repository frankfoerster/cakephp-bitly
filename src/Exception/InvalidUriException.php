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
namespace FrankFoerster\Bitly\Exception;

class InvalidUriException extends BitlyException
{
    /**
     * Constructor
     *
     * @param string $message
     * @param int $code Status code, defaults to 500
     */
    public function __construct($message = null, $code = 500)
    {
        $msg = 'The URL that is to be shortened is invalid.';
        if (!empty($message)) {
            $msg .= ' "' . urldecode($message) . '"';
        }
        parent::__construct($msg, $code);
    }
}
