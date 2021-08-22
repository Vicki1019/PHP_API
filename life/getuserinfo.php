<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_POST['emaildata'])){
    $email = validate($_POST['emaildata']);

    $result = $dbHelper->usercheck($email);
        $user['username'] = array();
        while($row = $result->fetch_array()){
            array_push($user['username'],array('member_nickname'=>$row['member_nickname']));
        }
        echo json_encode($user, JSON_UNESCAPED_UNICODE);
}
?>