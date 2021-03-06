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
                    'photo' => $v['profile_picture'],
                    'group_name' => $v['group_cn']
                ];
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($user, JSON_UNESCAPED_UNICODE));
        }
    }

    public function updateinfo()
    {
        $email = $this->input->post('email');
        $newName = $this->input->post('newName');
        $newPhoto = $this->input->post('newphoto');
        $params = (object)[
            'newName' => $newName,
            'newphoto' => $newPhoto,
            'email' => $email
        ];
        $result = $this->UserSetting_model->updateinfo($params);
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

    public function update_refname(){
        $email = $this->input->post('email');
        $member_no = $this->UserSetting_model->getmemberno($email);
        $group_no = $this->UserSetting_model->get_user_locate($email);
        $refname = $this->input->post('refname');
        $params = (object)[
            'member_no' => $member_no,
            'refname' => $refname,
            'group_no' => $group_no
        ];
        $result = $this->UserSetting_model->update_refname($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }
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
        $member_no = $this->UserSetting_model->getmemberno($email);
        $new_time = $this->input->post('notify_time');
        $params = (object)[
            'email' => $email,
            'member_no' => $member_no,
            'new_time' => $new_time
        ];
        $result = $this->UserSetting_model->update_notify_time($params);
        $old_ref_alert = $this->UserSetting_model->get_reflist_alert($member_no);
        $old_shop_alert = $this->UserSetting_model->get_shoplist_alert($member_no);
        if($result != 0){
            if($old_ref_alert==false){
                print "failure";
            }else{
                //??????????????????????????????
                foreach ($old_ref_alert as $row => $v){
                    $new_ref_alert = date('Y/m/d', strtotime($v['alert_date']))." ".$new_time;
                    //print $new_ref_alert;
                    $ref_params = (object)[
                        'member_no' => $member_no,
                        'food_no' =>$v['refre_list_no'],
                        'new_ref_alert' => $new_ref_alert
                    ];
                    $update_ref_alert = $this->UserSetting_model->update_reflist_notify($ref_params);
                    if($update_ref_alert == false){
                        print "failure";
                    }
                }
                //??????????????????????????????
                foreach ($old_shop_alert as $row => $v){
                    $new_shop_alert = date('Y/m/d', strtotime($v['hint_datetime']))." ".$new_time;
                    //print $new_shop_alert;
                    $shop_params = (object)[
                        'member_no' => $member_no,
                        'shoplist_no' => $v['shopping_list_no'],
                        'new_shop_alert' => $new_shop_alert
                    ];
                    $update_shop_alert = $this->UserSetting_model->update_shoplist_notify($shop_params);
                    if($update_shop_alert == false){
                        print "failure";
                    }
                }
                print "success";
            }             
        }else{
            print "failure";
        }
    }

    public function getKind_setting()
    {
        $email = $this->input->post('email');
        $params = (object)[
            'email' => $email
        ];
        //$kindlist['kind'] = $this->Refrigerator_model->getkind($params);
        $result = $this->UserSetting_model->getkind($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
                $kindlist['kind'][]=[
                    'kind_cn' => $v['kind_cn'],
                    'kind_photo' => $v['kind_photo']
                ];
            }
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($kindlist, JSON_UNESCAPED_UNICODE));
    }
}