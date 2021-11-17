<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LineNotify extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Refrigerator_model');
		$this->load->model('UserSetting_model');
		$this->load->library('session');
		$this->load->library('lib');
	}

	// LINE Notify 授權
    public function LineAuthorize(){
		$data = [
			'email' => $this->input->get('email'),
		];
		// $email = $this->input->get('email');
        $this->load->view('LineAuthorize', $data);
    }

	//取得 LINE Notify Token
	public function GetAuthorizeCode(){
		$data = [
			'email' => $this->input->get('email'),
			'code' => $this->input->get('code'),
			'state' => $this->input->get('state'),
		];
		$this->load->view('LineToken', $data);
	}

	public function saveToken()
	{
		$email = $this->input->post("email");
		$token = $this->input->post("token");
		$params = (object)[
			'email' => $email,
			'token' => $token
		];
		$result = $this->UserSetting_model->savetoken($params);
		if($result != 0){
			print "success";
		}else{
			print "failure";
		}
	}

	public function GetToken(){
		$code = $this->input->post('code');
		$email = $this->input->post('email');
		$url = "https://notify-bot.line.me/oauth/token";
		$data = [
			"grant_type" => "authorization_code",
			"code" => $code,
			"redirect_uri" => "https://172.16.1.57/PHP_API/index.php/LineNotify/GetAuthorizeCode?email=" . $email,

			"client_id" => "AozwCtchOfAAovlPFxAt42",
			"client_secret" => "sJYts3D7hVK9fhWSn0mGRG951iA0Uae9duFkFgFZCnn"
		];
		$header = ["Content-Type: application/x-www-form-urlencoded"];
		$response = $this->cURL($url, $data, [], $header);
		$response = json_decode($response,true);
		$this->output->set_output(json_encode($response["access_token"], JSON_UNESCAPED_UNICODE));
		// return $response["access_token"];
	}

	//POST cURL
	public function cURL($url, $data, $options, $header){
        $curl = curl_init();
		if(in_array("Content-Type: multipart/form-data", $header)){
			$options = [
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $data
			];
		}else{
			$options = [
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => http_build_query($data)
			];
		}
		$defaultOptions = [
			CURLOPT_URL => $url,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true
		];
		$options = $options + $defaultOptions;
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);
		$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$response = substr($response, $headerSize);

		return $response;
	}

	public function get_line_token(){
		$email = $this->input->post("email");
		$result = $this->UserSetting_model->get_line_token($email);
		if($result == false){
			print "falure";
		}else{
			foreach ($result as $row => $v){
				$token['line_token'][] = [
					 'token'=>$v['line_token']
				 ];
			 }
			 $this->output->set_content_type('application/json');
			 $this->output->set_output(json_encode($token
			 , JSON_UNESCAPED_UNICODE));
		}
	}

	public function delete_line_token(){
		$email = $this->input->post("email");
		$result = $this->UserSetting_model->delete_line_token($email);
		if($result != 0){
			print "success";
		}else{
			print "failure";
		}
	}

	public function SendNotify(){
		$ref_need_notify = $this->Refrigerator_model->food_state_notify();
		if($ref_need_notify == false){
			print "falure";
		}else{
			foreach ($ref_need_notify as $row => $v){
				$token = $v['line_token'];
				//$message = $this->input->post("message");
				$url = "https://notify-api.line.me/api/notify";
				//$type = "POST";
				$header = [
					"Authorization:	Bearer ".$token,
					"Content-Type: multipart/form-data"
				];

				$str =  "\n※".$v['member_nickname']."的「".$v['food_name']."」".strval($v['quantity']).$v['unit_cn']."即將過期";

				//傳送訊息
				$data = [
					"message" => $str,
				];

				if(isset($data["imageFile"])){
					$data["imageFile"] = curl_file_create($data["imageFile"]);
				}

				$response = $this->cURL($url,$data,[],$header);
				$response = json_decode($response,true);
				if($response["status"] != "200"){
					print "falure";
					//throw new Exception("error ".$response["Status"]." : ".$response["message"]);
				}else{
					print "success";
				}
			}
		}

		//傳送訊息
		/*$data = [
			"message" => $message,
			"imageThumbnail" => "https://i.ytimg.com/vi/OHBEDNisKnc/hqdefault.jpg",
			"imageFullsize" => "https://i.ytimg.com/vi/OHBEDNisKnc/maxresdefault.jpg",
			"imageFile" => "image/index.png",
			"stickerPackageId" => 1,
			"stickerId" => 1,
			"notificationDisabled" => false
		];*/

		
	}
}