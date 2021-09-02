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
    public function getunit()
    {
        $sql = 'SELECT unit_cn FROM unit_code';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * 取得分類資料
     *
     * @var string $sql 查詢資料表中 type_cn欄位的資料
     *
     * @return object
     */
    public function getkind()
    {
        $sql = 'SELECT type_cn FROM food_kind_code';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
