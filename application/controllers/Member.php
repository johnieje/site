<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends  MY_Controller {
	
	public function __construct(){
		parent::__construct();
		
	}
	
	public function dashboard(){
		if($this->session->userdata('is_logged_in')){
			//$this->load->view('members');
			$member_id = $this->session->userdata('member_id');
			$user_type = $this->session->userdata('user_type');
			$data = array(
				'title' => "Member Dashboard",
				'member_id' => $member_id,
				'is_logged_in' => true,
				'content' => 'dashboard/dashboard_view',
				'user_type' => $user_type
			);
			$this->load->view('template', $data);
		}else{
			redirect('auth/restricted');
		}
	}
	
	public function no_deposits(){
		if($this->session->userdata('is_logged_in')){
			$email = $this->session->userdata('email');
			$user_type = $this->session->userdata('user_type');
			$data = array(
				'title' => "Member Dashboard",
				'email' => $email,
				'is_logged_in' => true,
				'content' => 'dashboard/view_deposits',
				'user_type' => $user_type
			);
			$this->load->model('model_users');
			$user_id = $this->model_users->get_user_id($email);
			$data['user_data'] = $this->model_users->get_deposit_list($user_id); //list of deposits for member
				
			$data['user_deposit_count'] = $this->model_users->get_deposit_row_count($user_id); //total number of deposits for member
				
			$data['deposit_amount'] = $this->model_users->get_deposit_total($user_id);
			$data['deposit_savings'] = $this->model_users->get_deposit_savings($user_id);
			$data['deposit_shares'] = $this->model_users->get_deposit_shares($user_id);
				
			$this->load->view('template', $data);
			
		}else{
			redirect('auth/restricted');
		}
	}
	
	public function deposits(){
		if($this->session->userdata('is_logged_in')){
			$member_id = $this->session->userdata('member_id');
			$user_type = $this->session->userdata('user_type');
			
			$data = array(
				'title' => "Member Dashboard",
				'member_id' => $member_id,
				'is_logged_in' => true,
				'content' => 'dashboard/view_deposits',
				'user_type' => $user_type
			);
			$this->load->model('model_users');
			$user_id = $this->model_users->get_user_id($member_id);
			if($data['user_data'] = $this->model_users->get_deposit_list($user_id)){ //list of deposits for member
				
				$data['user_deposit_count'] = $this->model_users->get_deposit_row_count($user_id); //total number of deposits for member
				
				$data['deposit_amount'] = $this->model_users->get_deposit_total($user_id);
				$data['deposit_savings'] = $this->model_users->get_deposit_savings($user_id);
				$data['deposit_shares'] = $this->model_users->get_deposit_shares($user_id);
				
				$this->load->view('template', $data);
				
			}else{
				$message = "<div class='alert alert-danger'> 'No records found!</div>";
				$this->session->set_flashdata("message", $message);
				redirect('member/no_deposits');
			}
			
		}else{
			redirect('auth/restricted');
		}
	}
	
	public function deposit_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'required|trim|callback_checkDepositFormat');
		$this->form_validation->set_rules('deposit_savings', 'Deposit Savings', 'trim|callback_checkDepositFormat');
		$this->form_validation->set_rules('deposit_shares', 'Deposit Shares', 'trim|callback_checkDepositFormat');
		$this->form_validation->set_rules('currency', 'Currency', 'required|trim');
		$this->form_validation->set_rules('pay_mode', 'Payment Mode', 'required|trim');
		$this->form_validation->set_rules('date', 'Date of Deposit', 'required|trim|callback_checkDateFormat');
		$this->form_validation->set_rules('receipt_upload', 'Receipt Upload', 'trim|callback_checkImageUpload');
		$this->form_validation->set_rules('comment', 'Comment', 'trim');
		
		if($this->form_validation->run()){
			if($path = $this->checkImageUpload()){
				$this->load->model('model_users');
				if($this->model_users->add_deposit($path)){
					$message = "<div class='alert alert-success'> Congratulations! Your deposit has been submitted successfully!</div>";
				}else{
					$message = "<div class='alert alert-danger'> 'Sorry! An error has occurred. Please try again!</div>";
				}
				//setting fals message to view!
				$this->session->set_flashdata("message", $message);
				redirect('member/dashboard');
			}else{
				$message = "<div class='alert alert-danger'> 'Sorry! Error uploading Receipt!</div>";
				$this->session->set_flashdata("message", $message);
				redirect('member/dashboard');
			}

		}else{
			$this->dashboard();
		}
	}
	
	public function delete_record(){
		$reference_id = $this->uri->segment(3);
		$this->load->model('model_users');
		if($this->model_users->delete_record($reference_id)){
			$message = "<div class='alert alert-success'> 'The record with REFERENCE ID ".$reference_id." has been successfully deleted!</div>";
			$this->session->set_flashdata("message", $message);
			redirect('member/deposits');
		}else{
			$message = "<div class='alert alert-danger'> 'An error has occurred. Could not delete record!</div>";
			$this->session->set_flashdata("message", $message);
			redirect('member/deposits');
		}	
	}
	
	public function edit_deposit(){
		if($this->session->userdata('is_logged_in')){
			$member_id = $this->session->userdata('member_id');
			$user_type = $this->session->userdata('user_type');
			$reference_id = $this->uri->segment(3);
			$data = array(
					'title' => "Member Dashboard",
					'member_id' => $member_id,
					'is_logged_in' => true,
					'content' => 'dashboard/edit_deposit',
					'user_type' => $user_type
				);
				
			$this->load->model('model_users');
			if($record = $this->model_users->get_record_data($reference_id)){
				$data['record'] = $record;
				$this->load->view('template', $data);
			}else{
				$this->deposits();
			}
		}
	}
	
	public function edit_deposit_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'required|trim|callback_checkDepositFormat');
		$this->form_validation->set_rules('deposit_savings', 'Deposit Savings', 'trim|callback_checkDepositFormat');
		$this->form_validation->set_rules('deposit_shares', 'Deposit Shares', 'trim|callback_checkDepositFormat');
		$this->form_validation->set_rules('currency', 'Currency', 'required|trim');
		$this->form_validation->set_rules('pay_mode', 'Payment Mode', 'required|trim');
		$this->form_validation->set_rules('date', 'Date of Deposit', 'required|trim|callback_checkDateFormat');
		$this->form_validation->set_rules('receipt_upload', 'Receipt Upload', 'trim|callback_checkImageUpload');
		$this->form_validation->set_rules('comment', 'Comment', 'trim');
		
		if($this->form_validation->run()){
			$id = $this->input->post('reference_id');
			if($path = $this->checkImageUpload()){
				$this->load->model('model_users');
				if($path == 1){
					$path = $this->model_users->get_receipt_path($id);
				}
				if($this->model_users->edit_deposit($id, $path)){
					$message = "<div class='alert alert-success'> Congratulations! Record update successful!</div>";
				}else{
					$message = "<div class='alert alert-danger'> 'Sorry! An error has occurred. Please try again!</div>";
				}
				//setting fals message to view!
				$this->session->set_flashdata("message", $message);
				redirect('member/deposits');
			}else{
				$message = "<div class='alert alert-danger'> 'Sorry! Error uploading Receipt!</div>";
				$this->session->set_flashdata("message", $message);
				redirect('member/edit_deposit');
			}
		}
	}
	
	public function total_deposits(){
		$this->load->model('model_users');
		$email = $this->session->userdata('email');
		$user_id = $this->model_users->get_user_id($email);
		$user_amount = $this->model_users->get_deposit_total($user_id);
		return $user_amount;
	}
	
	public function member_list(){
		if($this->session->userdata('is_logged_in')){
			$this->load->model('model_users');
			if($user = $this->model_users->get_member_list()){
				$member_id = $this->session->userdata('member_id');
			    $user_type = $this->session->userdata('user_type');
				$data = array(
					'title' => "Member Dashboard",
					'member_id' => $member_id,
					'is_logged_in' => true,
					'content' => 'dashboard/member_list',
					'user_type' => $user_type
				);
				$data['user'] = $user;
				$this->load->view('template', $data);
			}else{
				echo "error no list";
			}
		}else{
			redirect('auth/restricted');
		}
	}
	
	public function add_member(){
		if($this->session->userdata('is_logged_in')){
			
			$member_id = $this->session->userdata('member_id');
			$user_type = $this->session->userdata('user_type');
			
			//get new member id
			$this->load->model('model_users');
			if($id = $this->model_users->get_member_id()){
				if($new_member_id = $this->model_users->new_member_id($id)){
					$member_id = $this->session->userdata('member_id');
					$user_type = $this->session->userdata('user_type');
					$data = array(
						'title' => "Add Member",
						'$member_id' => $member_id,
						'is_logged_in' => true,
						'content' => 'dashboard/add_member',
						'user_type' => $user_type,
						'new_id' => $new_member_id,
					);
					$this->load->view('template', $data);
				}else{
					echo "failed to get new id";
				}
			}else{
				echo "failed to add member";
			}
		}else{
			redirect('auth/restricted');
		}
		
	}
	
	public function add_member_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('email', 'Email', 'trim|callback_checkEmailFormat');
		
		if($this->form_validation->run()){
			$this->load->model('model_users');
			if($this->model_users->add_member()){ //adds member login information
				if($this->model_users->add_member_details()){ //adds member details
					$message = "<div class='alert alert-success'> Congratulations! Member added successfully!</div>";
				}else{
					$message = "<div class='alert alert-danger'> 'Sorry! An error has occurred. Please try again!</div>";
				}
				$this->session->set_flashdata("message", $message);
				redirect('member/member_list');
			}else{
				echo "failed to add member login details";
			}
		}else{
			$this->add_member();
		}	
	}
	
	public function edit_member(){
		if($this->session->userdata('is_logged_in')){
			$member_id = $this->session->userdata('member_id');
			$user_type = $this->session->userdata('user_type');
			$id = $this->uri->segment(3);
			$data = array(
					'title' => "Member Dashboard - Edit",
					'member_id' => $member_id,
					'is_logged_in' => true,
					'content' => 'dashboard/edit_member',
					'user_type' => $user_type
				);
				
			$this->load->model('model_users');
			if($record = $this->model_users->get_member_data($id)){
				$data['record'] = $record;
				$this->load->view('template', $data);
			}else{
				$this->member_list();
			}
		}
		
	}
	
	public function edit_member_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('email', 'Email', 'trim|callback_checkEmailFormat');
		
		if($this->form_validation->run()){
			$id = $this->input->post('member_id');
			$this->load->model('model_users');
			if($this->model_users->edit_member($id) || $this->model_users->edit_user_type($id)){
				$message = "<div class='alert alert-success'> Congratulations! Record update successful!</div>";
			}else{
				$message = "<div class='alert alert-danger'> 'Sorry! An error has occurred. Please try again!</div>";
			}
			//setting fals message to view!
			$this->session->set_flashdata("message", $message);
			redirect('member/member_list');
		}else{
			
			redirect('member/edit_member');
		}
	}
	
	public function delete_member(){
		$member_id = $this->uri->segment(3);
		$this->load->model('model_users');
		if($this->model_users->delete_member($member_id)){
			$message = "<div class='alert alert-success'> 'The member with MEMBER ID ".$member_id." has been successfully deleted!</div>";
			$this->session->set_flashdata("message", $message);
			redirect('member/member_list');
		}else{
			$message = "<div class='alert alert-danger'> 'An error has occurred. Could not delete record!</div>";
			$this->session->set_flashdata("message", $message);
			redirect('member/member_list');
		}
	}
	
	function pdf()
	{
		$this->load->helper('pdf_helper');
		/*
			---- ---- ---- ----
			your code here
			---- ---- ---- ----
		*/
		$member_id = $this->session->userdata('member_id');
		$user_type = $this->session->userdata('user_type');
		$reference_id = $this->uri->segment(3);
		$data = array(
			'title' => "Member Dashboard",
			'member_id' => $member_id,
			'is_logged_in' => true,
			'content' => 'dashboard/edit_deposit',
			'user_type' => $user_type,
			'reference_id' => $reference_id
		);
		$this->load->model('model_users');
		if($record = $this->model_users->get_record_data($reference_id)){
			$data['record'] = $record;
			$this->load->view('dashboard/template', $data);
		}else{
			echo "Error";
		}		
	}
	
	public function checkDepositFormat($deposit){
		if(preg_match("/^[0-9]+(?:\.[0-9]+)?$/", $deposit)){
			return true;
		}else{
		$this->form_validation->set_message('checkDepositFormat', 'Sorry! Deposit Amount is invalid!');
		return false;
		}
	}
	
	public function checkDateFormat($date){
		if (preg_match("/^\d{1,2}\/\d{1,2}\/\d{4}$/", $date)) {
			if(checkdate(substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4))){
				return true;
			}else{
				return false;
			}				
		} else {
		$this->form_validation->set_message('checkDateFormat', 'Sorry! Date is invalid!');
		return false;
		}
	}
	
	public function checkImageUpload(){
		if($_FILES['receipt_upload']['size'] != 0){
		$upload_dir = './assets/receipts/';
			if (!is_dir($upload_dir)) {
				mkdir($upload_dir);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = 'receipt_upload_'.substr(md5(rand()),0,7);
			$config['overwrite']     = false;
			$config['max_size']  = '5120';
		 	
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('receipt_upload')){
				$this->form_validation->set_message('checkImageUpload', $this->upload->display_errors());
        return false;
			}else{
				$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
				$file_name = $upload_data['file_name'];
				return $file_name;  //returns the file name and extension uploaded.
			} 
		}//else{
			//$this->form_validation->set_message('checkImageUpload', 'Sorry! Reciept upload error!');
			//return false;
		//}
		return true;
	}
	
	public function checkEmailFormat($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}else{
			$this->form_validation->set_message('checkEmailFormat', 'Error! Email has invalid format.');
			return false;
		}
	}
	
}