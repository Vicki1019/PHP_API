<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if (isset($_POST["action"]) && $_POST["action"] == 'update') {

     $newName = $_POST['member_nickname'];
     
     $sql_query = "UPDATE member_info SET member_nickname = '$newName' WHERE email = $email";

     mysqli_query($db_link,$sql_query);
     $db_link->close();

     //header('Location: index.php');
}
?>