<?php
require_once 'DBHelper.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

$result = $dbHelper->getkind();
$kindlist['kind'] = array();
while($row = $result->fetch_array()){
    array_push($kindlist['kind'],array('type_cn'=>$row['type_cn']));
}

print json_encode($kindlist, JSON_UNESCAPED_UNICODE);
?>