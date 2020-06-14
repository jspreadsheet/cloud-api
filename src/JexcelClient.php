<?php
namespace Jexcel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class JexcelClient
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8009/api/',
            'timeout'  => 2.0
        ]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function request($method, $uri, $data = null)
    {
        $options = [
            'headers' => [
                //'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];

        if ($data) {
            $options['form_params'] = $data;
        }

        return $this->client->request($method, $uri, $options);
    }

    /**
     * @param string $uri
     * @return array
     * @throws GuzzleException
     */
    public function get($uri)
    {
        $content = $this->request('GET', $uri)->getBody()->getContents();

        return json_decode($content, true);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     * @throws GuzzleException
     */
    public function post($uri, $options = null)
    {
        $content = $this->request('POST', $uri, $options)->getBody()->getContents();

        return json_decode($content, true);
    }
}
