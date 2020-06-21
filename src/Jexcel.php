<?php

namespace jexcel;

class Jexcel
{
    /**
     * @var Jexcel Api Key
     */
    private $key;

    /**
     * @var Jexcel Api Key
     */
    public $guid;

    /**
     * Jexcel constructor.
     */
    public function __construct($key = null)
    {
        if (! $key) {
            return 'API Key not defined';
        } else {
            $this->key = $key;
        }
    }

    /**
     * @param string $guid
     * @param int $tab
     * @return Spreadsheet
     */
    public function getSpreadsheet($guid, $tab = 0)
    {
        if ($tab != 0) {
            $guid .= ','. $tab;
        }

        $this->guid = $guid;

        return new Spreadsheet($this);
    }


    /**
     * @param string $uri
     * @return array
     */
    public function get($url)
    {
        $content = $this->request('GET', $url);

        return json_decode($content, true);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     */
    public function post($url, $options = null)
    {
        $content = $this->request('POST', $url, $options);

        return json_decode($content, true);
    }

    /**
     * Final HTTP request
     * @param string $url
     * @param array $data
     * @return array
     */
    public function request($method, $url, $data = null)
    {
        $headers = [
            'Accept: text/json',
            'Authorization: Bearer ' . $this->key,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $curl = curl_init('http://web/api/' . $url);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
        }

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);

        print_r($response);

        return $response;
    }
}