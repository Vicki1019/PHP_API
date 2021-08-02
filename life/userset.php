<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

//get使用者名字
//$email = "SELECT 'email' FROM member_info";
//$sql_n = "SELECT 'member_nickname' FROM member_info WHERE email='$email'";

//get使用者舊密碼
//$sql_pw = "SELECT 'passpw' FROM member_info WHERE email='$email'";
if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $result = $dbHelper->getEmail($_POST['email']);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
?>