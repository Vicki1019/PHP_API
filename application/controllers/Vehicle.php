<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Vehicle_model');
	}

    public function update_barcode()
    {
        $params = (object)[
            'email' => $this->input->post('email'),
			'barcode' => $this->input->post('barcode'),
        ];
        $result = $this->Vehicle_model->update_barcode($params);
        if($result > 0){
            print "success";
        }else{
            print "failure";
        }
    }
}