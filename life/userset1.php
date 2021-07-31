<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

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
}

//修改密碼; 
$oldpassword = $_REQUEST ["oldpassword"]; 
$newpassword = $_REQUEST ["newpassword"]; 

//選擇要更改資欄位的名字
//mysqli_select_db ( $con ,"passwd"); 
$dbpassword = null; 
$dbpassword = $row ["password"]; 
if ($oldpassword != $dbpassword) 
{ 
    print("密碼錯誤"); 
}
//如果上述使用者名稱密碼判定正確，則update進資料庫中
$sql_query = " UPDATE member_info SET passwd = '$newpassword' WHERE email = $email " ; 
//mysqli_close ( $con ); 
$db_link->close();
print("密碼修改成功");
?> 
