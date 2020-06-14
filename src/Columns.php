<?php
namespace Jexcel;

class Columns
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
     * Spreadsheet constructor.
     *
     * @param JexcelClient $client
     * @param string $guid
     */
    public function __construct($client, $guid)
    {
        $this->client = $client;
        $this->guid = $guid;
    }

    /**
     * '' => width de todas as colunas
     * '6' => width da coluna 6
     * '0,6,7' => width das colunas 0, 6 e 7
     * @param string $columnsIndex
     * @return array
     */
    public function getWidth($columnsIndex = '')
    {
        return $this->client->get($this->guid .'/width/'. $columnsIndex);
    }

    /**
     * @param string $columnsIndex
     * @param int $width
     * @return array
     */
    public function setWidth($columnsIndex = '', $width = 50)
    {
        return $this->client->post($this->guid .'/width/'. $columnsIndex .'/'. $width);
    }

    /**
     * @param int $columnNumber
     * @param bool $insertBefore
     * @param array $properties
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function insert($columnNumber, $insertBefore, $properties, $data = null)
    {
        $options = [
            'columnNumber' => $columnNumber,
            'numOfColumns' => count($properties),
            'insertBefore' => $insertBefore,
            'properties' => $properties,
            'data' => $data
        ];

        return $this->client->post($this->guid .'/columns/insert', $options);
    }

    /**
     * @param int $from column index
     * @param int $to column index
     * @return array
     */
    public function move($from, $to)
    {
        return $this->client->post($this->guid .'/columns/move/'. $from .','. $to);
    }

    /**
     * @param int $columnIndex
     * @param int $numOfColumns
     * @return array
     */
    public function delete($columnIndex, $numOfColumns = 1)
    {
        $options = [
            'columnNumber' => $columnIndex,
            'numOfColumns' => $numOfColumns,
        ];

        return $this->client->post($this->guid .'/columns/delete', $options);
    }

    /**
     * '' => type de todas as colunas
     * '6' => type da coluna 6
     * '0,6,7' => type das colunas 0, 6 e 7
     * @param string $columnsIndex
     * @return array
     */
    public function getType($columnsIndex = '')
    {
        return $this->client->get($this->guid .'/type/'. $columnsIndex);
    }

    /**
     * @param int $columnsIndex
     * @param array $options
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setType($columnsIndex, $options)
    {
        $options = [
            'column' => $columnsIndex,
            'options' => $options,
        ];

        return $this->client->post($this->guid .'/type', $options);
    }

    /**
     * '' => todas as colunas
     * '6' => coluna 6
     * '0,6,7' => colunas 0, 6 e 7
     * @param string $columnsIndex
     * @return array
     */
    public function getData($columnsIndex)
    {
        return $this->client->get($this->guid .'/data/column/'. $columnsIndex);
    }
}
