<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_POST["email"]) && isset($_POST["passwd"]) && isset($_POST["newpasswd"])){
    $email = validate($_POST['email']);
    $passwd = validate($_POST['passwd']);
    $newpasswd = validate($_POST['newpasswd']);

    $result = $dbHelper->updatepass($email, $passwd, $newpasswd);
    if($result != 0){
        print "success";
    }else{
        print "failure";
    }
}
?>