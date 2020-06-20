<?php
require 'vendor/autoload.php';

use Jexcel\Jexcel;

$jexcel = new Jexcel();

// get widths
//$spreadsheet = $jexcel->getSpreadsheet('f0a9d5c1-2106-4641-86b1-71c144f61255');
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

$spreadsheet = $jexcel->getSpreadsheet('c6050da0-3917-4e42-8d1d-224c951100df');

// get widths
//$spreadsheet->getColumns()->getWidth(); // Array ( [0] => 253 [1] => 50 [2] => 50 [3] => 50 [4] => 50 [5] => 50 [6] => 205 [7] => 50 [8] => 50 [9] => 50 [10] => 50 [11] => 50 [12] => 149 [13] => 50 )
//$spreadsheet->getColumn(0)->getWidth(); // Array ( [6] => 205 )
//$spreadsheet->getColumns([0, 6, 7])->getWidth(); // Array ( [0] => 253 [6] => 205 [7] => 50 )

// set widths
//$spreadsheet->getColumn(6)->setWidth(208);
//$spreadsheet->getColumn(6)->getWidth(); // Array ( [6] => 208 )
//$spreadsheet->getColumns([2, 3, 4])->setWidth(40);
//$spreadsheet->getColumns([2, 3, 4])->getWidth(); // Array ( [2] => 40 [3] => 40 [4] => 40 )

// order by - not tested
//$spreadsheet->getColumn(3)->orderBy(Columns::ASC);
//$spreadsheet->getColumn(3)->orderBy(Columns::DESC);

// get heights
//$spreadsheet->getRows()->getHeight(); // Array ( [2] => Array ( [height] => 84 ) [6] => Array ( [height] => 81 ) )
//$spreadsheet->getRows(0)->getHeight(); // Array ( [6] => Array ( [height] => 81 ) )
//$spreadsheet->getRows([0, 1, 6])->getHeight(); // Array ( [2] => 40 [6] => 208 )

// set heights
//$spreadsheet->getRow(0)->setHeight(30);
//$spreadsheet->getRow(0)->getHeight(); // Array ( [0] => Array ( [height] => 30 ) )
//$spreadsheet->getRows([0, 1])->setHeight(25);
//$spreadsheet->getRows([0, 1])->getHeight(); // Array ( [0] => Array ( [height] => 25 ) [1] => Array ( [height] => 25 ) )

// insert rows
//$spreadsheet->getRows()->insert(['A8', 'B8', 'C8']); // insert to end
//$spreadsheet->getRow(0)->insert([[1,2,3,4,5,6]], false);
//$spreadsheet->getRow(7)->insert([['A8', 'B8', 'C8'], ['A9', 'B9', 'C9']], true);

// move rows
//$spreadsheet->getRow(0)->moveTo(1);
//$spreadsheet->getRow(1)->moveTo(0);

// delete rows
//$spreadsheet->getRow(0)->delete();
//$spreadsheet->getRows(0)->delete(2);

// insert columns
//$spreadsheet->getColumn(0)->insert(true, [['title' => 'A', 'type' => 'text']]);
//$spreadsheet->getColumn(2)->insert(true, [['title' => 'Test 2', 'type' => 'text']], [['C1'],['C2'],['C3']]);

// move columns
//$spreadsheet->getColumn(0)->moveTo(1);
//$spreadsheet->getColumn(1)->moveTo(0);

// delete columns
//$spreadsheet->getColumn(0)->delete();
//$spreadsheet->getColumn(1)->delete(2);

// properties
//$spreadsheet->getColumn(1)->setProperties(['type' => 'checkbox']);
//$spreadsheet->getColumns()->getProperties();
//$spreadsheet->getColumns([1, 2])->getProperties();

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
//$spreadsheet->getCells()->setComments(['A1' => 'comments', 'B2' => 'comments B2']);
//$spreadsheet->getCells()->getComments(); // Array ( [A1] => comments [B2] => comments B2 )
//$spreadsheet->getCell('A1')->getComments(); // Array ( [A1] => comments )
//$spreadsheet->getCell('C3')->setComment('test');
//$spreadsheet->getCell('A1:C3')->getComments(); // Array ( [A1] => comments [B2] => comments B2 [C3] => test )
//$spreadsheet->getCells()->resetComments();

// cells properties
//$spreadsheet->getCell('C3')->setProperties(['type' => 'checkbox']);
//$spreadsheet->getCell('C3')->getProperties(); // Array ( [type] => checkbox )
//$spreadsheet->getCell('C3')->resetProperties();
//$spreadsheet->getCell('C3')->getProperties(); // Array ( )

// meta
//$spreadsheet->getCell('A1')->setMeta(['name' => 'The Name']);
//$spreadsheet->getCell('A1')->getMetas(); // Array ( [A1] => Array ( [name] => The Name ) )
//$spreadsheet->getCells()->setMetas(['B2' => ['meta' => 'value'], 'D4' => ['meta' => 'value 2']]);
//$spreadsheet->getCells()->getMetas(); // Array ( [A1] => Array ( [name] => The Name ) [B2] => Array ( [meta] => value ) )
//$spreadsheet->getCells('A1,B2')->getMetas(); // Array ( [A1] => Array ( [name] => The Name ) [B2] => Array ( [meta] => value ) )
//$spreadsheet->getCells('A1:E5')->getMetas(); // Array ( [A1] => Array ( [name] => The Name ) [B2] => Array ( [meta] => value ) [D4] => Array ( [meta] => value 2 ) )
//$spreadsheet->getCells()->resetMeta();

// get values
//$spreadsheet->getCells('A1')->getValues();
//$spreadsheet->getCells('A1:C4')->getValues();
//$spreadsheet->getCells('A1,C4')->getValues();

// set values
//$spreadsheet->getCells()->setValues([
//    ['row' => 1, 'data' => ['A2', 'B2', 'C2']],
//    ['row' => 2, 'data' => ['A3', 'B3', 'C3']]
//]);

// get data
//$spreadsheet->getData();
//$spreadsheet->getColumn(2)->getData();
//$spreadsheet->getColumns([0, 1, 2])->getData();
//$spreadsheet->getRow(0)->getData();
//$spreadsheet->getRows([0, 1, 2, 3])->getData();
//$spreadsheet->getCell('A1')->getData();
//$spreadsheet->getCells(['A1', 'B2'])->getData();
//$spreadsheet->getCells('A1:B2')->getData();

// set data
//$spreadsheet->setData([
//    ['', '', ''],
//    ['A2', 'B2', 'C2'],
//    ['A3', 'B3', 'C3']
//]);

// style
//$spreadsheet->getStyle('A2'); // Array ( [A2] => color:#E11E1C )
//$spreadsheet->getStyle('A1,A2'); // Array ( [A1] => color:#E11E1C [A2] => color:#E11E1C )
//$spreadsheet->getStyle('A1:C3'); // Array ( [A1] => color:#E11E1C [A2] => color:#E11E1C [C3] => color:#E11E1C )
//$spreadsheet->setStyle(['A1' => 'background-color: #333;color:#fff;', 'A2' => 'background-color: #ccc']);
//$spreadsheet->resetStyle();

// set merge
//$spreadsheet->setMerge('A1', 2, 2);
//$spreadsheet->getMerge('A1'); // Array ( [A1] => Array ( [0] => 2 [1] => 2 ) )
//$spreadsheet->getMerge('A1:D4'); // Array ( [A1] => Array ( [0] => 2 [1] => 2 ) [B4] => Array ( [0] => 2 [1] => 2 ) )
//$spreadsheet->getMerge('A1,D4'); // Array ( [A1] => Array ( [0] => 2 [1] => 2 ) )
//$spreadsheet->removeMerge('B4');
//$spreadsheet->resetMerge();

// worksheet
//$spreadsheet->createWorksheet();
//$spreadsheet->createWorksheet([
//    'worksheetName' => 'Tab name',
//    'minDimensions' => [20, 20]
//]);
//$spreadsheet->getWorksheet(0)->rename('Tab 1');
//$spreadsheet->getWorksheet(1)->rename('Tab 2');
//$spreadsheet->getWorksheet(2)->rename('Tab 3');

//$spreadsheet->getWorksheet(2)->delete();

//$spreadsheet->getWorksheet(0)->moveTo(1);
