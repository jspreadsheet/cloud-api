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
     * @param string $rowsIndex
     * @return array
     */
    public function getHeight($rowsIndex = '')
    {
        return $this->client->get($this->guid .'/height/'. $rowsIndex);
    }

    public function setHeight($rowsIndex = '', $height)
    {
        return $this->client->post($this->guid .'/height/'. $rowsIndex .'/'. $height);
    }

    /**
     * @param array $rows
     * @param int $rowNumber
     * @param bool $insertBefore
     * @return array
     */
    public function insert($rows, $rowNumber = null, $insertBefore = null)
    {
        $options = [];

        if ($rowNumber >= 0) {
            $dataRows = [];
            $rowIndex = $rowNumber;

            foreach ($rows as $row) {
                $dataRows[] = [
                    'row' => $rowIndex,
                    'data' => $row
                ];

                $rowIndex++;
            }

            $options['rowNumber'] = $rowNumber;
            $options['numOfRows'] = count($rows);
            $options['insertBefore'] = $insertBefore;
            $options['data'] = $dataRows;
        } else {
            $options['data'] = $rows;
        }

        return $this->client->post($this->guid .'/rows/insert', $options);
    }

    /**
     * @param int $from row index
     * @param int $to row index
     * @return array
     */
    public function move($from, $to)
    {
        return $this->client->post($this->guid .'/rows/move/'. $from .','. $to);
    }

    /**
     * @param int $rowIndex
     * @param int $numOfRows
     * @return array
     */
    public function delete($rowIndex, $numOfRows = 1)
    {
        $options = [
            'rowNumber' => $rowIndex,
            'numOfRows' => $numOfRows,
        ];

        return $this->client->post($this->guid .'/rows/delete', $options);
    }
}
