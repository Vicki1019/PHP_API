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
        $result = $this->UserSetting_model->userCheck($email);
        if($result == false){
            print "failure";
        }else{
            foreach($result as $row => $v){
                $user['info'][]=[
                    'photo' => $v['profile_picture']
                ];
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($user, JSON_UNESCAPED_UNICODE));
        }
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

    public function addkind(){
        $newkind = $this->input->post('newkind');
        $email = $this->input->post('email');
        $member_no = $this->UserSetting_model->getmemberno($email);
        $group_no = $this->UserSetting_model->getgroupno($email);
        $params = (object)[
            'newkind' => $newkind,
            'memberno' => $member_no,
            'groupno' => $group_no
        ];
        $kindcheck = $this->UserSetting_model->kindcheck($params);
        if($kindcheck != true){
            print "repetition";
        }else{
            $result = $this->UserSetting_model->addkind($params);
            if($result != 0){
                print "success";
            }else{
                print "failure";
            }
        }
    }

    public function deletekind(){
        $deletekind = $this->input->post('deletekind');
        $email = $this->input->post('email');
        $member_no = $this->UserSetting_model->getmemberno($email);
        $params = (object)[
            'deletekind' => $deletekind,
            'memberno' => $member_no
        ];
        $result = $this->UserSetting_model->deletekind($params);
            if($result != 0){
                print "success";
            }else{
                print "failure";
            }
    }

    public function get_send_hint(){
        $email = $this->input->post('email');
        $result = $this->UserSetting_model->get_send_hint($email);
        if($result == false){
            print "falure";
        }else{
            foreach ($result as $row => $v){
                $send_hint['time'][] = [
                     'send_hint' => $v['send_hint'],
                ];
            }
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($send_hint, JSON_UNESCAPED_UNICODE));
    }

    public function update_notify_time(){
        $email = $this->input->post('email');
        $new_time = $this->input->post('notify_time');
        $params = (object)[
            'email' => $email,
            'new_time' => $new_time
        ];
        $result = $this->UserSetting_model->update_notify_time($params);
        if($result != 0){
             print "success";
        }else{
            print "failure";
        }
    }
}