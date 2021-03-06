<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refrigerator extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Refrigerator_model');
            $this->load->model('UserSetting_model');
            $this->load->model('Group_model');
	}

    public function getUnit()
    {
        $email = $this->input->post('email');
        $params = (object)[
            'email' => $email
        ];
        $unitlist['unit'] = $this->Refrigerator_model->getunit($params);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($unitlist, JSON_UNESCAPED_UNICODE));
    }

    public function getKind()
    {
        $email = $this->input->post('email');
        $params = (object)[
            'email' => $email
        ];
        //$kindlist['kind'] = $this->Refrigerator_model->getkind($params);
        $result = $this->Refrigerator_model->getkind($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
                $kindlist['kind'][]=[
                    'kind_cn' => $v['kind_cn']
                ];
            }
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($kindlist, JSON_UNESCAPED_UNICODE));
    }

    public function getlocate()
    {
        $locatelist['locate'] = $this->Refrigerator_model->getlocate();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($locatelist, JSON_UNESCAPED_UNICODE));
    }

    public function refadd(){
        $email = $this->input->post('email');
        $member_no = $this->Refrigerator_model->getmemberno($email);
        $group_no = $this->Refrigerator_model->get_ref_locate($email);
        $notify_time = $this->UserSetting_model->get_send_hint($email);
        $foodname = $this->input->post('foodname');
        $quantity = $this->input->post('quantity');
        $unit = $this->input->post('unit');
        $unitno = $this->Refrigerator_model->getunitno($unit);
        $expdate = $this->input->post('expdate');
        $kind = $this->input->post('kind');
        $kindno = $this->Refrigerator_model->getkindno($kind);
        $locate = $this->input->post('locate');
        $locateno = $this->Refrigerator_model->getlocateno($locate);
        $alert_date = date("Y/m/d",strtotime($expdate."-1 day")) . " ". $notify_time[0]['send_hint'];
        $ck_date = date("Y/m/d H:i:s");
        $exp_state = $this->Refrigerator_model->foodstate($expdate,$alert_date);
        $photo = $this->input->post('photo');
        $params = (object)[
            'memberno' => $member_no,
            'groupno' => $group_no,
            'foodname' => $foodname,
            'quantity' => $quantity,
            'unit' => $unit,
            'unitno' => $unitno,
            'expdate' => $expdate,
            'kind' => $kind,
            'kindno' => $kindno,
            'locate' => $locate,
            'locateno' => $locateno,
            'alertdate' => $alert_date,
            'ckdate' => $ck_date,
            'expstate' => $exp_state,
            'photo' => $photo
        ];
        $result = $this->Refrigerator_model->refadd($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }    
    }

    public function getreflist(){
        $email = $this->input->post('email');
        $member_no = $this->Refrigerator_model->getmemberno($email);
       /* $locate_code = $this->Refrigerator_model->get_member_locate($email);
        $group_name = $this->Refrigerator_model->get_group_name($locate_code);*/
        $params = (object)[
            'memberno' => $member_no
        ];
        $result = $this->Refrigerator_model->getreflist($params);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
               $reflist['reflist'][] = [
                    'response' => 'success',
                    'refno'=>$v['refre_list_no'],
                    'owner'=>$v['member_nickname'],
                    'food'=>$v['food_name'],
                    'quantity'=>$v['quantity'],
                    'unit'=>$v['unit_cn'],
                    'expdate'=>date('Y/m/d', strtotime($v['exp_date'])),
                    'day'=>round((strtotime(date('Y/m/d', strtotime($v['exp_date'])))-strtotime(date('Y/m/d')))/(60*60*24)),
                    'kind'=>$v['kind_cn'],
                    'locate'=>$v['locate_cn'],
                    'state'=>$v['exp_state'],
                    'photo'=>$v['photo'],
                    'locate_name'=>$v['group_cn']
                    //'locate_name'=>$group_name
                ];
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($reflist
            , JSON_UNESCAPED_UNICODE));
        }
    }

    public function update_ref_item()
    {
        $email = $this->input->post('email'); //???????????????
        $itemID = $this->input->post('refno'); //??????ID
        $photo = $this->input->post('photo');
        $foodname = $this->input->post('foodname'); //????????????
        $notify_time = $this->UserSetting_model->get_send_hint($email);
        $quantity = $this->input->post('quantity'); //??????
        $unit = $this->input->post('unit'); //??????
        $expdate = $this->input->post('expdate'); //????????????
        $kind = $this->input->post('kind'); //??????
        $locate = $this->input->post('locate'); //??????/??????
        $alert_date = date("Y/m/d",strtotime($expdate."-1 day")) . " ". $notify_time[0]['send_hint']; //????????????
        $ck_date = date("Y/m/d H:i:s"); //????????????
        $todo = $this->input->post('todo'); //????????????

        $member_no = $this->Refrigerator_model->getmemberno($email);
        //$group_no = $this->Refrigerator_model->getgroupno($email);
        $group_no = $this->Refrigerator_model->get_ref_locate($email);
        $unitno = $this->Refrigerator_model->getunitno($unit);
        $kindno = $this->Refrigerator_model->getkindno($kind);
        $locateno = $this->Refrigerator_model->getlocateno($locate);
        $exp_state = $this->Refrigerator_model->foodstate($expdate,$alert_date);

        $params = (object)[
            'itemID' => $itemID,
            'memberno' => $member_no,
            'groupno' => $group_no,
            'photo' => $photo,
            'foodname' => $foodname,
            'quantity' => $quantity,
            'unit' => $unit,
            'unitno' => $unitno,
            'expdate' => $expdate,
            'kind' => $kind,
            'kindno' => $kindno,
            'locate' => $locate,
            'locateno' => $locateno,
            'alertdate' => $alert_date,
            'ckdate' => $ck_date,
            'expstate' => $exp_state
        ];

        $result = $this->Refrigerator_model->update_ref_item($params);
        if($result != 0){
           if($todo == "cancel"){
            print "failure";
           }else if($todo == "edit"){
            print "success";
           }
        }else{
            print "failure";
        }
    }

    public function delete_ref_item()
    {
        $email = $this->input->post('email'); //???????????????
        $itemID = $this->input->post('refre_list_no'); //??????ID

        $member_no = $this->Refrigerator_model->getmemberno($email);
        //$group_no = $this->Refrigerator_model->getgroupno($email);
        $group_no = $this->Refrigerator_model->get_ref_locate($email);

        $params = (object)[
            'itemID' => $itemID,
            'memberno' => $member_no,
            'groupno' => $group_no,
        ];

        $result = $this->Refrigerator_model->delete_ref_item($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }
    }

    public function get_member_locate(){
        $email = $this->input->post('email');
        $result = $this->Refrigerator_model->get_member_locate($email);
        if($result == false){
            print "failure";
        }else{
            foreach ($result as $row => $v){
               $loacatenow['locate_code'][] = [
                    'locate'=>$v['locate_code'],
                    'group_name'=>$v['group_cn']
                ];
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($loacatenow
            , JSON_UNESCAPED_UNICODE));
        }
    }

    public function get_all_locate()
	{
		$email = $this->input->post('email');
		$data = $this->Refrigerator_model->getmemberno($email);
		$groups = $this->Group_model->get_group($data['member_no']);
        if ($groups != 0) {
            $datas['allgroup'] = [];
            foreach ($groups as $key => $group) {
                $data = $this->Refrigerator_model->get_all_locate($group);
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

    public function change_ref_locate(){
        $email = $this->input->post('email'); //???????????????
        $member_no = $this->Refrigerator_model->getmemberno($email);
        $group_no = $this->input->post('group_no'); //????????????????????????
        $params = (object)[
            'memberno' => $member_no,
            'groupno' => $group_no
        ];
        $result = $this->Refrigerator_model->change_ref_locate($params);
        $todo = $this->Refrigerator_model->locate_code_ck($params);
        if($result != 0){
            print "success";
        }else{
            if($todo != 0){
                print "already";
            }else{
                print "failure";
            }
        }
    }

    public function update_food_state_will(){
        $today = date("Y/m/d");
        $alert_date = date("Y/m/d",strtotime($today."+1 day"));
        $params = (object)[
            'exp_date' => $today,
            'alert_date' => $alert_date
        ];
        $result = $this->Refrigerator_model->update_food_state_will($params);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }
    }
    
    public function update_food_state_gone(){
        $today = date("Y/m/d");
        $result = $this->Refrigerator_model->update_food_state_gone($today);
        if($result != 0){
            print "success";
        }else{
            print "failure";
        }
    }
}