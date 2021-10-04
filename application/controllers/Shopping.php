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

    public function shop_list_add(){
        $email = $this->input->post('email');
        $member_no = $this->Shopping_model->getmemberno($email);
        $group_no = $this->Shopping_model->getgroupno($email);
        $notifydate = $this->input->post('notifydate');
        $name = $this->input->post('name');
        $quantity = $this->input->post('quantity');
        $ck_date = date("Y/m/d H:i:s");
        $params = (object)[
            'memberno' => $member_no,
            'groupno' => $group_no,
            'notifydate' => $notifydate,
            'name' => $name,
            'quantity' => $quantity,
            'ckdate' => $ck_date
        ];
        $result = $this->Shopping_model->shop_list_add($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }    
    }

    public function get_shopping_list(){
        $email = $this->input->post('email');
        $member_no = $this->Shopping_model->getmemberno($email);
        $choose_date = $this->input->post('choosedate');
        $params = (object)[
            'memberno' => $member_no,
            'choosedate' => $choose_date
        ];
        $result = $this->Shopping_model->get_shopping_list($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
               $shoppinglist['reflist'][] = [
                    'response' => 'success',
                    'shoppinglistno' => $v['shopping_list_no'],
                    'msgreceiver' => $v['msg_receiver'],
                    'foodname' => $v['food_name'],     
                    'quantity' => $v['quantity'],
                    'checkbox' => $v['check_box']
                ];
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($shoppinglist
            , JSON_UNESCAPED_UNICODE));
        }
    }
}