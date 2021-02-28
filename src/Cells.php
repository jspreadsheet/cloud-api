<?php
namespace jspreadsheet;

class Cells
{
    /**
     * @var Jspreadsheet instance
     */
    private $client;

    /**
     * @var string
     */
    private $indexes;

    /**
     * Spreadsheet constructor.
     *
     * @param Jspreadsheet instance $client
     * @param string $guid
     * @param string $indexes
     */
    public function __construct(Jspreadsheet $client, $indexes)
    {
        // Jspreadsheet instance
        $this->client = $client;

        // Indexes
        $this->indexes = $indexes;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->client->get('comments/'. $this->indexes);
    }

    /**
     * @param array $comments
     * @return array
     */
    public function setComments($comments)
    {
        return $this->client->post('comments/', $comments);
    }

    /**
     * @param string $comment
     * @return array
     */
    public function setComment($comment)
    {
        $comments = [$this->indexes => $comment];

        return $this->client->post('comments/', $comments);
    }

    public function resetComments()
    {
        return $this->client->get('comments/reset');
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->client->get('meta/'. $this->indexes);
    }

    /**
     * @param array $meta
     * @return array
     */
    public function setMeta($meta)
    {
        // If $meta is not multidimensional: $meta = ['X999' => $meta]
        if (count($meta) == count($meta, COUNT_RECURSIVE)) {
            $meta = [$this->indexes => $meta];
        }

        return $this->client->post('meta/', $meta);
    }

    public function resetMeta()
    {
        return $this->client->get('meta/reset');
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->client->get('cells/properties/'. $this->indexes);
    }

    /**
     * @param array $options
     * @return array
     */
    public function setProperties($options)
    {
        return $this->client->post('cells/properties/'. $this->indexes, $options);
    }

    /**
     * @return array
     */
    public function resetProperties()
    {
        return $this->client->post('cells/properties/reset/'. $this->indexes);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->client->get('value/'. $this->indexes);
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function setValue($value)
    {
        $data = [];
        $indexes = Ident::requestedCells($this->indexes);

        foreach ($indexes as $index) {
            $index = Ident::getIdFromColumnName($index);

            $data[] = ['x' => $index[0], 'y' => $index[1], 'value' => $value];
        }

        return $this->client->post('value/', $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get('data/range/'. $this->indexes);
    }
}
