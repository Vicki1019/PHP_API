<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Group_model');
		$this->load->model('Login_model');
		$this->load->model('Refrigerator_model');
		$this->load->model('UserSetting_model');
	}

	public function get_allGroup_totalMember()
	{
		$email = $this->input->post('email');
		$data = $this->Group_model->get_memberno($email);
		$groups = $this->Group_model->get_group($data['member_no']);
		if ($groups != 0) {
			$datas['allgroup'] = [];
			foreach ($groups as $key => $group) {
				$data = $this->Group_model->get_total_group_member($group);
				array_push($datas['allgroup'], $data);
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(
				$datas,
				JSON_UNESCAPED_UNICODE
			));
		} else {
			print "failure";
		}
	}

	public function get_group_member()
	{
		$invite_code = $this->input->post('group_no');
		$result['group_member'] = $this->Group_model->get_group_member($invite_code);

		if ($result != 0) {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(
				$result,
				JSON_UNESCAPED_UNICODE
			));
		} else {
			print "failure";
		}
	}

	public function create_group(){
		$randomstrCheck = false;

		while (!$randomstrCheck) {
			$group_no = $this->Login_model->randomStr(5);
			$randomstrCheck = $this->Login_model->randomStrCheck($group_no);
		}
		
        $email = $this->input->post('email');
		$member_no = $this->UserSetting_model->getmemberno($email);
		$group_name = $this->input->post('group_name');
		
		$result = $this->Group_model->group($member_no, $group_no, $group_name);
		if (!$result) {
			print "failure";
		} else {
			print "success";
		}
    }

	public function join_group()
	{
		$invite_code = $this->input->post('group_no');
		$check = $this->Group_model->check_group($invite_code);
		if (!$check) {
			print "failure";
		} else {
			$email = $this->input->post('email');
			$member_no = $this->Refrigerator_model->getmemberno($email);
			$group_data = $this->Group_model->get_group_name($invite_code);
			$params = (object)[
				'member_no' => $member_no,
				'invite_code' => $invite_code,
				'group_cn' => $group_data['group_cn'],
			];
			$check_join_group =  $this->Group_model->check_join_group($params);
			if($check_join_group == false){
				$result = $this->Group_model->join_group($params);
				if (!$result) {
					print "failure";
				} else {
					print "success";
				}
			}else{
				print "alreadyjoin";
			}
		}
	}

	public function check_default_group(){
		$group_no = $this->input->post('group_no');
		$result = $this->Group_model->check_default_group($group_no);
		if($result!=0){
			print "isdefault";
		}else{
			print "notdefault";
		}
	}
}
