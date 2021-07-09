<?php
namespace jspreadsheet;

class Rows
{
    /**
     * @var Jspreadsheet instance
     */
    private $client;
    /**
     * @var string|int
     */
    private $indexes;

    /**
     * Spreadsheet constructor.
     *
     * @param Jspreadsheet $client
     * @param string $guid
     * @param string|int $indexes
     */
    public function __construct($client, $indexes = null)
    {
        // Jspreadsheet controller
        $this->client = $client;

        // Row numbers
        $this->indexes = $indexes;
    }

    /**
     * @return array
     */
    public function getHeight()
    {
        return $this->client->get('height/'. $this->indexes);
    }

    public function setHeight($height)
    {
        return $this->client->post('height/'. $this->indexes .'/'. $height);
    }

    /**
     * @param array $rows
     * @param bool $insertBefore
     * @return array
     */
    public function insert($rows, $insertBefore = null)
    {
        if (! $rows) {
            return [];
        }

        if (! isset($rows[0]) || ! is_array($rows)) {
            $rows = [ $rows ];
        }

        $options = [];

        if (isset($this->indexes) && $this->indexes >= 0) {
            $options['rowNumber'] = $this->indexes;
            $options['numOfRows'] = count($rows);
            $options['insertBefore'] = $insertBefore;
        }

        $options['data'] = $rows;

        return $this->client->post('rows/insert', $options);
    }

    /**
     * @param int $to row index
     * @return array
     */
    public function moveTo($to)
    {
        return $this->client->post('rows/move/'. $this->indexes .','. $to);
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

        return $this->client->post('rows/delete', $options);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get('rows/'. $this->indexes);
    }
}
