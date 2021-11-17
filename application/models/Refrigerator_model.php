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
     * 取得群組名稱
     *
     * @param object $params
     * @param string $params->group_no 信箱
     *
     * @var string $sql 取得群組編號
     *
     * @return bool|string
     */
    public function get_group_name($locate_code)
    {
        $sql = "SELECT group_cn FROM group_code WHERE group_no=?";
        $query = $this->db->query($sql, $locate_code);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得使用者locate
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得使用者locate
     *
     * @return bool|string
     */
    public function get_member_locate($email)
    {
        $sql = "SELECT locate_code FROM member_info WHERE email=?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得使用者目前locate
     *
     * @param object $params
     * @param string $params->email 信箱
     *
     * @var string $sql 取得使用者目前locate
     *
     * @return bool|string
     */
    public function get_ref_locate($email)
    {
        $sql = "SELECT locate_code FROM member_info WHERE email=?";
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
     * @var string $sql 查詢資料表中 kind_cn欄位的資料
     *
     * @return object
     */
    public function getkind($params)
    {
        $sql = "SELECT kind_cn FROM food_kind_code 
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
     * @var string $sql 查詢資料表中 kind_no欄位的資料
     *
     * @return object
     */
    public function getkindno($kind)
    {
        $sql = "SELECT kind_no FROM food_kind_code WHERE kind_cn=?";
        $query = $this->db->query($sql,$kind);
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
     * @var string $sql 食物狀態確認
     *
     * @return object
     */
    public function foodstate($expdate,$alert_date)
    {
        if(strtotime($alert_date) == strtotime(date("Y/m/d")) || strtotime($expdate) == strtotime(date("Y/m/d"))){
            return "-1"; //即將過期
        }else if(strtotime($expdate)<strtotime(date("Y/m/d"))){
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
     * @param string $params->kind 分類
     * @param string $params->locate 存取位置
     *
     * @var string $sql 新增冰箱清單
     *
     * @return bool|string
     */
    public function refadd($params)
    {
        $sql = "INSERT INTO refre_list (member_no, group_no, food_name, quantity, unit_no, exp_date, alert_date, kind_no, locate_no, ck_date, exp_state, photo) VALUE (?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, [
            $params->memberno,
            $params->groupno,
            $params->foodname,
            $params->quantity,
            $params->unitno,
            $params->expdate,
            $params->alertdate,
            $params->kindno,
            $params->locateno,
            $params->ckdate,
            $params->expstate,
            $params->photo
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
        $sql = "SELECT refre_list_no, member_nickname, food_name, quantity, unit_code.unit_cn, exp_date, kind_cn, locate_code.locate_cn, exp_state, photo, group_cn
                FROM refre_list
                LEFT JOIN member_info ON refre_list.member_no = member_info.member_no
                LEFT JOIN group_code ON refre_list.group_no = group_code.group_no AND refre_list.member_no = group_code.member_no
                LEFT JOIN unit_code ON refre_list.unit_no = unit_code.unit_no
                LEFT JOIN food_kind_code ON refre_list.kind_no = food_kind_code.kind_no
                LEFT JOIN locate_code ON refre_list.locate_no = locate_code.locate_no
                WHERE is_delete=0 AND refre_list.group_no = (SELECT locate_code FROM member_info WHERE member_info.member_no=?)";
        $query = $this->db->query($sql, [
            $params->memberno
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 更新冰箱清單  item
     *
     * @param object $params
     *
     * @var string $sql 更新冰箱清單  item
     *
     * @return bool
     */
    public function update_ref_item($params)
    {
        $sql = "UPDATE refre_list
                SET food_name = ?, quantity = ?, unit_no = ?, exp_date = ?, alert_date = ?, kind_no = ?, locate_no = ?, ck_date = ?, exp_state = ?
                WHERE member_no = ? AND group_no = ? AND refre_list_no = ?";
        $this->db->query($sql, [
            $params->foodname,
            $params->quantity,
            $params->unitno,
            $params->expdate,
            $params->alertdate,
            $params->kindno,
            $params->locateno,
            $params->ckdate,
            $params->expstate,
            $params->memberno,
            $params->groupno,
            $params->itemID,
        ]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除冰箱清單 item
     *
     * @param object $params
     *
     * @var string $sql 刪除冰箱清單 item
     *
     * @return bool
     */
    public function delete_ref_item($params)
    {
        //0是未刪除 1是已刪除
        $sql = "UPDATE refre_list SET is_delete=1 WHERE refre_list_no = ? AND group_no = ? AND member_no = ?";
        /*$sql="DELETE FROM refre_list
              WHERE refre_list_no = ? AND group_no = ? AND member_no = ?";*/
        $this->db->query($sql, [
            $params->itemID,
            $params->groupno,
            $params->memberno,
        ]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取得欲刪除冰箱清單
     *
     * @param object $params
     *
     * @var string $sql 取得欲刪除冰箱清單
     *
     * @return mixed
     */
    public function get_delete_ref($params)
    {
        $sql = "SELECT member_nickname, food_name, line_token
                FROM refre_list
                LEFT JOIN member_info ON refre_list.member_no = member_info.member_no
                WHERE is_delete=1 AND refre_list_no=?";
        $query = $this->db->query($sql, [
            $params->refre_list_no
        ]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * 取得所有冰箱locate
     *
     * @param string $group_no 群組邀請碼
     *
     * @var string $sql 取得所有冰箱locate
     *
     * @return mixed
     */
    public function get_all_locate($group_no)
    {
        $sql = "SELECT group_no, group_cn FROM group_code WHERE group_no = ?";
        $query = $this->db->query($sql, $group_no);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    

    /**
     * 更新使用者locate  item
     *
     * @param object $params
     *
     * @var string $sql 更新使用者locate  item
     *
     * @return bool
     */
    public function change_ref_locate($params){
        $sql = "UPDATE member_info SET locate_code=? WHERE member_no=?";
        $this->db->query($sql, [
            $params->groupno,
            $params->memberno
        ]);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 檢查是否已在該locate
     *
     * @param object $params
     * @param string $params->memberno 使用者編號
     * @param string $params->locate_code 使用者所選之冰箱
     *
     * @var string $sql 檢查是否已在該locate
     *
     * @return bool|string
     */
    public function locate_code_ck($params)
    {
        $sql = "SELECT member_no, locate_code FROM member_info WHERE member_no=? AND locate_code=? ";
        $query = $this->db->query($sql, [
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
     * 更新食品新鮮狀態(即將過期)
     *
     * @param object $params
     *
     * @var string $sql 更新食品新鮮狀態(即將過期)
     *
     * @return bool
     */
    public function update_food_state_will($params){
        $sql = "UPDATE refre_list SET exp_state='-1' WHERE exp_date=? OR exp_date=?";
        $query = $this->db->query($sql, [
            $params->exp_date,
            $params->alert_date,
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新食品新鮮狀態(已過期)
     *
     * @param object $params
     *
     * @var string $sql 更新食品新鮮狀態(已過期)
     *
     * @return bool
     */
    public function update_food_state_gone($today){
        $sql = "UPDATE refre_list SET exp_state='1' WHERE exp_date<?";
        $query = $this->db->query($sql, $today);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 食品過期提醒日期
     *
     * @param object $params
     *
     * @var string $sql 食品過期提醒日期
     *
     * @return bool
     */
    public function food_state_notify(){
        $sql = "SELECT refre_list.member_no, member_nickname, food_name, quantity, unit_code.unit_cn, exp_date, alert_date, exp_state,member_info.line_token
                FROM refre_list
                LEFT JOIN member_info ON refre_list.member_no = member_info.member_no
                LEFT JOIN unit_code ON refre_list.unit_no = unit_code.unit_no
                WHERE alert_date=NOW() AND line_token!='NULL'"; 
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
