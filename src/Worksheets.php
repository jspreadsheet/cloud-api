<?php
namespace jexcel;

class Worksheets
{
    /**
     * @var int
     */
    private $client;

    /**
     * Spreadsheet constructor.
     *
     * @param Jexcel instance
     */
    public function __construct(Jexcel $jexcel, $index = 0)
    {
        // Jexcel instance
        $this->client = $jexcel;

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
        return $this->client->post('worksheets/delete/' . $this->index);
    }

    /**
     * @param int $index
     * @return array
     */
    public function moveTo($index)
    {
        return $this->client->post('worksheets/move/' . $this->client->guid . ',' . $index);
    }
}
