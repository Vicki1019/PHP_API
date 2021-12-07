<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller
{
    public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
            $this->load->library('search');
			$this->load->model('Login_model');
	}

    /**
     * version:0.5
     * type:QRCode
     * invNum:UG79854391 發票號碼
     * action:qryInvDetail
     * generation:V2
     * invTerm:11012 發票期別
     * invDate:2021/11/04
     * encrypt:dkERhe0uxNpZi0OXnoxpFA== 發票檢核碼
     * sellerID:27242868 賣發統編
     * UUID:1234567890987655
     * randomNumber:3623 發票隨機碼
     * appID:EINV7202107209712
     */
    public function getInvList()
    {
        //$type = $this->input->post('scanType');
        $invNum = $this->input->post('invNum');
        $invTerm = $this->input->post('invTerm');
        $invDate = $this->input->post('invDate');
        $encrypt = $this->input->post('encrypt');
        $sellerID = $this->input->post('sellerID');
        $randomNumber = $this->input->post('randomNumber');
        $UUID = strtoupper(md5(uniqid($invNum)));

        $service_url = 'https://api.einvoice.nat.gov.tw/PB2CAPIVAN/invapp/InvApp';

        $curl = curl_init($service_url);
        $curl_post_data = [
            'version' => '0.5',
            //'type' => $type,
            'type' => "QRCode",
            'invNum' => $invNum,
            'action' => 'qryInvDetail',
            'generation' => 'V2',
            'invTerm' => $invTerm,
            'invDate' => $invDate,
            'encrypt' => $encrypt,
            'sellerID' => $sellerID,
            'UUID' => $UUID,
            'randomNumber' => $randomNumber,
            'appID' => 'EINV7202107209712',
        ];

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_post_data));
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }else {
            $this->output->set_output(json_encode($decoded, JSON_UNESCAPED_UNICODE));
        }
    }
    public function catchBrowserPicture()
    {
    // https://www.google.com.tw/imghp?hl=zh-TW
    /**
     * https://serpapi.com/search.json?
     * engine=google 搜尋引擊
     * &q=Coffee 搜尋內容
     * &hl=zh-tw 使用語言
     * &api_key=efa36be74df8e9b8734b27cb8599b18a758410272e86c5172df262790b47c56b
     */
        if(isset($_ENV["API_KEY"])) {
            $this->API_KEY = $_ENV["API_KEY"];
        } else {
            $this->API_KEY = "efa36be74df8e9b8734b27cb8599b18a758410272e86c5172df262790b47c56b";
        }
        $q = $this->input->post('q');
        $client = new GoogleSearch($this->API_KEY);
        $data = $client->get_json([
            'q' => $q,
            'tbm' => 'isch',
            'ijn' => 0,
            'output' => 'JSON'
        ]);

        $images = [];
        foreach($data->images_results as $image_result) {
            array_push($images, $image_result->original);
        }
        // print_r($images);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(
            $images,
            JSON_UNESCAPED_UNICODE
        ));
    }
}