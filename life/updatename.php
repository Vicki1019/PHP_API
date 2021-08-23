<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_POST["newName"]) && isset($_POST["email"])){
    $newName = validate($_POST['newName']);
    $email = validate($_POST['email']);

    $result = $dbHelper->updatename($newName, $email);
    if($result != 0){
        print "success";
    }else{
        print "failure";
    }
}
?>