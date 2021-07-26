<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

session_start (); 
$oldpassword = $_REQUEST ["oldpassword"]; 
$newpassword = $_REQUEST ["newpassword"]; 
$con = mysqli_connect ( "localhost", "root", "1qaz2wsX" ); 

//選擇要更改資欄位的名字
mysqli_select_db ( $con ,"passwd"); 
$dbpassword = null; 
$dbpassword = $row ["password"]; 
if ($oldpassword != $dbpassword) 
{ 
    print("密碼錯誤"); 
}
//如果上述使用者名稱密碼判定正確，則update進資料庫中
$sql_query = " UPDATE member_info SET passwd = '$newpassword' WHERE email = $email " ; 
mysqli_close ( $con ); 
print("密碼修改成功");
?> 
