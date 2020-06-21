<?php
namespace Jexcel;

class Columns
{
    const DESC = 1;
    const ASC = 0;

    /**
     * @var Jexcel instance
     */
    private $client;

    /**
     * @var string|int
     */
    private $indexes;

    /**
     * Spreadsheet constructor.
     *
     * @param Jexcel instance $client
     * @param string $guid
     * @param string|int $indexes
     */
    public function __construct($client,$indexes = null)
    {
        // Jexcel instance
        $this->client = $client;

        // Indexes
        $this->indexes = $indexes;
    }

    /**
     * @return array
     */
    public function getWidth()
    {
        return $this->client->get('width/'. $this->indexes);
    }

    /**
     * @param int $width
     * @return array
     */
    public function setWidth($width = 50)
    {
        return $this->client->post('width/'. $this->indexes .'/'. $width);
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

        return $this->client->post('columns/insert', $options);
    }

    /**
     * @param int $index
     * @return array
     */
    public function moveTo($index)
    {
        return $this->client->post('columns/move/'. $this->indexes .','. $index);
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

        return $this->client->post('columns/delete', $options);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->client->get('properties/'. $this->indexes);
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

        return $this->client->post('properties', $options);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get('data/column/'. $this->indexes);
    }

    /**
     * @param int $direction 0 = ASC, 1 = DESC
     * @return array
     */
    public function orderBy($direction)
    {
        return $this->client->post('columns/order/'. $this->indexes .'/'. $direction);
    }
}
