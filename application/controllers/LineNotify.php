<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LineNotify extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('lib');
		$this->load->model('Refrigerator_model');
		$this->load->model('UserSetting_model');
	}

	// LINE Notify 授權
    public function LineAuthorize(){
        $this->load->view('LineAuthorize');
    }

	//取得 LINE Notify Token
	public function GetAuthorizeCode(){
		$data = [
			'email' => $this->session->userData('email'),
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
		$url = "https://notify-bot.line.me/oauth/token";
		$data = [
			"grant_type" => "authorization_code",
			"code" => $code,
			"redirect_uri" => "https://192.168.1.213/PHP_API/index.php/LineNotify/GetAuthorizeCode",
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
}