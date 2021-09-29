<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Shopping_model');
	}
}