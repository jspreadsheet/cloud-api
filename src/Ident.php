<?php
namespace jspreadsheet;

class Ident
{
    /**
     * @param array|string $params
     * @return array
     */
    public static function requestedCells($params)
    {
        $cells = [];
        $params = explode(',', $params);

        foreach ($params as $cell) {
            $res = explode(':', $cell);

            if (! isset($res[1])) {
                $cells[] = $res[0];
            } else {
                $start = self::getIdFromColumnName($res[0]); // A1 = [0, 2]
                $final = self::getIdFromColumnName($res[1]); // B2 = [1, 3]

                // B2:A1
                for ($y = $start[1]; $y <= $final[1]; $y++) {
                    for ($x = $start[0]; $x <= $final[0]; $x++) {
                        $cells[] = self::getColumnNameFromCoords($x, $y);
                    }
                }
            }
        }

        return $cells;
    }

    public static function getIdFromColumnName($id)
    {
        // Get the letters
        preg_match_all("/^[a-zA-Z]+/", $id, $t);

        if ($t) {
            // Base 26 calculation
            $code = 0;
            for ($i = 0; $i < strlen($t[0][0]); $i++) {
                $code += (ord($t[0][0][$i]) - 64) * pow(26, (strlen($t[0][0]) - 1 - $i));
            }
            $code--;
            // Make sure jspreadsheet starts on zero
            if ($code < 0) {
                $code = 0;
            }

            // Number
            preg_match("/[0-9]+$/", $id, $number);

            if ($number && $number[0] > 0) {
                $number[0]--;
            }

            return [ $code, isset($number[0]) ? $number[0] : '' ];
        }

        return $id;
    }

    /**
     * Get letter based on a number
     *
     * @param integer i
     * @return string letter
     */
    public static function getColumnName($i) {
        $letter = '';
        if ($i > 701) {
            $letter .= chr(64 + ($i / 676));
            $letter .= chr(64 + (($i % 676) / 26));
        } else if ($i > 25) {
            $letter .= chr(64 + ($i / 26));
        }
        $letter .= chr(65 + ($i % 26));

        return $letter;
    }

    public static function getColumnNameFromCoords($x, $y)
    {
        return self::getColumnName($x) . ($y + 1);
    }
}
