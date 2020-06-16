<?php
namespace Jexcel;

class Worksheets
{
    /**
     * @var JexcelClient
     */
    private $client;

    /**
     * @var string $guid
     */
    private $guid;

    /**
     * @var int
     */
    private $index;

    /**
     * Spreadsheet constructor.
     *
     * @param JexcelClient $client
     * @param string $guid
     * @param string|int $index
     */
    public function __construct($client, $guid, $index = null)
    {
        $this->client = $client;
        $this->guid = $guid;
        $this->index = $index;
    }

    /**
     * @param array $configs
     * @return array
     */
    public function create($configs = null)
    {
        return $this->client->post($this->guid .'/worksheets/create/', $configs);
    }

    /**
     * @param string $newName
     * @return array
     */
    public function rename($newName)
    {
        $data = [
            'worksheet' => $this->index,
            'newValue' => $newName
        ];

        return $this->client->post($this->guid .'/worksheets/rename/', $data);
    }

    /**
     * @return array
     */
    public function delete()
    {
        return $this->client->post($this->guid .'/worksheets/delete/'. $this->index);
    }

    /**
     * @param int $index
     * @return array
     */
    public function moveTo($index)
    {
        $guid = explode(',', $this->guid);
        $guid = $guid[0];

        return $this->client->post($guid .'/worksheets/move/'. $this->index .','. $index);
    }
}
