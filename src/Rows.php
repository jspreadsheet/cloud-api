<?php
namespace Jexcel;

class Rows
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
    public function getHeight()
    {
        return $this->client->get($this->guid .'/height/'. $this->indexes);
    }

    public function setHeight($height)
    {
        return $this->client->post($this->guid .'/height/'. $this->indexes .'/'. $height);
    }

    /**
     * @param array $rows
     * @param bool $insertBefore
     * @return array
     */
    public function insert($rows, $insertBefore = null)
    {
        $options = [];

        if (isset($this->indexes) && $this->indexes >= 0) {
            $dataRows = [];
            $rowIndex = $this->indexes;

            foreach ($rows as $row) {
                $dataRows[] = [
                    'row' => $rowIndex,
                    'data' => $row
                ];

                $rowIndex++;
            }

            $options['rowNumber'] = $this->indexes;
            $options['numOfRows'] = count($rows);
            $options['insertBefore'] = $insertBefore;
            $options['data'] = $dataRows;
        } else {
            $options['data'] = $rows;
        }

        return $this->client->post($this->guid .'/rows/insert', $options);
    }

    /**
     * @param int $to row index
     * @return array
     */
    public function moveTo($to)
    {
        return $this->client->post($this->guid .'/rows/move/'. $this->indexes .','. $to);
    }

    /**
     * @param int $numOfRows
     * @return array
     */
    public function delete($numOfRows = 1)
    {
        $options = [
            'rowNumber' => $this->indexes,
            'numOfRows' => $numOfRows,
        ];

        return $this->client->post($this->guid .'/rows/delete', $options);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get($this->guid .'/data/row/'. $this->indexes);
    }
}
