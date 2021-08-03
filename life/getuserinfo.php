<?php
session_start();
require_once 'DBHelper.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_SESSION['email'])){
    $result = $dbHelper->getuserinfo();
    print $result;
}
?>