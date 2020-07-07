<?php
namespace jexcel;

class Cells
{
    /**
     * @var Jexcel instance
     */
    private $client;

    /**
     * @var string
     */
    private $indexes;

    /**
     * Spreadsheet constructor.
     *
     * @param Jexcel instance $client
     * @param string $guid
     * @param string $indexes
     */
    public function __construct(Jexcel $client, $indexes)
    {
        // Jexcel instance
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
    public function getMetas()
    {
        return $this->client->get('meta/'. $this->indexes);
    }

    /**
     * @param array $metas
     * @return array
     */
    public function setMetas($metas)
    {
        return $this->client->post('meta/', $metas);
    }

    /**
     * @param array $meta
     * @return array
     */
    public function setMeta($meta)
    {
        $metas = [$this->indexes => $meta];

        return $this->client->post('meta/', $metas);
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
     * @param array $values
     * @return array
     */
    public function setValues($values)
    {
        return $this->client->post('value/', $values);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get('data/range/'. $this->indexes);
    }
}
