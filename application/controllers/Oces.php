<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oces extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper("send_email_helper");
		$this->load->helper("dbclass");

		$this->load->model("userModel");
		$this->load->model("studentModel");
		$this->load->model("rulesModel");
		$this->load->model("deptModel");
		$this->load->model("candidatesModel");

		session_start();
	}

	public function testemail(){
		$messageTo = "ahsaifulla@gmail.com";
		$messageBody = "Test vote";
		$subject = "oces";

		sendCiEMail($messageTo, $messageBody, $subject);
	}

	public function testotp($length){
		echo generateOTP($length);
	}

	public function voteProcess(){

		$usn = $this->input->get('usn');

		$numRows = $this->db->get_where("student_info","usn = '$usn'")->num_rows();

		if($numRows < 1){
			echo json_encode(array("status" => false, "message" => "USN doesnt Exist"));
			exit();
		}

		$length = 4;
		$OTP =  generateOTP($length);

		//inserting OTP to DB
		$this->db->update("student_info",array("OTP" => $OTP),array('usn' => $usn));

		//sending OTP via email
		$messageTo = "ahsaifulla@gmail.com";
		$messageBody = "OTP : ".$OTP;
		$subject = "2oces";

		$db = new Database();
		$email = $db->getFieldValueById("student_info","email","usn = '$usn'");

		sendCiEMail($email, $messageBody, $subject);

		echo json_encode(array("status" => true, "message" => "OTP gen","otp" => $OTP));

	}

	public function otpValidation(){
		$usn2 = $this->input->get('usn2');
		$otp2 = $this->input->get('otp2');

		$numRows = $this->db->get_where("student_info","usn = '$usn2' AND OTP = '$otp2' AND VoteStatus = '0'")->num_rows();

		if($numRows < 1){
			echo json_encode(array("status" => false, "message" => "OTP Invalid"));
			exit();
		}
		$_SESSION['voter']=$usn2;
		//inserting OTP to DB
		echo json_encode(array("status" => true, "message" => "Validated success"));

	}


	public function index()
	{
		
		$this->load->view('home');
		
	}

	public function result()
	{
		
		$this->load->view('result');
		
	}

	public function candidates()
	{
		// echo "my custom home";

		$this->load->view('candidates');
	}

	public function users()
	{
		// echo "my custom home";

		$this->load->view('users');
	}


	public function rules()
	{
		// echo "my custom home";

		$this->load->view('rules');
	}

	public function voters()
	{
		// echo "my custom home";

		$this->load->view('voters');
	}

	

	public function admin_panel()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		echo "<script> alert('login success');</script>";
		$this->load->view('admin_panel');

	}


	public function changePassValid()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		$this->load->view('admin_panel');



	}

	public function changePass()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		$this->load->view('changePass');

	}

	public function votersEdit()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		
		$this->load->view('votersEdit');

	}

	public function deptsEdit()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		
		$this->load->view('deptsEdit');

	}

	public function settings()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		
		$this->load->view('settings');

	}

	public function rulesEdit()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		
		$this->load->view('rulesEdit');

	}

	
	public function candidatesEdit()
	{
		// echo "my custom home";

		if (!isset($_SESSION['admin'])){
			echo "<script> alert('You must Login First');</script>";
			$this->index();
			return;
		}
		
		$this->load->view('candidatesEdit');

	}

	public function login(){
		$email = $this->input->post('email_id');
		$pwd = $this->input->post('password');

		$result = $this->db->get_where("users",array("email" => $email, "password" => $pwd))->num_rows();
		
		if($result < 1){	
			echo json_encode(array("status"=>FALSE  , "message" => "Username or Password Incorrect"));
			exit;
		}

		$_SESSION['admin'] = $email;

		$result2 = $this->db->get_where("users",array("email" => $email, "password" => $pwd));
		// if($result2 < 1){	
		// 	$_SESSION['superadmin'] = $email;
		// }
		
		echo json_encode(array("status"=>TRUE));
	}

	public function vote($candidateId){
		$this->db->query("UPDATE nominees SET voteCount = voteCount+1 WHERE Id = '$candidateId'");
	}


	
	public function saveVoter(){
		$Id = $this->input->post('hidID');
		$usn = $this->input->post('usn');
		$vName = $this->input->post('vName');
		$gender = $this->input->post('gender');
		$dob = $this->input->post('vdob');
		$department = $this->input->post('vDept');
		$semester = $this->input->post('semester');
		$email = $this->input->post('email');
		$MobileNo = $this->input->post('phone');

		if($Id > 0){
			
			$this->db->update("student_info",array("usn" => $usn,"s_name" => $vName,"dob" => $dob,"department" => $department,"semester" => $semester, "gender" => $gender, "email" => $email,"MobileNo" => $MobileNo),array("Id" => $Id));
		}
		else{
			$this->db->insert("student_info",array("usn" => $usn,"s_name" => $vName,"dob" => $dob,"department" => $department,"semester" => $semester, "gender" => $gender, "email" => $email,"MobileNo" => $MobileNo));
		}	

		echo json_encode(array("status"=>TRUE));
	}

	public function saveRule(){
		$Id = $this->input->post('hidID');
		$rule = $this->input->post('rule');

		if($Id > 0){
			
			$this->db->update("rules",array("rule" => $rule),array("Id" => $Id));
		}
		else{
			$this->db->insert("rules",array("rule" => $rule));
		}	

		echo json_encode(array("status"=>TRUE));
	}


	public function savePass(){
		// $Id = $this->input->post('hidID');
		$Id = $this->input->post('userId');
		$newPass = $this->input->post('newPass');
		$newPassConfirm = $this->input->post('newPassConfirm');
		$adminPass = $this->input->post('adminPass');

		$servername="localhost";
		$username="root";
		$password="";
		$dbname="oces";

		//create connection
		$dbcon=mysqli_connect($servername,$username,$password,$dbname);
		
		$sql = "SELECT * FROM users WHERE password = '$adminPass' AND usertype = 'Admin'";
		$result = mysqli_query($dbcon, $sql);
		if (mysqli_num_rows($result) > 0) {
			if($newPass == $adminPass){
			
				$this->db->update("users",array("password" => $newPass),array("id" => $Id));
			}	
		}

		
		

		echo json_encode(array("status"=>TRUE));
	}




	public function saveDept(){
		$Id = $this->input->post('hidID');
		$dept = $this->input->post('deptName');

		if($Id > 0){
			
			$this->db->update("department",array("dept" => $dept),array("Id" => $Id));
		}
		else{
			$this->db->insert("department",array("dept" => $dept));
		}	

		echo json_encode(array("status"=>TRUE));
	}

	public function logout(){
		unset($_SESSION['admin']);
		header("location:".base_url());
	}

	// For daatables model processing
	public function studentList()
   {
    
        $list = $this->studentModel->getDataTables();
		
		//	echo json_encode($list);exit;
		
        $data1 = array();
        $data = array();
		
		foreach ($list as $data) {
			$row = array();
			$row[]=$data->usn;
			$row[]=$data->s_name;
			$row[]=$data->dob;
			$row[]=$data->department;
			$row[]=$data->semester;
			$row[]=$data->email;
			$row[] = '<a  id="editButton" class="btn btn-info" href="javascript:void(0)" title="Click to Edit" onclick="editData('."'".$data->Id."'".')"><i class="glyphicon glyphicon-edit"></i> Edit</a>
				  <a  id="deleteButton" class="btn btn-sm btn-danger" href="javascript:void(0)" title="Click to Delete" onclick="deleteData('."'".$data->Id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			// $row[]="<a  class='btn btn-warning' href='".base_url()."welcome/edit_page/$data->Id'> Edit </a>
			// 	<button  class='btn btn-danger' onclick='edit_btn($data->Id)'> Delete </button>";

			$data1[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->studentModel->countAll(),
						"recordsFiltered" => $this->studentModel->countFiltered(),
						"data" => $data1,
				);
		//output to json format
		echo json_encode($output);
   }


	// For daatables model processing
	public function candidatesList()
   {
    
        $list = $this->candidatesModel->getDataTables();
		
		//	echo json_encode($list);exit;
		
        $data1 = array();
        $data = array();
		
		foreach ($list as $data) {
			$row = array();
			$row[]=$data->usn;
			$row[]=$data->c_name;
			$row[]=$data->dob;
			$row[]=$data->dept;
			$row[]=$data->sem;
			$row[]=$data->email_id;
			$row[]=$data->status;
			$row[] = '<a  id="acceptButton" class="btn btn-success" href="javascript:void(0)" title="Click to Edit" onclick="acceptCandi('."'".$data->Id."'".')"><i class="glyphicon glyphicon-edit"></i> Accept</a>
				  <a  id="rejectButton" class="btn btn-sm btn-danger" href="javascript:void(0)" title="Click to Reject" onclick="rejectCandi('."'".$data->Id."'".')"><i class="glyphicon glyphicon-trash"></i> Reject</a>';
			// $row[]="<a  class='btn btn-warning' href='".base_url()."welcome/edit_page/$data->Id'> Edit </a>
			// 	<button  class='btn btn-danger' onclick='edit_btn($data->Id)'> Delete </button>";

			$data1[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->candidatesModel->countAll(),
						"recordsFiltered" => $this->candidatesModel->countFiltered(),
						"data" => $data1,
				);
		//output to json format
		echo json_encode($output);
   }



   public function userList()
   {
    
        $list = $this->userModel->getDataTables();
		
		//	echo json_encode($list);exit;
		
        $data1 = array();
        $data = array();
		
		foreach ($list as $data) {
			$row = array();
			$row[]=$data->id;
			$row[]=$data->username;
			$row[]=$data->status;
			$row[]=$data->usertype;
			$row[]=$data->email;
			$row[]=$data->gender;
			// $row[]="<a  class='btn btn-warning' href='".base_url()."welcome/edit_page/$data->Id'> Edit </a>
			// 	<button  class='btn btn-danger' onclick='edit_btn($data->Id)'> Delete </button>";

			$data1[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->userModel->countAll(),
						"recordsFiltered" => $this->userModel->countFiltered(),
						"data" => $data1,
				);
		//output to json format
		echo json_encode($output);
   }

   public function rulesList()
   {
    
        $list = $this->rulesModel->getDataTables();
		
		//	echo json_encode($list);exit;
		
        $data1 = array();
        $data = array();
		
		foreach ($list as $data) {
			$row = array();
			$row[]=$data->Id;
			$row[]=$data->rule;
			$row[] = '<a  id="editButton" class="btn btn-info" href="javascript:void(0)" title="Click to Edit" onclick="editRules('."'".$data->Id."'".')"><i class="glyphicon glyphicon-edit"></i> Edit</a>
			<a  id="deleteButton" class="btn btn-sm btn-danger" href="javascript:void(0)" title="Click to Delete" onclick="deleteRule('."'".$data->Id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			// $row[]="<a  class='btn btn-warning' href='".base_url()."welcome/edit_page/$data->Id'> Edit </a>
			// 	<button  class='btn btn-danger' onclick='edit_btn($data->Id)'> Delete </button>";

			$data1[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rulesModel->countAll(),
						"recordsFiltered" => $this->rulesModel->countFiltered(),
						"data" => $data1,
				);
		//output to json format
		echo json_encode($output);
   }

   public function deptList()
   {
    
        $list = $this->deptModel->getDataTables();
		
		//	echo json_encode($list);exit;
		
        $data1 = array();
        $data = array();
		
		foreach ($list as $data) {
			$row = array();
			$row[]=$data->Id;
			$row[]=$data->dept;
			$row[] = '<a  id="deleteButton" class="btn btn-sm btn-danger" href="javascript:void(0)" title="Click to Delete" onclick="deleteDept('."'".$data->Id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			// $row[]="<a  class='btn btn-warning' href='".base_url()."welcome/edit_page/$data->Id'> Edit </a>
			// 	<button  class='btn btn-danger' onclick='edit_btn($data->Id)'> Delete </button>";

			$data1[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rulesModel->countAll(),
						"recordsFiltered" => $this->rulesModel->countFiltered(),
						"data" => $data1,
				);
		//output to json format
		echo json_encode($output);
   }

   public function getEditVoter($id)  // getting data for editing
{
		$data = $this->studentModel->getById($id);
		echo json_encode($data);
}

public function acceptCandi($id)  // getting data for editing
{
		$accepted = "Accepted";
		$this->db->update("nominees",array("status" => "Accept"),array("Id" => $id));
		echo json_encode(array("status"=>TRUE));
		
}


public function rejectCandi($id)  // getting data for editing
{
		// $accepted = "Accepted";
		$this->db->update("nominees",array("status" => "Reject"),array("Id" => $id));
		echo json_encode(array("status"=>TRUE));
		
}

public function getEditRule($id)  // getting data for editing
{
		
		$data = $this->rulesModel->getById($id);
		echo json_encode($data);

}


public function deleteVoter($id)  // getting data for editing
{
	$this->db->delete("student_info",array('id'=>$id));
		// $data = $this->studentModel->getById($id);
		echo json_encode(array("status"=>TRUE));

}


public function deleteRule($id)  // getting data for editing
{
	$this->db->delete("rules",array('id'=>$id));
		// $data = $this->studentModel->getById($id);
		echo json_encode(array("status"=>TRUE));

}


public function deleteDept($id)  // getting data for editing
{
	$this->db->delete("department",array('id'=>$id));
		// $data = $this->studentModel->getById($id);
		echo json_encode(array("status"=>TRUE));

}


public function applyNominee(){
	// $Id = $this->input->post('hidID');
	$usn = $this->input->post('usn');
	$c_name = $this->input->post('c_name');
	$gender = $this->input->post('gender');
	$post = $this->input->post('post');
	$dob = $this->input->post('dob');
	$dept = $this->input->post('dept');
	$sem = $this->input->post('sem');
	$mobile = $this->input->post('mobile');
	$email_id = $this->input->post('email_id');
	
	$this->db->insert("nominees",array("usn" => $usn,"c_name" => $c_name,"gender" => $gender,"post" => $post,"dob" => $dob,"dept" => $dept,"sem" => $sem,"mobile" => $mobile,"email_id" => $email_id));
	

	echo json_encode(array("status"=>TRUE));
}

public function voting(){

	if(!isset($_SESSION['voter'])){
		$this->load->view('home');
	}

	$data['result'] = $this->db->get("nominees")->result_array();


	

	$this->load->view('voting',$data);
}

public function voteCast(){


	$data['result'] = $this->db->get("nominees")->result_array();


	

	$this->load->view('voting',$data);
}

public function adminValidate($adminPass){
	$numRows = $this->db->query("SELECT * FROM users WHERE password = '$adminPass' AND usertype = 'Admin'")->num_rows();
	if($numRows > 1){
		$this->db->query("UPDATE resultPublish SET publish = 'Yes'");
	}
}

}


