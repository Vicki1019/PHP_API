<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

//修改密碼
if (isset($_POST["oldpwd"]) && $_POST["newpwd"] && isset($_POST['email']))
{

    if(empty($_POST["oldpwd"]) || empty($_POST["newpwd"]))
    {
        print("old password or new password can not be empty");
    }else{
        $email = $_POST['email'];
        $oldpwd = $_POST["oldpwd"];
        $newpwd = $_POST["newpwd"];
        $result = $dbHelper->updatePassword($email, $oldpwd, $newpwd);
        if ($result == 1) {
            print("success");
        } else if ($result == "old password failed") {
                print("old password failed");
        } else {
                print("update failed");
        }
    }
    
    // $email = "SELECT 'email' FROM member_info";
    // $dbpw = "SELECT 'passwd' FROM member_info";
    // $oldpw = $_POST['oldpwd'];
    // $newpw = $_POST['newpwd'];
    // if ($oldpw != $dbpw) 
    // { 
    //     print("密碼錯誤"); 
    // }
    // else
    // {
    //     $sql = "UPDATE 'member_info' SET 'passwd' = '$newpw' ";
    //     mysqli_query($db_link,$sql_query);
    //     if (mysqli_affected_rows($link)>0) 
    //     {
    //         echo "資料已更新";
    //     }
    //     elseif(mysqli_affected_rows($link)==0) 
    //     {
    //         echo "無資料更新";
    //     }
    //     else 
    //     {
    //         echo "{$sql} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
    //     }
    // }
}
?>
