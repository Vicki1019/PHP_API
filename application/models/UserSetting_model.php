<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserSetting_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 確認使用者
     *
     * @var string $sql 查詢使用者資料
     *
     * @param string $email 信箱
     *
     * @return object
     */
    public function userCheck($email){
        $sql = "SELECT member_nickname, email FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        return $query->result_array();
    }

    /**
     * 更新使用者暱稱
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->nickname 新的暱稱
     *
     * @var string $sql 更新使用者暱稱
     *
     * @return bool
     */
    public function updateUserName($params)
    {
        // 先查找使用者的新暱稱是否與原先相同
        $sql = "SELECT member_nickname as oldNickname FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $params->email);
        $row = $query->row_array();

        //相同則直接回傳成功
        $newNickname = $params->nickname;
        if($newNickname == $row['oldNickname'])
        {
            return true;
        } else {
            $sql = "UPDATE member_info SET member_nickname=? WHERE email=?";
            $query = $this->db->query($sql, [
                $newNickname,
                $params->email
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 更新使用者密碼
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->oldpwd 舊密碼
     * @param string $params->newpwd 新密碼
     *
     * @var string $sql 更新使用者密碼
     *
     * @return bool|string
     */
    public function updatePassword($params)
    {
        // 先查找使用者的新密碼是否與原先相同
        $sql = "SELECT passwd FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $params->email);
        $row = $query->row_array();

        // 若不同則回傳舊密碼錯誤
        if ($params->oldpwd != $row['passwd'])
        {
            return "old password failed";
        } else {
            $sql = "UPDATE member_info SET passwd=? WHERE email=?";
            $query = $this->db->query($sql, [
                $params->newpwd,
                $params->email
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return "password update failed";
            }
        }
    }
}