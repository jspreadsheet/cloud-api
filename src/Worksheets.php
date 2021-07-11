<?php
namespace jspreadsheet;

class Worksheets
{
    /**
     * @var int
     */
    private $client;

    /**
     * Spreadsheet constructor.
     *
     * @param Jspreadsheet instance
     */
    public function __construct(Jspreadsheet $j, $index = 0)
    {
        // Jspreadsheet instance
        $this->client = $j;

        // Worksheet
        $this->index = $index;
    }

    /**
     * @param string $newName
     * @return array
     */
    public function rename($name)
    {
        $data = [
            'worksheet' => $this->index,
            'name' => $name
        ];

        return $this->client->post('worksheets/rename', $data);
    }

    /**
     * @return array
     */
    public function delete()
    {
        return $this->client->delete('worksheets/' . $this->index);
    }

    /**
     * @param int $index
     * @return array
     */
    public function move($index)
    {
        return $this->client->post('worksheets/move/' . $this->index . '/' . $index);
    }
}
