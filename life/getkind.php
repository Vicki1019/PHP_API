<?php
require_once 'DBHelper.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

$result = $dbHelper->getkind();
$typelist = array();
$i=0;
while($row = $result->fetch_assoc()){
    $typelist[$i]=$row['type_cn'];
    $i++;
}

echo json_encode($typelist, JSON_UNESCAPED_UNICODE);
?>