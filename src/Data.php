<?php
namespace Jexcel;

trait Data
{
    /**
     * @return array
     */
    public function getData()
    {
        return $this->client->get('data');
    }

    /**
     * @param array $data
     * @return array
     */
    public function setData($data)
    {
        $data = [ 'data' => $data ];

        return $this->client->post('data', $data);
    }
}