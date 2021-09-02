<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refrigerator extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Refrigerator_model');
	}

    public function getUnit()
    {
        $email = $this->input->post('email');
        $params = (object)[
            'email' => $email
        ];
        $unitlist['unit'] = $this->Refrigerator_model->getunit($params);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($unitlist, JSON_UNESCAPED_UNICODE));
    }

    public function getKind()
    {
        $email = $this->input->post('email');
        $params = (object)[
            'email' => $email
        ];
        $kindlist['kind'] = $this->Refrigerator_model->getkind($params);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($kindlist, JSON_UNESCAPED_UNICODE));
    }

    public function getlocate()
    {
        $locatelist['locate'] = $this->Refrigerator_model->getlocate();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($locatelist, JSON_UNESCAPED_UNICODE));
    }
}