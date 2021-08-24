<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Login_model');
			$this->load->model('Group_model');
	}

    public function login()
    {
		$params = (object)[
			'email' => $this->input->post('email'),
			'passwd' => $this->input->post('passwd'),
		];

        $result = $this->Login_model->login($params);
		if($result == false)
		{
			$this->output->set_content_type('application/json');
			$userinfo = [
				'response' => 'failure'
			];
			$this->output->set_output(json_encode([
				'userinfo' => array($userinfo)
			], JSON_UNESCAPED_UNICODE));
		}else{
            foreach ($result as $row => $v){
				$userinfo = [
					'response' => 'success',
					'member_nickname'=>$v['member_nickname'],
					'email'=>$v['email'],
					'passwd'=>$v['passwd']
				];
				$this->output->set_output(json_encode([
					'userinfo' => array($userinfo)
				], JSON_UNESCAPED_UNICODE));
            }
		}
    }

	public function register()
	{

		$randomstrCheck = false;

		while (!$randomstrCheck) {
			$group_no = $this->Login_model->randomStr(5);
			$randomstrCheck = $this->Login_model->randomStrCheck($group_no);
		}

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$passwd = $this->input->post('passwd');
		$passwdck = $this->input->post('passwdck');

		$params = (object)[
			'name' => $name,
			'email' => $email,
			'passwd' => $passwd,
			'passwdck' => $passwdck,
			'group_no' => $group_no,
		];

		if (
			!empty($name) && !empty($email) && !empty($passwd)
		) {
			$emailCheck = $this->Login_model->emailCheck($email);
			if($emailCheck != true){
				print("failure");
			}else{
				$insertResult = $this->Login_model->register($params);
				$groupResult = $this->Group_model->group($params);
				if (!$insertResult && !$groupResult) {
					print("failure");
				} else {
					print("success");
				}
			}
		}
	}
}
