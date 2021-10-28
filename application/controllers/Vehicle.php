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

    public function vehicle_ck(){
        $params = (object)[
            'email' => $this->input->post('email')
        ];
        $result = $this->Vehicle_model->vehicle_ck($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
                $vehicleck['vehicle'][] = [
                     'response' => 'success',
                     'barcode' => $v['m_barcode'],
                 ];
             }
             $this->output->set_content_type('application/json');
             $this->output->set_output(json_encode($vehicleck
             , JSON_UNESCAPED_UNICODE));
        }
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