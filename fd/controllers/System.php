<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('Auth');
		$this->api = "https://uat.tez.hospital/xzy/lis/";

	}
	public function index()
	{
		$ses_data = $this->session->userdata('user_data');
		if(!empty($ses_data))
		{
			redirect('pathology');
		}

		$this->load->view('login');
	}
	public function login()
	{
		$ses_data = $this->session->userdata('user_data');
		if(!empty($ses_data))
		{
			redirect('pathology');
		}
		$apiEndpoint = $this->api . 'login';
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$requestData = array(
			'username' => $username,
			'password' => $password
		);

		$requestDataJson = json_encode($requestData);

		$headers = array(
			'Content-Type: application/json; charset=UTF-8',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataJson);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$responseData = json_decode($response);
		if($responseData->status == 200)
		{
			$sesdata = array(
				'id'                     => $responseData->id,
				'username'               => $responseData->record->username,
				'employeid'              => $responseData->record->employee_id,
				'roles'                  => $responseData->record->role,
				'timezone'               => $responseData->record->timezone
			);
			$this->session->set_userdata('user_data',$sesdata);
			redirect('pathology');
		}
		else{
			redirect('system');
		}

	}




}
