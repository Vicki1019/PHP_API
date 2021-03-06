<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 記錄群組
     *
     * @param string $group_no 群組碼
     * @param string $name 名稱
     *
     * @var string $sql 新增群組
     *
     * @return mixed
     */
    public function group($insertResult,$group_no,$name)
    {
        $sql = "INSERT INTO group_code(member_no, group_no, group_cn)
                VALUES (?, ?, ?)";
        $this->db->query($sql,[$insertResult, $group_no, $name]);

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    /**
     * 取得使用者編號
     *
     * @param string $email 使用者信箱
     *
     * @var string $sql 取得使用者編號
     *
     * @return mixed
     */
    public function get_memberno($email)
    {
        $sql = "SELECT member_no FROM member_info WHERE email = ?";
        $query = $this->db->query($sql, $email);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 取得群組代碼(邀請碼)
     *
     * @param string $email 使用者信箱
     * @param string $name 名稱
     *
     * @var string $sql 取得群組代碼(邀請碼)
     *
     * @return mixed
     */
    public function get_group($name)
    {
        $sql = "SELECT group_no FROM group_code WHERE member_no = ?";
        $query = $this->db->query($sql, $name);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得所有群組與群組人數
     *
     * @param string $group_no 群組邀請碼
     *
     * @var string $sql 取得所有群組與群組人數
     *
     * @return mixed
     */
    public function get_total_group_member($group_no)
    {
        $sql = "SELECT group_no, group_cn, COUNT(member_no) as total_member FROM group_code WHERE group_no = ?";
        $query = $this->db->query($sql, $group_no);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_group_member($invite_code)
    {
        $sql = "SELECT group_cn, member_info.member_nickname, member_info.email, profile_picture 
                FROM group_code
                LEFT JOIN member_info ON member_info.member_no = group_code.member_no
                WHERE group_code.group_no = ?";
        $query = $this->db->query($sql, $invite_code);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 檢查是否為預設群組
     *
     * @param string $group_no 群組編號
     *
     * @return mixed
     */
    public function check_default_group($group_no)
    {
        $sql = "SELECT member_no FROM member_info WHERE group_no = ?";
        $query = $this->db->query($sql, $group_no);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    
    public function check_group($invite_code)
    {
        $sql = "SELECT group_cn FROM group_code WHERE group_code.group_no = ?";
        $query = $this->db->query($sql, $invite_code);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 檢查是否已加入該群組
     *
     * @param string $invite_code 群組編號
     * @param string $member_no 使用者編號
     *
     * @return mixed
     */
    public function check_join_group($params)
    {
        $sql = "SELECT group_cn FROM group_code WHERE group_code.group_no=? AND member_no=?";
        $query = $this->db->query($sql, [
            $params->invite_code,
            $params->member_no,
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /** 
     * 用邀請碼加入群組
     *
     * @param string $member_no 使用者編號
     * @param string $invite_code 群組編號
     * @param string $group_cn 群組名稱
     *
     * @return bool
     */
    public function join_group($params)
    {
        $sql = "INSERT INTO group_code (member_no, group_no, group_cn)
                VALUES (?, ?, ?)";
        $query = $this->db->query($sql, [
            $params->member_no,
            $params->invite_code,
            $params->group_cn,
        ]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_group_name($invite_code){
        $sql = "SELECT group_cn FROM group_code WHERE group_no=?";
        $query = $this->db->query($sql, $invite_code);
        return $query->row_array();
    }

    /**
     * 刪除群組
     *
     * @param string $group_no 群組編號
     * @param string $member_no 使用者編號
     *
     * @return bool
     */
    public function delete_group($group_no)
    {
        $sql = "DELETE FROM group_code WHERE group_no = ?";
        $query = $this->db->query($sql, $group_no);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 檢查是否為預設群組創建者
     *
     * @param string $member_no 使用者編號
     * @param string $group_no 群組編號
     *
     * @return bool
     */
    public function check_default_member($params)
    {
        $sql = "SELECT member_no FROM member_info WHERE group_no = ? AND member_no=?";
        $query = $this->db->query($sql, [
            $params->group_no,
            $params->member_no,
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除群組成員
     *
     * @param string $group_no 群組編號
     * @param string $member_no 使用者編號
     *
     * @return bool
     */
    public function delete_group_member($params)
    {
        $sql = "DELETE FROM group_code WHERE group_no = ? AND member_no=?";
        $query = $this->db->query($sql, [
            $params->group_no,
            $params->member_no,
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}