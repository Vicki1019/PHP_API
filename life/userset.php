<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

//get使用者名字
$sql = "SELECT 'member_nickname' FROM member_info WHERE email='$email'";


//修改使用者名字
if (isset($_POST["action"]) && $_POST["action"] == 'update') {

     $newName = $_POST['member_nickname'];
     
     $sql = "UPDATE 'member_info' SET 'member_nickname' = '$newName' ";
     mysqli_query($db_link,$sql_query);
     if (mysqli_affected_rows($link)>0) 
     {
          echo "資料已更新";
     }
     elseif(mysqli_affected_rows($link)==0) 
     {
          echo "無資料更新";
     }
     else 
     {
          echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
     }
     $db_link->close();

     //header('Location: index.php');
}
?>