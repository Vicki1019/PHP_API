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

    public function refadd(){
        $email = $this->input->post('email');
        $member_no = $this->Refrigerator_model->getmemberno($email);
        $group_no = $this->Refrigerator_model->getgroupno($email);
        $foodname = $this->input->post('foodname');
        $quantity = $this->input->post('quantity');
        $unit = $this->input->post('unit');
        $unitno = $this->Refrigerator_model->getunitno($unit);
        $expdate = $this->input->post('expdate');
        $type = $this->input->post('type');
        $typeno = $this->Refrigerator_model->gettypeno($type);
        $locate = $this->input->post('locate');
        $locateno = $this->Refrigerator_model->getlocateno($locate);
        $alert_date = date("Y/m/d H:i:s",strtotime($expdate."-1 day"));
        $ck_date = date("Y/m/d H:i:s");
        $exp_state = $this->Refrigerator_model->foodstate($expdate,$alert_date);
        $params = (object)[
            'memberno' => $member_no,
            'groupno' => $group_no,
            'foodname' => $foodname,
            'quantity' => $quantity,
            'unit' => $unit,
            'unitno' => $unitno,
            'expdate' => $expdate,
            'type' => $type,
            'typeno' => $typeno,
            'locate' => $locate,
            'locateno' => $locateno,
            'alertdate' => $alert_date,
            'ckdate' => $ck_date,
            'expstate' => $exp_state
        ];
        $result = $this->Refrigerator_model->refadd($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }    
    }

    public function getreflist(){
        $email = $this->input->post('email');
        $member_no = $this->Refrigerator_model->getmemberno($email);
        $params = (object)[
            'memberno' => $member_no
        ];
        $result = $this->Refrigerator_model->getreflist($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
                $reflist['reflist'][] = [
                    'response' => 'success',
                    'food'=>$v['food_name'],
                    'quantity'=>$v['quantity'],
                    'unit'=>$v['unit_cn'],
                    'day'=>(strtotime(date('Y/m/d', strtotime($v['exp_date'])))-strtotime(date('Y/m/d')))/(60*60*24),
                    'state'=>$v['exp_state']
                ];
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($reflist
            , JSON_UNESCAPED_UNICODE));
        }
    }
}