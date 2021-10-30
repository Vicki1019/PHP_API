<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 登入系統
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->passwd 密碼
     *
     * @var string $sql 查找帳號
     *
     * @return mixed
     */
    public function login($params)
    {
        $sql = "SELECT member_nickname, email, passwd FROM member_info WHERE email=? AND passwd=?";
        $query = $this->db->query($sql, [
            $params->email,
            $params->passwd
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 產生群組亂碼
     *
     * @param string $length 長度
     *
     * @var string $str 亂碼字典
     *
     * @return string $random_str
     */
    public function randomStr($length=5)
    {
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $random_str = substr(str_shuffle($str), 0, $length);
        return $random_str;
    }

    /**
     * 檢查群組亂碼是否重複
     *
     * @param string $group_no 群組亂碼
     *
     * @var string $sql 查詢亂碼
     * @var mysqli_result|bool $result 查詢結果
     *
     * @return bool
     */
    public function randomStrCheck($group_no)
    {
        $sql =  "SELECT 'group_no' FROM member_info WHERE group_no=?";
        $this->db->query($sql, $group_no);

        if($this->db->affected_rows() > 0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 信箱驗證是否重複
     *
     * @param string $email 信箱
     *
     * @var string $sql 查找帳號
     *
     * @return bool
     */
    public function emailCheck($email)
    {
        $sql = "SELECT 'email' FROM member_info WHERE email=?";
        $this->db->query($sql, $email);

        if ($this->db->affected_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 註冊帳號
     *
     * @param object $params
     * @param string $params->group_no 群組編號
     * @param string $params->name 暱稱
     * @param string $params->email 信箱
     * @param string $params->passwd 密碼
     *
     * @var string $sql 新增使用者到資料表中
     *
     * @return mixed
     */
    public function register($params)
    {
        $sql = "INSERT INTO member_info (group_no, member_nickname, email, passwd)
                VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [
            $params->groupno,
            $params->name,
            $params->email,
            $params->passwd
        ]);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
            // return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    public function idGetEmail($id)
    {
        $sql = "SELECT email, member_nickname FROM member_info WHERE member_no=?";
        $query = $this->db->query($sql, $id);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getUserData($email)
    {
        $sql = "SELECT member_no, group_no, email, member_nickname FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}