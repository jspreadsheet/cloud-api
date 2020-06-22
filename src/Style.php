<?php
namespace jexcel;

trait Style
{
    /**
     *
     * @return array
     */
    public function getStyle($cells)
    {
        return $this->client->get('style/'. $cells);
    }

    /**
     * @param array
     * @return array
     */
    public function setStyle($config)
    {
        return $this->client->post('style', $config);
    }

    /**
     * @return array
     */
    public function resetStyle()
    {
        return $this->client->post('style/reset');
    }
}