<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shopping_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
}