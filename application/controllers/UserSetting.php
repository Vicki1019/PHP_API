<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserSetting extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('UserSetting_model');
	}

    public function getUserInfo()
    {
        $email = $this->input->post('emaildata');
        $user['username'] = $this->UserSetting_model->userCheck($email);

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($user, JSON_UNESCAPED_UNICODE));
    }

    public function updateNickname()
    {
        $email = $this->input->post('email');
        $newName = $this->input->post('nickname');
        if(empty($email)||empty($newName))
        {
            print("email or nickname can not be empty");
        } else {
            $params = (object)[
                'email' => $email,
                'nickname' => $newName
            ];
            $result = $this->UserSetting_model->updateUserName($params);
            if ($result == 1) {
                print("success");
            } else {
                print("update failed");
            }
        }
    }

    public function updatePassword()
    {
        $email = $this->input->post('email');
        $oldpwd = $this->input->post('oldpwd');
        $newpwd = $this->input->post('newpwd');
        if(empty($_POST["oldpwd"]) || empty($_POST["newpwd"]))
        {
            print("old password or new password can not be empty");
        } else {
            $params = (object)[
                'email' => $email,
                'oldpwd' => $oldpwd,
                'newpwd' => $newpwd
            ];
            $result = $this->UserSetting_model->updatePassword($params);
            if ($result == 1) {
                print("success");
            } else if ($result == "old password failed") {
                    print("old password failed");
            } else {
                    print("update failed");
            }
        }
    }
}