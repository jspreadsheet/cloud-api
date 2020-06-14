<?php
require 'vendor/autoload.php';

use Jexcel\Jexcel;

$jexcel = new Jexcel();

// get widths
//$spreadsheet = $jexcel->getSpreadSheet('f0a9d5c1-2106-4641-86b1-71c144f61255');
//print_r($spreadsheet->getColumns()->getWidth()); // [40, 40, 45]

/*
//create default
$spreadsheet = $jexcel->create();
// get guid
print_r($spreadsheet->getGuid()); // 09e152f4-1114-47db-a4b2-166b48ab33f6
*/

// create with options
//$spreadsheet = $jexcel->create([
//    'minDimensions' => [30, 30]
//]);
//
//print_r($spreadsheet->getConfig()); // show configs


$spreadsheet = $jexcel->getSpreadsheet('4b4743d5-e5b0-47a9-93cd-a4144371bcbb');

// get widths
//print_r($spreadsheet->getColumns()->getWidth()); // Array ( [0] => 253 [1] => 50 [2] => 50 [3] => 50 [4] => 50 [5] => 50 [6] => 205 [7] => 50 [8] => 50 [9] => 50 [10] => 50 [11] => 50 [12] => 149 [13] => 50 )
//print_r($spreadsheet->getColumns()->getWidth('6')); // Array ( [6] => 205 )
//print_r($spreadsheet->getColumns()->getWidth('0,6,7')); // Array ( [0] => 253 [6] => 205 [7] => 50 )

// set widths
//$spreadsheet->getColumns()->setWidth('6', 208);
//print_r($spreadsheet->getColumns()->getWidth('6')); // Array ( [6] => 208 )
//$spreadsheet->getColumns()->setWidth('2,3,4', 40);
//print_r($spreadsheet->getColumns()->getWidth('2,3,4')); // Array ( [2] => 40 [3] => 40 [4] => 40 )

// get heights
//print_r($spreadsheet->getRows()->getHeight()); // Array ( [2] => Array ( [height] => 84 ) [6] => Array ( [height] => 81 ) )
//print_r($spreadsheet->getRows()->getHeight('6')); // Array ( [6] => Array ( [height] => 81 ) )
//print_r($spreadsheet->getRows()->getHeight('2,6')); // Array ( [2] => 40 [6] => 208 )

// set heights
//$spreadsheet->getRows()->setHeight('3', 30);
//print_r($spreadsheet->getRows()->getHeight('3')); // Array ( [0] => Array ( [height] => 30 ) )
//$spreadsheet->getRows()->setHeight('0,1', 25);
//print_r($spreadsheet->getRows()->getHeight('0,1')); // Array ( [0] => Array ( [height] => 25 ) [1] => Array ( [height] => 25 ) )

// insert rows
//$spreadsheet->getRows()->insert(['A8', 'B8', 'C8']);
//$spreadsheet->getRows()->insert([[1,2,3,4,5,6]], 0, false);
//$spreadsheet->getRows()->insert([['A8', 'B8', 'C8'], ['A9', 'B9', 'C9']], 7, true);

// move rows
//$spreadsheet->getRows()->move(0, 1);
//$spreadsheet->getRows()->move(1, 0);

// delete rows
//$spreadsheet->getRows()->delete(0);
//$spreadsheet->getRows()->delete(1, 2);

// insert columns
//$spreadsheet->getColumns()->insert(0, true, [['title' => 'A', 'type' => 'text']]);
//$spreadsheet->getColumns()->insert(2, true, [['title' => 'Test', 'type' => 'text']], [['C1'],['C2'],['C3']]);

// move columns
//$spreadsheet->getColumns()->move(0, 1);
//$spreadsheet->getColumns()->move(1, 0);

// delete columns
//$spreadsheet->getColumns()->delete(0);
//$spreadsheet->getColumns()->delete(1, 2);

// types
//$spreadsheet->getColumns()->setType('1', ['type' => 'checkbox']);
//$spreadsheet->getColumns()->getType();
//$spreadsheet->getColumns()->getType('1');
//$spreadsheet->getColumns()->getType('1,2');

// headers
//$spreadsheet->getHeaders(); // Array ( [0] => A [1] => B [2] => C [3] => D [4] => E [5] => F [6] => G [7] => H )
//$spreadsheet->getHeaders('1'); // Array ( [1] => B )
//$spreadsheet->getHeaders('0,1'); // Array ( [0] => A [1] => B )
//$spreadsheet->setHeader(0, 'New title');

// footers
//$spreadsheet->setFooters([['1', '2'], [3, 4]]);
//$spreadsheet->getFooters(); // Array ( [0] => Array ( [0] => 1 [1] => 2 ) [1] => Array ( [0] => 3 [1] => 4 ) )
//$spreadsheet->resetFooters();

// comments
//$spreadsheet->getCells()->setComments(['A1' => 'comments']));
//$spreadsheet->getCells()->getComments('A1'); // Array ( [A1] => comments )
//$spreadsheet->getCells()->resetComments();

// meta
//$spreadsheet->getCells()->setMeta(['B2' => ['meta' => 'value']]);
//$spreadsheet->getCells()->getMeta(); //Array ( [B2] => Array ( [meta] => value ) )
//$spreadsheet->getCells()->resetMeta();

// get values
//$spreadsheet->getCells()->getValues('A1');
//$spreadsheet->getCells()->getValues('A1:C4');
//$spreadsheet->getCells()->getValues('A1:C4');
