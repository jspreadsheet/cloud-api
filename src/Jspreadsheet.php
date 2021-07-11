<?php
namespace jspreadsheet;

class Jspreadsheet
{
    use License;

    /**
     * Debug mode
     * @var string
     */
    public $debug = false;

    /**
     * @var Jspreadsheet Api Key
     */
    private $key;

    /**
     * Address
     */
    private $url = 'https://jspreadsheet.com/api/';

    /**
     * @var Jspreadsheet Api Key
     */
    public $guid;

    /**
     * Jspreadsheet constructor.
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

    public function setActiveWorksheet($tab)
    {
        $guid = explode(',', $this->guid);

        $guid[1] = (int) $tab;

        $this->guid = implode(',', $guid);
    }

    /**
     * @param array $configs
     * @return array
     */
    public function create($configs = null)
    {
        return $this->post('create', $configs);
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
     * @param string $uri
     * @param array $options
     * @return array
     */
    public function delete($url, $options = null)
    {
        $content = $this->request('DELETE', $url, $options);

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

        // Destination URL
        $request = $this->url;
        if ($this->guid) {
            $request .= $this->guid . '/';
        }
        $request .= $url;

        // URL
        $curl = curl_init($request);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
        } else if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if ($this->debug == true) {
            curl_setopt($curl, CURLOPT_VERBOSE, true);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        if ($this->debug == true) {
            echo '<pre>';
            print_r(curl_error($curl));
            print_r(curl_getinfo($curl));
        }

        $response = curl_exec($curl);

        if ($this->debug == true) {
            echo $response;
        }

        curl_close($curl);



        return $response;
    }
}