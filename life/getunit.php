<?php
require_once 'DBHelper.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

$result = $dbHelper->getunit();
$unitlist = array();
$i=0;
while($row = $result->fetch_assoc()){
    $unitlist[$i]=$row['unit_cn'];
    $i++;
}
echo json_encode($unitlist, JSON_UNESCAPED_UNICODE);
?>