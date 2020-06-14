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

    /**
     * '' =>
     * 'A1' =>
     * 'A1,A2' =>
     * 'A1:B2' =>
     * @param string $cells
     * @return array
     */
    public function getData($cells = '')
    {
        return $this->client->get($this->guid .'/data/range/'. $cells);
    }
}
