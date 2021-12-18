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
			$this->load->library('session');
			$this->load->library('lib');
	}

	public function index()
	{
		// print(phpinfo());
		$this->load->view('login');
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
				$params = (object)[
					'response' => 'login',
					'member_nickname'=>$v['member_nickname'],
					'email'=>$v['email'],
				];
				$this->lib->user($params);
				$this->output->set_output(json_encode([
					'userinfo' => array($userinfo),
					// 'session_id' => $this->session->userdata(),
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
		$profile_picture = $this->input->post('photo');
		$google_sign_in = $this->input->post('google_sign_in');

		if($google_sign_in == "true"){
			$params = (object)[
				'name' => $name,
				'email' => $email,
				'passwd' => $passwd,
				'passwdck' => $passwdck,
				'photo' => $profile_picture,
				'groupno' => $group_no,
				'google_sign_in' => "1"
			];

			if (
				!empty($name) && !empty($email)
			) {
				$emailCheck = $this->Login_model->emailCheck($email);
				if($emailCheck != true){
					print("failure");
				}else{
					$insertResult = $this->Login_model->register($params);
					$params = (object)[
						'response' => 'register',
						'id'=>$insertResult,
					];
					$this->lib->user($params);
					$groupResult = $this->Group_model->group($insertResult,$group_no,$name);
					if (!$groupResult) {
						print("failure");
					} else {
						print("success");
					}
				}
			}
			
		}else if($google_sign_in == "false"){
			$params = (object)[
				'name' => $name,
				'email' => $email,
				'passwd' => $passwd,
				'passwdck' => $passwdck,
				'photo' => $profile_picture,
				'groupno' => $group_no,
				'google_sign_in' => "0"
			];

			if (
				!empty($name) && !empty($email) && !empty($passwd)
			) {
				$emailCheck = $this->Login_model->emailCheck($email);
				if($emailCheck != true){
					print("failure");
				}else{
					$insertResult = $this->Login_model->register($params);
					$params = (object)[
						'response' => 'register',
						'id'=>$insertResult,
					];
					$this->lib->user($params);
					$groupResult = $this->Group_model->group($insertResult,$group_no,$name);
					if (!$groupResult) {
						print("failure");
					} else {
						print("success");
					}
				}
			}
			
		}
	}
}
