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
    public function group($params)
    {
        $sql = "INSERT INTO group_code(group_no, group_cn)
                VALUES (?, ?)";
        $this->db->query($sql, [
            $params->group_no,
            $params->name,
        ]);

        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}