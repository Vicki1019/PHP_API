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
     * @param string $params->newname 新的暱稱
     *
     * @var string $sql 更新使用者暱稱
     *
     * @return bool
     */
    public function updatename($params)
    {
        $sql = "UPDATE member_info SET member_nickname=? WHERE email=?";
        $query = $this->db->query($sql, [
            $params->newName,
            $params->email
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

        /*// 先查找使用者的新暱稱是否與原先相同
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
        }*/
    }

    /**
     * 更新使用者密碼
     *
     * @param object $params
     * @param string $params->email 信箱
     * @param string $params->passwd 舊密碼
     * @param string $params->newpasswd 新密碼
     *
     * @var string $sql 更新使用者密碼
     *
     * @return bool|string
     */
    public function updatepass($params)
    {
        $sql = "UPDATE member_info SET passwd=? WHERE email=? AND passwd=?";
        $query = $this->db->query($sql, [
            $params->newpasswd,
            $params->email,
            $params->passwd
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

        /*// 先查找使用者的新密碼是否與原先相同
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
        }*/
    }

    /**
     * 取得使用者編號
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得使用者編號
     *
     * @return bool|string
     */
    public function getmemberno($email)
    {
        $sql = "SELECT member_no FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 取得群組編號
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得群組編號
     *
     * @return bool|string
     */
    public function getgroupno($email)
    {
        $sql = "SELECT group_no FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 檢查分類是否重複
     *
     * @param object $params
     * @param string $params->memberno 使用者編號
     * @param string $params->newkind 新分類
     *
     * @var string $sql 檢查分類是否重複
     *
     * @return bool|string
     */
    public function kindcheck($params)
    {
        $sql = "SELECT member_no, kind_cn FROM food_kind_code WHERE member_no=? AND kind_cn=? ";
        $query = $this->db->query($sql, [
            $params->memberno,
            $params->newkind
        ]);
        if ($this->db->affected_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 新增分類項目
     *
     * @param object $params
     * @param string $params->newkind 新分類
     * @param string $params->memberno 使用者編號
     * @param string $params->groupno 群組編號
     *
     * @var string $sql 新增分類項目
     *
     * @return bool|string
     */
    public function addkind($params)
    {
        $sql = "INSERT INTO food_kind_code (kind_cn, member_no, group_no) VALUE (?,?,?)";
        $query = $this->db->query($sql, [
            $params->newkind,
            $params->memberno,
            $params->groupno
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除分類項目
     *
     * @param object $params
     * @param string $params->deletekind 欲刪除分類
     *
     * @var string $sql 刪除分類項目
     *
     * @return bool|string
     */
    public function deletekind($params)
    {
        $sql = "DELETE FROM food_kind_code WHERE member_no=? AND kind_cn=?";
        $query = $this->db->query($sql, [
           $params->memberno,
           $params->deletekind
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}