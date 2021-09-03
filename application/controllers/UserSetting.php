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

    public function updatename()
    {
        $email = $this->input->post('email');
        $newName = $this->input->post('newName');
        $params = (object)[
            'newName' => $newName,
            'email' => $email
        ];
        $result = $this->UserSetting_model->updatename($params);
        if($result > 0){
            print "success";
        }else{
            print "failure";
        }

       /* if(empty($email)||empty($newName))
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
        }*/
    }

    public function updatepass()
    {
        $email = $this->input->post('email');
        $passwd = $this->input->post('passwd');
        $newpasswd = $this->input->post('newpasswd');
        $params = (object)[
            'email' => $email,
            'passwd' => $passwd,
            'newpasswd' => $newpasswd
        ];
        $result = $this->UserSetting_model->updatepass($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }
        /*if(empty($_POST["oldpwd"]) || empty($_POST["newpwd"]))
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
        }*/
    }

    public function addtype(){
        $newtype = $this->input->post('newtype');
        $email = $this->input->post('email');
        $member_no = $this->UserSetting_model->getmemberno($email);
        $group_no = $this->UserSetting_model->getgroupno($email);
        $params = (object)[
            'newtype' => $newtype,
            'memberno' => $member_no,
            'groupno' => $group_no
        ];
        $typecheck = $this->UserSetting_model->typecheck($params);
        if($typecheck != true){
            print "repetition";
        }else{
            $result = $this->UserSetting_model->addtype($params);
            if($result != 0){
                print "success";
            }else{
                print "failure";
            }
        }
    }

    public function deletetype(){
        $deletetype = $this->input->post('deletetype');
        $email = $this->input->post('email');
        $member_no = $this->UserSetting_model->getmemberno($email);
        $params = (object)[
            'deletetype' => $deletetype,
            'memberno' => $member_no
        ];
        $result = $this->UserSetting_model->deletetype($params);
            if($result != 0){
                print "success";
            }else{
                print "failure";
            }
    }
}