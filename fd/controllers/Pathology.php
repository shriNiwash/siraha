<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pathology extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('Auth');
		$this->api = "https://siraha.tez.hospital/xzy/lis/";

	}



	public function conn()
	{

		include APPPATH . 'third_party/lab/HL7.php';
		include APPPATH . 'third_party/lab/HL7/Connection.php';
		include APPPATH . 'third_party/lab/HL7/Message.php';
		$host = '192.168.1.100';
		$port = 5432;
		$timeout = 20;




		$ip = '127.0.0.1'; // An IP
		$port = '12001'; // And Port where a HL7 listener is listening

		// Create a Socket and get ready to send message. Optionally add timeout in seconds as 3rd argument (default: 10 sec)
		$connection = new Connection($host, $port);
		$response = $connection->send($message,$responseCharEncoding = 'UTF-8',$noWait = false); // Send to the listener, and get a response back
		echo $response->toString(true); // Prints ACK from the listener
 print_R("hcj");
		die;
		// try {
		// 	$connection = new Connection($host, $port, $timeout);
		// 	// Use $connection to interact with the HL7 server
		// 	$datss = $connection->setSocket($host, $port, $timeout);
		// 	print_r($datss);
		// } catch (HL7ConnectionException $e) {
		// 	// Handle connection exception
		// 	echo 'Error: ' . $e->getMessage();
		// }
		// die;
	}


	public function index()
	{
		$datas = $this->session->userdata('user_data');
		$name = $datas['username'];

		if(!empty($datas))
		{
			$apiEndpoint = $this->api. 'getpathologybillDatatable';
			$headers = array(
				'Content-Type: application/json; charset=UTF-8',
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch);
			$responseData = json_decode($response);
			$data['result'] = $responseData->result;
			$data['status'] = "0";
			$data['bloodgroup'] = $responseData->bloodgroup;
			$data['pathologist'] = $responseData->pathologist;
			$data['prefix'] = $responseData->bill_prefix;
			$data['username'] = $name;
			$this->load->view('pathologylist',$data);
		}else {
			redirect('/');
		}


	}
	public function old_report()
	{
		$session_data = $this->session->userdata('user_id');
		if(!empty($session_data))
		{
			$apiEndpoint = $this->api . 'getpathologybillDatatable_old';
			$headers = array(
				'Content-Type: application/json; charset=UTF-8',
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch);
			$responseData = json_decode($response);
			$data['result'] = $responseData->result;
			$data['status'] = "1";
			$data['prefix'] = $responseData->bill_prefix;
			$data['bloodgroup'] = $responseData->bloodgroup;
			$data['pathologist'] = $responseData->pathologist;
			$this->load->view('pathologylist',$data);
		}
		else{
			redirect('/');
		}

	}
	public function logout()
	{
		$this->session->unset_userdata('user_data');
		// redirect('/');
		$data = array('message' => 'success');
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	public function getPatientPathologyDetails()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api . 'getPatientPathologyDetails';
		$id = $this->input->post('id');

		$requestDatass = array(
			'bill_no' => $id,
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);

		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}
	public function getPathologyEntry(){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api . 'getPatientPathologyDetails';
		$id = $this->input->post('id');

		$requestDatass = array(
			'bill_no' => $id,
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);


		header('Content-Type: application/json');
		echo $responsedData;
	}

	public function getprintreport()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api . 'printPatientReportDetail_individual';
		$report_id = $this->input->post('report_id');
		$testid = $this->input->post('testid');


		$requestDatass = array(
			'report_id' => $report_id,
			'testid' => $testid
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);
		// print_r($responsedData);die;


		header('Content-Type: application/json');
		echo json_encode($responsedData);

	}

	public function getprinteddatapath()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api . 'printPatientReportDetail_data';
		$pid = $this->input->post('pid');
		$cid = $this->input->post('cid');


		$requestDatass = array(
			'pid' => $pid,
			'cid' => $cid
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);
		// print_r($responsedData);die;


		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}
	public function printtestparameterdetail()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api . 'printtestparameterdetail';
		$id = $this->input->post('id');

		$requestDatass = array(
			'bill_no' => $id,

		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);


		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}

	public function getsamplecollect()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api .'getReportCollectionDetail';
		$id = $this->input->post('id');


		$requestDatass = array(
			'id' => $id
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);
		// print_r($responsedData);die;
		// print_r($responsedData);die;


		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}
	public function bulk_sample()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api. 'bulk_sample';
		$id = $this->input->post('id');


		$requestDatass = array(
			'bill_id' => $id
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);

		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}

	public function bull_report_printing()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api. 'bulk_pathology_print';
		$data = $this->input->post();


		$requestDatass = array(
			'dat' => $data
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);
		// print_r($responsedData);die;
		// print_r($responsedData);die;


		header('Content-Type: application/json');
		echo json_encode($responsedData);

	}

	public function bulk_report_entry()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		$apiEndpoint = $this->api. 'bulk_report_entry';
		$bill_id = $this->input->post('bill_id');
		$is_bill = $this->input->post('is_bill');



		$requestDatass = array(
			'is_bill' => $is_bill,
			'bill_id' => $bill_id
		);
		$requestDataJson = json_encode($requestDatass);

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
		$responsedData = json_decode($response);
		// print_r($responsedData);die;
		// print_r($responsedData);die;


		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}
	public function updatecollection()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');
		$apiEndpoint = $this->api .'updatecollection';

		$pathology_report_id = $this->input->post('pathology_report_id');
		$pathology_bill_id = $this->input->post('pathology_bill_id');
		$collection_specialist = $this->input->post('collected_by');
		$pathology_center = $this->input->post('pathology_center');
		$collected_date = $this->input->post('collected_date');
		// $collected_date = date("d/m/Y", strtotime($collected_date));
		$payment_array = array(
			'pathology_report_id'   => $pathology_report_id,
			'pathology_bill_id'     => $pathology_bill_id,
			'collection_specialist' => $collection_specialist,
			'pathology_center'      => $pathology_center,
			'collection_date'       => $collected_date
		);

		$requestDataJsonss = json_encode($payment_array);
		$headers = array(
			'Content-Type: application/json; charset=UTF-8',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataJsonss);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$responsedData = json_decode($response);

		header('Content-Type: application/json');
		echo json_encode($responsedData);
	}
	public function updatebulkreport()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');
		$apiEndpoint = '$this->api . updatebulkreport';


		$payment_array = $this->input->post();
		$payment_array['file']= $_FILES["file"];
		$payment_array['file_name']= $_FILES["file"]['name'];
		$requestDatass = array(
			'dat' => $payment_array,
		);
		$requestDataJson = json_encode($requestDatass);
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
		$responsedData = json_decode($response);
		// 	if($responsedData){
		// 		if (isset($_FILES["file"]) && !empty($_FILES["file"]['name'])) {
		// 	$fileInfo        = pathinfo($_FILES["file"]["name"]);
		// 	$attachment_name = $_FILES["file"]['name'];
		// 	$img_name        = $pathology_report_id . '.' . $fileInfo['extension'];
		// 	move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/pathology_report/" . $img_name);
		// }
		//	}

		header('Content-Type: application/json');
		echo json_encode($responsedData);

	}


}
