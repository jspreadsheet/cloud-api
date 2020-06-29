<?php
namespace jexcel;

class Spreadsheet
{
    use Merge, Style, Footers, Headers;

    /**
     * @var Jexcel
     */
    private $client;

    /**
     * Spreadsheet constructor.
     *
     * @param Jexcel controller
     */
    public function __construct(Jexcel $jexcel)
    {
        $this->client = $jexcel;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->client->get('config');
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

        return new Columns($this->client, $indexes);
    }

    /**
     * @param int $index
     * @return Columns
     */
    public function getColumn($index)
    {
        return new Columns($this->client, $index);
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

        return new Rows($this->client, $indexes);
    }

    /**
     * @param int $index
     * @return Rows
     */
    public function getRow($index)
    {
        return new Rows($this->client, $index);
    }

    /**
     * @return Cells
     */
    public function getCells($indexes = null)
    {
        if (is_array($indexes)) {
            $indexes = implode(',', $indexes);
        }

        return new Cells($this->client, $indexes);
    }

    /**
     * @param string $index
     * @return Cells
     */
    public function getCell($index)
    {
        return new Cells($this->client, $index);
    }

    /**
     * Get a worksheet
     */
    public function getWorksheet($index = 0)
    {
        return new Worksheets($this->client, $index);
    }

    /**
     * @param array $configs
     * @return array
     */
    public function createWorksheet($configs = null)
    {
        return $this->client->post('worksheets/create/', $configs);
    }
}
