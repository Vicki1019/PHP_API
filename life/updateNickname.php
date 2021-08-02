<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

//修改暱稱
if (isset($_POST['email']) && isset($_POST['nickname']))
{
     if(empty($_POST['nickname']))
     {
          print("nickname can not be empty");
     } else {
          $newName = $_POST['nickname'];
          $email = $_POST['email'];
          $result = $dbHelper->updateUserName($email, $newName);
          if ($result == 1) {
                    print("success");
          } else {
               print("update failed");
          }
     }
}
?> 
