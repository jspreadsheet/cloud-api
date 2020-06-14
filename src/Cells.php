<?php
namespace Jexcel;

class Cells
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
     * '' => todos comentarios
     * 'A1' =>
     * 'A1,A2' =>
     * 'A1:B2' =>
     * @param string $cells
     * @return array
     */
    public function getComments($cells = '')
    {
        return $this->client->get($this->guid .'/comments/'. $cells);
    }

    /**
     * @param array $columns
     * @return array
     */
    public function setComments($comments)
    {
        return $this->client->post($this->guid .'/comments/', $comments);
    }

    public function resetComments()
    {
        return $this->client->get($this->guid .'/comments/reset');
    }

    /**
     * '' => todas
     * 'A1' =>
     * 'A1,A2' =>
     * 'A1:B2' =>
     * @param string $cells
     * @return array
     */
    public function getMeta($cells = '')
    {
        return $this->client->get($this->guid .'/meta/'. $cells);
    }

    /**
     * @param array $metas
     * @return array
     */
    public function setMeta($metas)
    {
        return $this->client->post($this->guid .'/meta/', $metas);
    }

    public function resetMeta()
    {
        return $this->client->get($this->guid .'/meta/reset');
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
     * '' =>
     * 'A1' =>
     * 'A1,A2' =>
     * 'A1:B2' =>
     * @param string $cells
     * @return array
     */
    public function getValues($cells = '')
    {
        return $this->client->get($this->guid .'/value/'. $cells);
    }

    /**
     * @param array $values
     * @return array
     */
    public function setValues($values)
    {
        return $this->client->post($this->guid .'/value/', $values);
    }
}
