<?php

class Model_users extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		
	}
	
	public function can_log_in(){
		$this->db->where('member_id', $this->input->post('member_id'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('member_login');
		
		return ($query->num_rows() == 1) ? true : false;
	}
	
	public function get_member_id(){
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('member_login');
		if($query->num_rows() == 1){
			$row = $query->row();
			return $row->id;
		}else{
			return false;
		}		
	}
	
	public function add_member(){
		$data = array(
			'member_id' => $this->input->post('member_id'),
			'password' => $this->generate_password(),
		);
		$query = $this->db->insert('member_login', $data);
		if($query){
			return true;
		}else return false;
	}
	
	public function add_member_details(){
		$data = array(
			'member_id' => $this->input->post('member_id'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'phone_number' => $this->input->post('phone_number'),
			'email' => $this->input->post('email'),
		);
		$query = $this->db->insert('member_details', $data);
		if($query){
			return true;
		}else return false;
	}
	
	public function generate_password($length = 8){
		//code that generates random password
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}

		return $result;
	}
	
	public function new_member_id($id){
		$this->db->where('id',$id);
		$query = $this->db->get('member_login');
		
		if($query->num_rows() == 1){
			$row = $query->row();
			$new_member_id = ($row->member_id)+1;
			$data = array(
				'member_id' => $new_member_id,
			);
			return $data['member_id'];
		}else{
			return false;
		}
		
	}
	
	public function email_exists($email){
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		
		return ($query->num_rows() == 1) ? true : false;
	}
	
	public function update_reset_key($reset_key){
		$email = $this->input->post('email');
		$this->db->where('email',$email);
		$query = $this->db->get('member_details');
		
		if($query->num_rows() == 1){
			$row = $query->row();
			$data = array(
				'member_id' => $row->member_id,
			);
			
			$this->db->where('member_id',$data['member_id']);
			$r = array(
				'reset_password_key' => $reset_key,
			);
			
			$this->db->update('member_login',$r);
			return ($this->db->affected_rows() > 0) ? true : false;
		}else{
			return false;
		}	
		
	}
	public function reset_password(){
		$reset_key = $this->input->post('reset_key');
		$password = md5($this->input->post('password'));
		
		$this->db->where('reset_password_key', $reset_key);
		$data = array(
			'password' => $password,
		);
		$this->db->update('users', $data);
		
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function get_user_type($member_id){
		$this->db->where('member_id',$member_id);
		$query = $this->db->get('member_login');
		
		if($query->num_rows() == 1){
			$row = $query->row();
			$data = array(
				'type' => $row->account_type,
			);
			return $data['type'];
		}else{
			return false;
		}
	}
	
	//Fucntion that creates member ID by incrementing last entry by 1
	
	public function add_deposit($path){
		$member_id = $this->session->userdata('member_id');
		if($member_id = $this->get_user_id($member_id)){

			$data = array(
			'reference_id' => mt_rand(),
			'amount' => $this->input->post('deposit_amount'),
			'savings' => $this->input->post('deposit_savings'),
			'shares' => $this->input->post('deposit_shares'),
			'currency_id' => $this->input->post('currency'),
			'payment_mode_id' => $this->input->post('pay_mode'),
			'deposit_date' => $this->input->post('date'),
			'receipt_upload' => $path,
			'comment' => $this->input->post('comment'),
			'verified' => false,
			'member_id' => $member_id,
		);
			
		$query = $this->db->insert('deposits',$data);
		if($query){
			return true;
		}else{
			return false;
		}
		}
	}
	
	public function get_user_id($member_id){
		$this->db->where('member_id',$member_id);
		$get_id = $this->db->get('member_details');
		if($get_id->num_rows() == 1){
			$row = $get_id->row();
			$data = array(
				'id' => $row->member_id,
			);
			return $data['id'];
		}else return false;
	}
	
	public function get_deposit_row_count($user_id){
		$this->db->where('member_id', $user_id);
		$query = $this->db->from('deposits');
		if($query){
			$data = array(
			'count' => $this->db->count_all_results(),
			);
			return $data['count'];
		}else{
			return false;
		}
	}
	
	public function get_deposit_total($user_id){
		$this->db->where('member_id', $user_id);
		$this->db->select_sum('amount' , 'Amount_Tot');
		$query = $this->db->get('deposits');
		$result = $query->result();
		if($result){
			return $result[0]->Amount_Tot;
		}else{
			return false;
		}
		
	}
	
	public function get_deposit_savings($user_id){
		$this->db->where('member_id', $user_id);
		$this->db->select_sum('savings' , 'Savings_Tot');
		$query = $this->db->get('deposits');
		$result = $query->result();
		if($result){
			return $result[0]->Savings_Tot;
		}else{
			return false;
		}
		
	}
	
	public function get_deposit_shares($user_id){
		$this->db->where('member_id', $user_id);
		$this->db->select_sum('shares' , 'Shares_Tot');
		$query = $this->db->get('deposits');
		$result = $query->result();
		if($result){
			return $result[0]->Shares_Tot;
		}else{
			return false;
		}
		
	}
	
	public function get_deposit_list($user_id){
		$this->db->where('member_id',$user_id);
		$this->db->order_by('curr_date_time','ASC');
		$query = $this->db->get('deposits');
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function delete_record($reference_id){
		$this->db->where('reference_id',$reference_id);
		$query = $this->db->delete('deposits');
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function get_record_data($reference_id){
		$this->db->where('reference_id',$reference_id);
		$query = $this->db->get('deposits');
		if($query->num_rows() == 1){
			$data = [];
			$row = $query->row();
			$data = array(
				'id' => $row->id,
				'reference_id' => $row->reference_id,
				'amount' => $row->amount,
				'savings' => $row->savings,
				'shares' => $row->shares,
				'currency_id' => $row->currency_id,
				'payment_mode_id' => $row->payment_mode_id,
				'deposit_date' => $row->deposit_date,
				'receipt_upload' => $row->receipt_upload,
				'comment' => $row->comment,
				'verified' => $row->verified,
				'user_id' => $row->member_id,
			);
			return $data;
		}else{
			return false;
		}
	}
	
	public function edit_deposit($id, $path){

		$data = array(
			'id' => $this->input->post('id'),
			'reference_id' => $this->input->post('reference_id'),
			'amount' => $this->input->post('deposit_amount'),
			'savings' => $this->input->post('deposit_savings'),
			'shares' => $this->input->post('deposit_shares'),
			'currency_id' => $this->input->post('currency'),
			'payment_mode_id' => $this->input->post('pay_mode'),
			'deposit_date' => $this->input->post('date'),
			'receipt_upload' => $path,
			'comment' => $this->input->post('comment'),
			'verified' => $this->input->post('verified'),
			'member_id' => $this->input->post('user_id'),
		);
		$this->db->where('reference_id',$id);
		$this->db->update('deposits', $data);
		
		return ($this->db->affected_rows() > 0) ? true : false;
		
	}
	
	public function get_receipt_path($id){
		$this->db->where('reference_id',$id);
		$query = $this->db->get('deposits');
		
		if($query->num_rows() == 1){
			$row = $query->row();
			$data = array(
				'receipt_upload' => $row->receipt_upload,
			);
			return $data['receipt_upload'];
		}else return false;
	}
	
	public function get_member_list(){
		$this->db->order_by('date_created','DESC');
		$query = $this->db->get('member_details');
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function delete_member_login($member_id){
		$this->db->where('member_id', $member_id);
		$query = $this->db->delete('member_login');
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function delete_member($member_id){
		if($this->delete_member_login($member_id)){
			$this->db->where('member_id', $member_id);
			$query = $this->db->delete('member_details');
			return ($this->db->affected_rows() > 0) ? true : false;
		}else {
			return false;
		}
	}
	
	public function get_member_data($id){
		$this->db->where('member_id',$id);
		$query = $this->db->get('member_details');
		if($query->num_rows() == 1){
			$data = []; //returns an empty array 
			$row = $query->row();
			$data = array(
				'id' => $row->id,
				'member_id' => $row->member_id,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'phone_number' => $row->phone_number,
				'email' => $row->email,
			);
			return $data;
		}else{
			return false;
		}
	}
	
	public function edit_member($id){		
		$data = array(
			'id' => $this->input->post('id'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'phone_number' => $this->input->post('phone_number'),
			'member_id' => $this->input->post('member_id'),
		);
		$this->db->where('member_id',$id);
		$this->db->update('member_details', $data);
		
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	public function edit_user_type($id){
		$data = array(
			'account_type' => $this->input->post('user_type'),
		);
		$this->db->where('member_id', $id);
		$this->db->update('member_login',$data);
		
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	
	
}