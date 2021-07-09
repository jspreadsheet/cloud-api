<?php
namespace jspreadsheet;

trait Footers
{
    /**
     * @return array
     */
    public function getFooters()
    {
        return $this->client->get('footers');
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
        return $this->client->post('footers/reset');
    }
}