<?php
namespace jspreadsheet;

trait Merge
{
    /**
     * @param string|array $cells
     * @return array
     */
    public function getMerge($cells)
    {
        if (is_array($cells)) {
            $cells = implode(',', $cells);
        }

        return $this->client->get('merge/'. $cells);
    }

    /**
     * @param $cell
     * @param $colspan
     * @param $rowspan
     * @param bool $force
     * @return array
     */
    public function setMerge($cell, $colspan, $rowspan, $force = false)
    {
        $merge = [
            'cell' => $cell,
            'colspan' => $colspan,
            'rowspan' => $rowspan,
            'force' => $force
        ];

        return $this->client->post('merge', $merge);
    }

    /**
     * @param string $cell
     * @return array
     */
    public function removeMerge($cell)
    {
        return $this->client->delete('merge/' . $cell);
    }

    /**
     * @return array
     */
    public function resetMerge()
    {
        return $this->client->delete('merge');
    }
}