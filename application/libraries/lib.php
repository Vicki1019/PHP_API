<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib
{
    function validate($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}