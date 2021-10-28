<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function vehicle_ck($params){
        $sql = "SELECT m_barcode FROM member_info WHERE email=?";
        $query = $this->db->query($sql, [$params->email]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }        
    }

    public function update_barcode($params)
    {
        $sql = "UPDATE member_info SET m_barcode=? WHERE email=?";
        $this->db->query($sql, [
            $params->barcode,
            $params->email
        ]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}