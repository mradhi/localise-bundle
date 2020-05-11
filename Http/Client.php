<?php
/**
 * This file is part of the CosaVostra, Localise.biz bundle.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace CosaVostra\LocaliseBundle\Http;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Client
{
    /**
     * @var string
     */
    protected $exportKey;

    /**
     * @var HttpClientInterface
     */
    protected $client;

    public function __construct(string $exportKey)
    {
        $this->exportKey = $exportKey;
        $this->client    = HttpClient::create();
    }

    /**
     * The principle method to make localise.biz requests.
     *
     * @param string $uri
     * @param array  $parameters
     *
     * @return ResponseInterface
     */
    public function request(string $uri, array $parameters = []): ResponseInterface
    {
        $uri = strpos($uri, '/') !== 0 ? $uri = '/' . $uri : $uri;

        return $this->client->request('GET', 'https://localise.biz/api' . $uri, [
            'query' => array_merge($parameters, ['key' => $this->exportKey])
        ]);
    }
}
