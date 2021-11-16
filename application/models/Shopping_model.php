<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shopping_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
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
     * 新增購物清單
     *
     * @param object $params
     * @param string $params->memberno 使用者編號
     * @param string $params->groupno 群組編號
     * @param string $params->name 食品名稱
     * @param string $params->quantity 數量
     * @param string $params->unit 單位
     * @param string $params->notifydate 推播日期
     * @param string $params->kind 分類
     * @param string $params->locate 存取位置
     *
     * @var string $sql 新增購物清單
     *
     * @return bool|string
     */
    public function shop_list_add($params)
    {
        $sql = "INSERT INTO shopping_list (member_no, group_no, hint_datetime, food_name, quantity, ck_date) VALUE (?,?,?,?,?,?)";
        $query = $this->db->query($sql, [
            $params->memberno,
            $params->groupno,
            $params->alert_date,
            $params->name,
            $params->quantity,
            $params->ckdate
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取得購物清單
     *
     * @param object $params
     * @param string $params->member_no 使用者編號
     *
     * @var string $sql 取得購物清單
     *
     * @return mixed
     */
    public function get_shopping_list($params)
    {
        $sql = "SELECT shopping_list_no, msg_receiver, food_name, quantity, check_box
                FROM shopping_list
                WHERE member_no =? AND hint_datetime =?";
        $query = $this->db->query($sql, [
            $params->memberno,
            $params->choosedate
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}