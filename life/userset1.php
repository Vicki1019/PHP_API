<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

//修改暱稱
$newName = $_POST['member_nickname'];
//if (isset($_POST["action"]) && $_POST["action"] == 'update') 
//{
    
    $sql = "UPDATE 'member_info' SET 'member_nickname' = '$newName' ";
    //mysqli_query($db_link,$sql_query);
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
//}


//修改密碼 
/*if (isset($_POST["passwd"]) && $_POST["passwd"] == 'update') 
{
    $email = "SELECT 'email' FROM member_info";
    $dbpw = "SELECT 'passwd' FROM member_info";
    $oldpw = $_POST['passwd'];
    $newpw = $_POST['passwd'];
    if ($oldpw != $dbpw) 
    { 
        print("密碼錯誤"); 
    }
    else
    {
        $sql = "UPDATE 'member_info' SET 'passwd' = '$newpw' ";
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
    }
    //$db_link->close();
}*/
?> 
