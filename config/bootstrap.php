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

use Cake\Core\Configure;

// try to Load the bitly config
try {
    Configure::load('bitly');
} catch (\Cake\Core\Exception\Exception $e) {
    throw new \FrankFoerster\Bitly\Exception\MissingConfigurationFileException();
}
