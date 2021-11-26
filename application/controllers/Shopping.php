<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Shopping_model');
            $this->load->model('UserSetting_model');
	}

    public function shop_list_add(){
        $email = $this->input->post('email');
        $member_no = $this->Shopping_model->getmemberno($email);
        $group_no = $this->Shopping_model->getgroupno($email);
        $notify_time = $this->UserSetting_model->get_send_hint($email);
        $notifydate = $this->input->post('notifydate');
        $alert_date = date("Y/m/d",strtotime($notifydate)) . " ". $notify_time[0]['send_hint'];
        $name = $this->input->post('name');
        $quantity = $this->input->post('quantity');
        $ck_date = date("Y/m/d H:i:s");
        $params = (object)[
            'memberno' => $member_no,
            'groupno' => $group_no,
            'alert_date' => $alert_date,
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
        $notify_time = $this->UserSetting_model->get_send_hint($email);
        $choose_date = date("Y/m/d",strtotime($this->input->post('choosedate'))) . " ". $notify_time[0]['send_hint'];
        $params = (object)[
            'memberno' => $member_no,
            'choosedate' => $choose_date
        ];
        $result = $this->Shopping_model->get_shopping_list($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
               $shoppinglist['shoppinglist'][] = [
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

    public function delete_shop_item(){
        $email = $this->input->post('email');
        $shop_no = $this->input->post('shop_no');

        $member_no = $this->Shopping_model->getmemberno($email);
        $group_no = $this->Shopping_model->getgroupno($email);

        $params = (object)[
            'shop_no' => $shop_no,
            'memberno' => $member_no,
            'groupno' => $group_no
        ];

        $result = $this->Shopping_model->delete_shop_item($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }
    }
}