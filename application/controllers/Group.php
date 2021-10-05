<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Group_model');
	}

    public function get_allGroup_totalMember(){
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
            $this->output->set_output(json_encode($datas
            , JSON_UNESCAPED_UNICODE));
		} else {
			print "failure";
		}
    }

	public function get_group_member()
	{
		$invite_code = $this->input->post('group_no');
		$result['group_member'] = $this->Group_model->get_group_member($invite_code);
		//print_r($result);
		if ($result != 0)
		{
			$this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result
            , JSON_UNESCAPED_UNICODE));
		}else {
			print "failure";
		}
	}
}