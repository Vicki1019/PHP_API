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
}
