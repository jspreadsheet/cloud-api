<?php
namespace jexcel;

trait Merge
{
    /**
     * @param string $cells
     * @return array
     */
    public function getMerge($cells)
    {
        return $this->client->get('/merge/'. $cells);
    }

    /**
     * @param string $cell
     * @param int $colspan
     * @param int $rowspan
     * @return array
     */
    public function setMerge($cell, $colspan, $rowspan)
    {
        $merge = [
            'cell' => $cell,
            'colspan' => $colspan,
            'rowspan' => $rowspan,
        ];

        return $this->client->post('merge', $merge);
    }

    /**
     * @param string $cell
     * @return array
     */
    public function removeMerge($cell)
    {
        return $this->client->get('merge/remove/' . $cell);
    }

    /**
     * @return array
     */
    public function resetMerge()
    {
        return $this->client->get('merge/reset');
    }
}