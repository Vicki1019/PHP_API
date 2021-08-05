<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_POST['email']) && isset($_POST['passwd'])){

    $email = validate($_POST['email']);
    $passwd = validate($_POST['passwd']);

    //$sql = "SELECT * FROM member_info WHERE email='$email' AND passwd='$passwd'";

    $result = $dbHelper->login($email, $passwd);
    if ($result == 1) {
        $_SESSION['email'] = $email;
        print("success");
    } else {
        print("failure");
    }

    // if($result->num_rows > 0){
    //     echo "success";
    // }else{
    //     echo "failure";
    // }
}
?>