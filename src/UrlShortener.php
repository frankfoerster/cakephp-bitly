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
namespace FrankFoerster\Bitly;

use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Cake\Utility\Text;
use FrankFoerster\Bitly\Exception\InvalidApiKeyException;
use FrankFoerster\Bitly\Exception\InvalidLoginException;
use FrankFoerster\Bitly\Exception\InvalidUriException;
use FrankFoerster\Bitly\Exception\MissingApiKeyException;
use FrankFoerster\Bitly\Exception\MissingLoginException;
use FrankFoerster\Bitly\Exception\RateLimitExceededException;
use FrankFoerster\Bitly\Exception\TemporaryUnavailableException;
use FrankFoerster\Bitly\Exception\UnknownErrorException;

class UrlShortener
{
    /**
     * The bitly.com API endpoint.
     */
    const ENDPOINT = 'https://api-ssl.bitly.com/v3/';

    /**
     * The path to the shorten action.
     */
    const SHORTEN = 'shorten';

    /**
     * Holds a configured instance of the http client.
     *
     * @var Client
     */
    public $http;

    /**
     * Holds the bitly.com login used to make API requests.
     *
     * @var string
     */
    protected $_login;

    /**
     * Holds the bitly.com api key used to make API requests.
     *
     * @var string
     */
    protected $_apiKey;

    /**
     * Constructor
     *
     * @throws MissingLoginException
     * @throws MissingApiKeyException
     */
    public function __construct()
    {
        if (!($login = Configure::read('Bitly.login')) ||
            !is_string($login) ||
            $login === 'YOUR_LOGIN'
        ) {
            throw new MissingLoginException();
        }

        if (!($apiKey = Configure::read('Bitly.apiKey')) ||
            !is_string($apiKey) ||
            $apiKey === 'YOUR_API_KEY'
        ) {
            throw new MissingApiKeyException();
        }

        $this->_login = $login;
        $this->_apiKey = $apiKey;

        $clientOptions = [];
        if (($proxy = Configure::read('Bitly.proxy')) !== false) {
            $clientOptions['proxy'] = $proxy;
        }
        $this->http = new Client($clientOptions);
    }

    /**
     * Shorten the given $url, handle response errors and return a BitlyResponseData object.
     *
     * @param string $url
     * @return BitlyResponseData|null
     */
    public function shorten($url)
    {
        $longUrl = urlencode($url);

        $apiRequest = Text::insert(':shortenEndpoint?login=:login&apiKey=:apiKey&longUrl=:longUrl', [
            'shortenEndpoint' => self::ENDPOINT . self::SHORTEN,
            'login' => $this->_login,
            'apiKey' => $this->_apiKey,
            'longUrl' => $longUrl
        ]);
        /** @var null|BitlyResponse $response */
        $response = $this->http->get($apiRequest)->body('json_decode');

        $this->_handleBitlyResponse($response, $longUrl);

        return $response->data;
    }

    /**
     * Process the response and throw specific exceptions so the developer
     * can handle them separately via try/catch.
     *
     * @param BitlyResponse $response
     * @param string $longUrl
     * @throws UnknownErrorException
     * @throws InvalidApiKeyException
     * @throws InvalidLoginException
     * @throws RateLimitExceededException
     * @throws TemporaryUnavailableException
     */
    protected function _handleBitlyResponse($response, $longUrl)
    {
        if (!$response || !isset($response->status_code) || !isset($response->status_txt)) {
            throw new UnknownErrorException();
        }

        if ($response->status_code === 200) {
            return;
        }

        switch ($response->status_txt) {
            case 'INVALID_APIKEY':
                throw new InvalidApiKeyException();
                break;
            case 'INVALID_LOGIN':
                throw new InvalidLoginException();
                break;
            case 'RATE_LIMIT_EXCEEDED':
                throw new RateLimitExceededException();
                break;
            case 'TEMPORARY_UNAVAILABLE':
                throw new TemporaryUnavailableException();
                break;
            case 'INVALID_URI':
                throw new InvalidUriException($longUrl);
                break;
            default:
                throw new UnknownErrorException();
        }
    }
}
