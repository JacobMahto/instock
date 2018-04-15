<?php
//include the file that loads the PhpSpreadsheet classes
require_once 'spreadsheet/vendor/autoload.php';
include '../dbms/functions.php';

$spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load('instock.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$resultList = getForExcel();
$countRow = 3;
while ($a = mysqli_fetch_assoc($resultList)) {
    $a['date_in'] = correctDate($a['date_in']);
    $a['date_fi'] = correctDate($a['date_fi']);
    $worksheet->fromArray($a, null, "B" . $countRow);
    $worksheet->getCell('A' . $countRow)->setValue($countRow - 2);
    $countRow++;
    // $worksheet->getCell('A1')->setValue('John');
    // $worksheet->getCell('A2')->setValue('Smith');
}


$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');

$writer->save('dataExport.xls');

header( "refresh:0.02; url=dataExport.xls" );
echo "<html><script type='text/javascript'>window.close();</script></html>";
