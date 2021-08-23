<?php
require_once 'DBHelper.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_POST['email'])){
    $email = $_POST['email'];
    $unitlist['unit'] = array();
    $result = $dbHelper->getunit($email);

    while($row = $result->fetch_array()){
        array_push($unitlist['unit'],array('unit_cn'=>$row['unit_cn']));
    }
    
    print json_encode($unitlist, JSON_UNESCAPED_UNICODE);
}
?>