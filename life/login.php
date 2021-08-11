<?php
require_once 'DBHelper.php';
require_once 'validate.php';

/** @var \DBHelper $dbHelper 存取與資料庫相關功能的物件 */
$dbHelper = new DBHelper();

if(isset($_POST['email']) && isset($_POST['passwd'])){

    $email = validate($_POST['email']);
    $passwd = validate($_POST['passwd']);
    $user['userinfo'] = array();
    //$sql = "SELECT * FROM member_info WHERE email='$email' AND passwd='$passwd'";

    $result = $dbHelper->login($email, $passwd);
    if($result == false){
        array_push($user['userinfo'],array('response'=>'failure'));
        print json_encode($user, JSON_UNESCAPED_UNICODE);
    }else{
        while($row = $result->fetch_array()){
            array_push($user['userinfo'],array('response'=>'success', 'member_nickname'=>$row['member_nickname'], 'email'=>$row['email'], 'passwd'=>$row['passwd']));
        }
        print json_encode($user, JSON_UNESCAPED_UNICODE);
    }

    // if($result->num_rows > 0){
    //     echo "success";
    // }else{
    //     echo "failure";
    // }
}
?>