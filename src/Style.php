<?php
namespace jspreadsheet;

trait Style
{
    /**
     * @param string|array $cells
     * @return array
     */
    public function getStyle($cells)
    {
        if (is_array($cells)) {
            $cells = implode(',', $cells);
        }

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
     * @param string|array $cells
     * @return array
     */
    public function resetStyle($cells)
    {
        if (is_array($cells)) {
            $cells = implode(',', $cells);
        }

        return $this->client->get('style/reset/'. $cells);
    }
}