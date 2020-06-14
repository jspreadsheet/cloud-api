<?php
namespace Jexcel;

class Spreadsheet
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
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    public function getConfig()
    {
        return $this->client->get($this->guid);
    }

    public function getColumns()
    {
        return new Columns($this->client, $this->guid);
    }

    public function getRows()
    {
        return new Rows($this->client, $this->guid);
    }

    public function getCells()
    {
        return new Cells($this->client, $this->guid);
    }

    /**
     * '' => todas as colunas
     * '6' => coluna 6
     * '0,6,7' => colunas 0, 6 e 7
     * @param string $columnsIndex
     * @return array
     */
    public function getHeaders($columnsIndex = '')
    {
        return $this->client->get($this->guid .'/header/'. $columnsIndex);
    }

    /**
     * @param int $columnIndex
     * @param string $title
     * @return array
     */
    public function setHeader($columnIndex, $title)
    {
        $options = [
            'column' => $columnIndex,
            'title' => $title,
        ];

        return $this->client->post($this->guid .'/header', $options);
    }

    /**
     * @return array
     */
    public function getFooters()
    {
        return $this->client->get($this->guid .'/footers/');
    }

    /**
     * @param array
     * @return array
     */
    public function setFooters($footers)
    {
        $options = [
            'data' => $footers,
        ];

        return $this->client->post($this->guid .'/footers', $options);
    }

    /**
     * @return array
     */
    public function resetFooters()
    {
        return $this->client->get($this->guid .'/footers/reset');
    }
}
