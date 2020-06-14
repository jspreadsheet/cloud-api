<?php
namespace Jexcel;

use GuzzleHttp\Exception\GuzzleException;

class Jexcel
{
    /**
     * @var JexcelClient
     */
    private $client;

    /**
     * Jexcel constructor.
     */
    public function __construct()
    {
        $this->client = new JexcelClient(/* tokens */);
    }

    /**
     * describe options here
     * minDimensions [num of rows, num of columns]
     * @param $options
     * @return Spreadsheet
     * @throws GuzzleException
     */
    public function create($options = null)
    {
        if ($options) {
            $options = ['data' => json_encode($options)];
        }

        try {
            $result = $this->client->post('create', $options);

            if (isset($result['success'])) {
                return new Spreadsheet($this->client, $result['token']);
            }

            throw new \Exception('Error on create spreadsheet');
        } catch (\Exception $exception) {
            throw new $exception;
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

        return new Spreadsheet($this->client, $guid);
    }
}