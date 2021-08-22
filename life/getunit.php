<?php
require_once 'DBHelper.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

$result = $dbHelper->getunit();
$unitlist['unit'] = array();
while($row = $result->fetch_array()){
    array_push($unitlist['unit'],array('unit_cn'=>$row['unit_cn']));
}

echo json_encode($unitlist, JSON_UNESCAPED_UNICODE);
?>