<?php
namespace Jexcel;

class Cells
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
     * @var string
     */
    private $indexes;

    /**
     * Spreadsheet constructor.
     *
     * @param JexcelClient $client
     * @param string $guid
     * @param string $indexes
     */
    public function __construct($client, $guid, $indexes)
    {
        $this->client = $client;
        $this->guid = $guid;
        $this->indexes = $indexes;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->client->get($this->guid .'/comments/'. $this->indexes);
    }

    /**
     * @param array $comments
     * @return array
     */
    public function setComments($comments)
    {
        return $this->client->post($this->guid .'/comments/', $comments);
    }

    /**
     * @param string $comment
     * @return array
     */
    public function setComment($comment)
    {
        $comments = [$this->indexes => $comment];

        return $this->client->post($this->guid .'/comments/', $comments);
    }

    public function resetComments()
    {
        return $this->client->get($this->guid .'/comments/reset');
    }

    /**
     * @return array
     */
    public function getMetas()
    {
        return $this->client->get($this->guid .'/meta/'. $this->indexes);
    }

    /**
     * @param array $metas
     * @return array
     */
    public function setMetas($metas)
    {
        return $this->client->post($this->guid .'/meta/', $metas);
    }

    /**
     * @param array $meta
     * @return array
     */
    public function setMeta($meta)
    {
        $metas = [$this->indexes => $meta];

        return $this->client->post($this->guid .'/meta/', $metas);
    }

    public function resetMeta()
    {
        return $this->client->get($this->guid .'/meta/reset');
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->client->get($this->guid .'/cells/properties/'. $this->indexes);
    }

    /**
     * @param array $options
     * @return array
     */
    public function setProperties($options)
    {
        return $this->client->post($this->guid .'/cells/properties/'. $this->indexes, $options);
    }

    /**
     * @return array
     */
    public function resetProperties()
    {
        return $this->client->post($this->guid .'/cells/properties/reset/'. $this->indexes);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->client->get($this->guid .'/value/'. $this->indexes);
    }

    /**
     * @param array $values
     * @return array
     */
    public function setValues($values)
    {
        return $this->client->post($this->guid .'/value/', $values);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get($this->guid .'/data/range/'. $this->indexes);
    }
}
