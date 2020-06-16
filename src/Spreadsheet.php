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

    /**
     * @param array $indexes
     * @return Columns
     */
    public function getColumns($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Columns($this->client, $this->guid, $indexes);
    }


    /**
     * @param int $index
     * @return Columns
     */
    public function getColumn($index)
    {
        return new Columns($this->client, $this->guid, $index);
    }

    /**
     * @param array $indexes
     * @return Rows
     */
    public function getRows($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Rows($this->client, $this->guid, $indexes);
    }

    /**
     * @param int $index
     * @return Rows
     */
    public function getRow($index)
    {
        return new Rows($this->client, $this->guid, $index);
    }

    /**
     * @return Cells
     */
    public function getCells($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Cells($this->client, $this->guid, $indexes);
    }

    /**
     * @param string $index
     * @return Cells
     */
    public function getCell($index)
    {
        return new Cells($this->client, $this->guid, $index);
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

    /**
     *
     * @return array
     */
    public function getStyle($cells)
    {
        return $this->client->get($this->guid .'/style/'. $cells);
    }

    /**
     * @param array
     * @return array
     */
    public function setStyle($style)
    {
        return $this->client->post($this->guid .'/style', $style);
    }

    /**
     * @return array
     */
    public function resetStyle()
    {
        return $this->client->get($this->guid .'/style/reset');
    }

    /**
     * @param string $cells
     * @return array
     */
    public function getMerge($cells)
    {
        return $this->client->get($this->guid .'/merge/'. $cells);
    }

    /**
     * @param string $cell
     * @param int $colspan
     * @param int $rowspan
     * @return array
     */
    public function setMerge($cell, $colspan, $rowspan)
    {
        $merge = [
            'cell' => $cell,
            'colspan' => $colspan,
            'rowspan' => $rowspan,
        ];

        return $this->client->post($this->guid .'/merge', $merge);
    }

    /**
     * @param string $cell
     * @return array
     */
    public function removeMerge($cell)
    {
        return $this->client->get($this->guid .'/merge/remove/'. $cell);
    }

    /**
     * @return array
     */
    public function resetMerge()
    {
        return $this->client->get($this->guid .'/merge/reset');
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get($this->guid .'/data/');
    }

    /**
     * @param array $data
     * @return array
     */
    public function setData($data)
    {
        $data = [ 'data' => $data ];

        return $this->client->post($this->guid .'/data/', $data);
    }

    public function getWorksheet($index)
    {
        return new Worksheets($this->client, $this->guid .','. $index, $index);
    }

    /**
     * @param array $configs
     * @return array
     */
    public function createWorksheet($configs = null)
    {
        return $this->client->post($this->guid .'/worksheets/create/', $configs);
    }
}
