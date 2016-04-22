<?php
require(__DIR__ . '/vendor/autoload.php');

$tablename = 'c2_coupon_test';
$username = 'root';
$password = 'root';
$database = 'test';
$host = 'localhost';
$excelDir = $argv[1];
$filenames = scandir($excelDir);
$lastFile = $excelDir . $tablename . '.csv';
foreach ($filenames as $filename) {
  if (pathinfo($filename, PATHINFO_EXTENSION) === 'xlsx') {
    $filename = $excelDir . $filename;
    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
    $objPHPExcel = $objReader->load($filename);
    $objPHPExcel->getActiveSheet()->removeRow(1, 1);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')
      ->setDelimiter(',')
      ->setEnclosure('"')
      ->setLineEnding("\r\n")
      ->setSheetIndex(0);
    $newFilename = str_replace('.xlsx', '.csv', $filename);
    $objWriter->save($newFilename);
    rename($newFilename, $lastFile);
    $cmd = 'mysqlimport --local --user=' . $username . ' --password=' . $password .
      ' --fields-terminated-by="," --fields-enclosed-by="\"" --lines-terminated-by="\r\n" ' .
      $database . ' "' . $lastFile . '"';
    echo exec($cmd), "\n";
  }
}
unlink($lastFile);
echo "成功导入\n";

$coupons = [
  'Batman', 'Golden Reel', 'SCEC', 'THOM', 'Fun Zone', 'Pearl Dragon',
  'Bi Ying', 'Herbal Treasures', 'Matinee', 'Mian', 'Shanghai Magic',
  'Spice Road', 'Trattoria IL Mulino', 'Macau Gourmet Walk'
];

$connection = mysql_connect($host, $username, $password);
mysql_query("set names 'utf8'");
if (!$connection) {
    die("could not connect to the database.\n" . mysql_error());
}
$selectedDb = mysql_select_db($database);
if (!$selectedDb) {
    die("could not to the database\n" . mysql_error());
}
$query = "select staff_name, left(redeem_time, 10), count(*) from $tablename group by staff_name, left(redeem_time, 10)";//构建查询语句
$result = mysql_query($query);
if (!$result) {
    die("could not to the database\n" . mysql_error());
}
$data = [];
while ($row = mysql_fetch_row($result)) {
    // if (in_array($row[0], $coupons)) {
      $data[$row[0]][$row[1]] = $row[2];
    // }
}

$resultFile = $excelDir . 'result.xlsx';
$startDate = new DateTime('2016-04-01');
$objPHPExcel = new PHPExcel();
$index = 1;
foreach ($data as $couponName => $items) {
  $pIndex = 1;
  $pCoordinate = setColumnIndex($index) . $pIndex;
  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($pCoordinate, $couponName);
  if (!empty($items)) {
    foreach ($items as $date => $value) {
      $currentDate = new DateTime($date);
      $pIndex = ((int) $currentDate->diff($startDate)->format('%a')) + 2;
      $pCoordinate = setColumnIndex($index) . $pIndex;
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue($pCoordinate, $value);
    }
  }
  $index++;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save($resultFile);

/**
 * set column index for excel
 * @param $index,int
 */
function setColumnIndex($index)
{
    if ($index < 26) {
        $columnIndex = chr(65 + $index);
    } elseif ($index < 702) {
        $columnIndex = chr(64 + ($index / 26)) . chr(65 + $index % 26);
    } else {
        $columnIndex = chr(64 + (($index - 26) / 676))
        . chr(65 + ((($index - 26) % 676) / 26))
        . chr(65 + $index % 26);
    }
    return $columnIndex;
}
///var/lib/mysql/test/
// LOAD DATA INFILE '/home/user/Desktop/coupon/Campaign#2-正式-优惠券使用记录导出_0417-20160418083906.csv' INTO TABLE test.c2_coupon_test;
// mysqlimport --fields-optionally-enclosed-by=""" --fields-terminated-by=, --lines-terminated-by="\r\n" --user=root --password test /home/user/Desktop/coupon/Campaign#2-正式-优惠券使用记录导出_0417-20160418083906.csv
//
// mysqlimport -uroot -proot -hlocalhost -P3306 --fields-optionally-enclosed-by=" --fields-terminated-by=,  test c2_coupon_test.csv
//
// mysqlimport --local --user=root --password=root --delete --fields-terminated-by="," --fields-enclosed-by="\"" --lines-terminated-by="\n" test "/home/user/Desktop/coupon/c2_coupon_test.csv"
//
// load data infile '/home/user/Desktop/coupon/c2_coupon_test.csv'
// into table c2_coupon_test
// fields terminated by ','  optionally enclosed by '"' escaped by '"'
// lines terminated by '\n';
