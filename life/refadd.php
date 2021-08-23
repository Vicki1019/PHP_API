<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if (isset($_POST['email']) && isset($_POST['amount']) && isset($_POST['unit']) && isset($_POST['locate_no']) && isset($_POST['exp_date']))
{
     $email = validate($_POST['email']);
     $amount = validate($_POST['amount']);
     $unit = validate($_POST['unit_no']);
     $locat = validate($_POST['locate_no']);
     $expdate = validate($_POST['exp_date']);
     if(!empty($emil) && !empty($amount) && !empty($unit) && !empty($locate) && !empty($expdate))
     {
          $emailCheck = $dbHelper->emailCheck($email);
          if($emailCheck != true)
          {
            print("failure");
          }
          else
          {

          }
     }
}
?> 