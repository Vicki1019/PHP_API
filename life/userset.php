<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

//get使用者名字
//$con = mysqli_connect ( "localhost", "root", "1qaz2wsX" ); 
$sql = "SELECT 'member_nickname' FROM member_info WHERE email='$email'";
//$result = mysqli_query($con, $sql);
mysqli_query($this->connect, $sql);
$result = $this->connect->affected_rows;
if($result != 1)
{
     return false;
}
else
{
      return $result;
}


//修改使用者名字
//if (isset($_POST["action"]) && $_POST["action"] == 'update') {

     $newName = $_POST['member_nickname'];
     
     $sql = "UPDATE 'member_info' SET 'member_nickname' = '$newName' WHERE email ='$email'";
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
//}
?>