<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refrigerator_model extends CI_Model
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
            return $query->row_array();;
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
     * 取得單位資料
     *
     * @var string $sql 查詢資料表中 unit_cn欄位的資料
     *
     * @return object
     */
    public function getunit($params)
    {
        $sql = "SELECT unit_cn FROM unit_code 
        WHERE unit_code.member_no = (SELECT member_info.member_no FROM member_info  WHERE email=?) 
        OR unit_code.member_no = '0'";
        $query = $this->db->query($sql, [
            $params->email
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得單位編號
     *
     * @var string $sql 查詢資料表中 unit_no欄位的資料
     *
     * @return object
     */
    public function getunitno($unit)
    {
        $sql = "SELECT unit_no FROM unit_code WHERE unit_cn=?";
        $query = $this->db->query($sql,$unit);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 取得分類資料
     *
     * @var string $sql 查詢資料表中 type_cn欄位的資料
     *
     * @return object
     */
    public function getkind($params)
    {
        $sql = "SELECT type_cn FROM food_kind_code 
        WHERE food_kind_code.member_no = (SELECT member_info.member_no FROM member_info  WHERE email=?) 
        OR food_kind_code.member_no = '0'";
        $query = $this->db->query($sql, [
            $params->email
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得分類編號
     *
     * @var string $sql 查詢資料表中 type1欄位的資料
     *
     * @return object
     */
    public function gettypeno($type)
    {
        $sql = "SELECT type1 FROM food_kind_code WHERE type_cn=?";
        $query = $this->db->query($sql,$type);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 取得存放位置資料
     *
     * @var string $sql 查詢資料表中 locate_cn欄位的資料
     *
     * @return object
     */
    public function getlocate()
    {
        $sql = "SELECT locate_cn FROM locate_code";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得存放位置編號
     *
     * @var string $sql 查詢資料表中 locate_no欄位的資料
     *
     * @return object
     */
    public function getlocateno($locate)
    {
        $sql = "SELECT locate_no FROM locate_code WHERE locate_cn=?";
        $query = $this->db->query($sql,$locate);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * 食物狀態確認
     *
     * @var string $sql 檢查食品狀態
     *
     * @return object
     */
    public function foodstate($expdate,$alert_date)
    {
        if(strtotime($alert_date) == strtotime(date("Y/m/d"))){
            return "-1"; //即將過期
        }else if(strtotime($expdate)<=strtotime(date("Y/m/d H:i:s"))){
            return "1"; //已過期
        }else{
            return "0"; //未過期
        }
    }

    /**
     * 新增冰箱清單
     *
     * @param object $params
     * @param string $params->memberno 使用者編號
     * @param string $params->groupno 群組編號
     * @param string $params->foodname 食品名稱
     * @param string $params->quantity 數量
     * @param string $params->unit 單位
     * @param string $params->expdate 有效期限
     * @param string $params->type 分類
     * @param string $params->locate 存取位置
     *
     * @var string $sql 新增冰箱清單
     *
     * @return bool|string
     */
    public function refadd($params)
    {
        $sql = "INSERT INTO refre_list (member_no, group_no, food_name, quantity, unit_no, exp_date, alert_date, type1, locate_no, ck_date, exp_state) VALUE (?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, [
            $params->memberno,
            $params->groupno,
            $params->foodname,
            $params->quantity,
            $params->unitno,
            $params->expdate,
            $params->alertdate,
            $params->typeno,
            $params->locateno,
            $params->ckdate,
            $params->expstate
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取得冰箱清單
     *
     * @param object $params
     * @param string $params->member_no 使用者編號
     *
     * @var string $sql 取得冰箱清單
     *
     * @return mixed
     */
    public function getreflist($params)
    {
        $sql = "SELECT food_name, quantity, unit_code.unit_cn, exp_date, exp_state 
                FROM refre_list LEFT JOIN unit_code ON refre_list.unit_no = unit_code.unit_no 
                WHERE refre_list.member_no=?";
        $query = $this->db->query($sql, [
            $params->memberno
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
