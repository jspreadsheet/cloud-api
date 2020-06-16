<?php
namespace Jexcel;

class Columns
{
    const DESC = 1;
    const ASC = 0;

    /**
     * @var JexcelClient
     */
    private $client;

    /**
     * @var string $guid
     */
    private $guid;

    /**
     * @var string|int
     */
    private $indexes;

    /**
     * Spreadsheet constructor.
     *
     * @param JexcelClient $client
     * @param string $guid
     * @param string|int $indexes
     */
    public function __construct($client, $guid, $indexes = null)
    {
        $this->client = $client;
        $this->guid = $guid;
        $this->indexes = $indexes;
    }

    /**
     * @return array
     */
    public function getWidth()
    {
        return $this->client->get($this->guid .'/width/'. $this->indexes);
    }

    /**
     * @param int $width
     * @return array
     */
    public function setWidth($width = 50)
    {
        return $this->client->post($this->guid .'/width/'. $this->indexes .'/'. $width);
    }

    /**
     * @param bool $insertBefore
     * @param array $properties
     * @param array $data
     * @return array
     */
    public function insert($insertBefore, $properties, $data = null)
    {
        $options = [
            'columnNumber' => $this->indexes,
            'numOfColumns' => count($properties),
            'insertBefore' => $insertBefore,
            'properties' => $properties,
            'data' => $data
        ];

        return $this->client->post($this->guid .'/columns/insert', $options);
    }

    /**
     * @param int $index
     * @return array
     */
    public function moveTo($index)
    {
        return $this->client->post($this->guid .'/columns/move/'. $this->indexes .','. $index);
    }

    /**
     * @param int $numOfColumns
     * @return array
     */
    public function delete($numOfColumns = 1)
    {
        $options = [
            'columnNumber' => $this->indexes,
            'numOfColumns' => $numOfColumns,
        ];

        return $this->client->post($this->guid .'/columns/delete', $options);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->client->get($this->guid .'/type/'. $this->indexes);
    }

    /**
     * @param array $options
     * @return array
     */
    public function setProperties($options)
    {
        $options = [
            'column' => $this->indexes,
            'options' => $options,
        ];

        return $this->client->post($this->guid .'/type', $options);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get($this->guid .'/data/column/'. $this->indexes);
    }

    /**
     * @param int $direction 0 = ASC, 1 = DESC
     * @return array
     */
    public function orderBy($direction)
    {
        return $this->client->post($this->guid .'/columns/order/'. $this->indexes .'/'. $direction);
    }
}
