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
        $unitlist['unit'] = $this->Refrigerator_model->getunit();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($unitlist, JSON_UNESCAPED_UNICODE));
    }

    public function getKind()
    {
        $kindlist['kind'] = $this->Refrigerator_model->getkind();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($kindlist, JSON_UNESCAPED_UNICODE));
    }
}