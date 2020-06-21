<?php
namespace Jexcel;

trait Headers
{
    /**
     * '' => todas as colunas
     * '6' => coluna 6
     * '0,6,7' => colunas 0, 6 e 7
     * @param string $columnsIndex
     * @return array
     */
    public function getHeaders($columnsIndex = '')
    {
        return $this->client->get('header/'. $columnsIndex);
    }

    /**
     * @param int $columnIndex
     * @param string $title
     * @return array
     */
    public function setHeader($columnIndex, $title)
    {
        $options = [
            'column' => $columnIndex,
            'title' => $title,
        ];

        return $this->client->post('header', $options);
    }
}