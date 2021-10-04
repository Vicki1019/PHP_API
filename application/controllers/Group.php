<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller
{

	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Group_model');
	}

    public function get_group_member(){
        
    }
}