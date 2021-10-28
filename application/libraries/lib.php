<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib
{
    public function __get($var)
	{
		return get_instance()->$var;
	}

    public function __construct()
	{
		$this->load->database();
        $this->load->library('session');
		$this->load->model('Login_model');
	}

    function validate($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function user($params)
    {
        if ($params->response == 'login') {
            $userData = (object)[
                'email' => $params->email,
                'nickname' => $params->member_nickname,
            ];
        } else {
            $data = $this->Login_model->idGetEmail($params->id);
            // print($data['email']);
            $userData = (object)[
                'email' => $data['email'],
                'nickname' => $data['member_nickname'],
            ];
        }
        $u_data = array(
            'username'  => $userData->nickname,
            'email'     => $userData->email,
            'logged_in' => TRUE
        );

        $this->session->set_userdata($u_data);
        return $userData;
    }
}