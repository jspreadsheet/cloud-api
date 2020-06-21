<?php
namespace Jexcel;

trait Footers
{
    /**
     * @return array
     */
    public function getFooters()
    {
        return $this->client->get($this->client->guid .'/footers/');
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

        return $this->client->post('footers', $options);
    }

    /**
     * @return array
     */
    public function resetFooters()
    {
        return $this->client->get('footers/reset');
    }
}