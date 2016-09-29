<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->login();
	}
	
	public function login(){
		$data = array(
			'title' => "Member Login Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('login');
	}
	
	public function confirm_email(){
		$data = array(
			'title' => "Member Email confirmation Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('success_email');
	}
	
	public function email_verified(){
		$data = array(
			'title' => "Member Email verification Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('verification_email');
	}
	
	public function members(){
		if($this->session->userdata('is_logged_in')){
			//$this->load->view('members');
			$email = $this->session->userdata('email');
			$data = array(
				'title' => "Member Profile",
				'email' => $email,
				'is_logged_in' => true,
				'content' => 'dashboard/dashboard_view',
			);
			$this->load->view('template', $data);
		}else{
			redirect('auth/restricted');
		}
	}
	
	public function restricted(){
		$data = array(
			'title' => "Restricted Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('restricted');
	}
	
	public function login_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('member_id', 'Member ID', 'required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
		
		if($this->form_validation->run()){
			//adding the user type
			$this->load->model('model_users');
			$member_id = $this->input->post('member_id');
			if($user_type = $this->model_users->get_user_type($member_id)){
				$data = array(
				'member_id' => $member_id,
				'is_logged_in' => 1,
				'user_type' => $user_type
				);
			
				$this->session->set_userdata($data);
				redirect('member/dashboard');
			}
			
		}else{
			$data = array(
				'title' => "Member Login Page",
				'is_logged_in' => false,
			);
			$this->load->view('includes/user_header',$data);
			$this->load->view('login');
		}	
	}
	
	public function signup_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
		
		$this->form_validation->set_message('is_unique','The email address already exists!');
		
		if($this->form_validation->run()){
			//generate a random key
			$key = md5(uniqid());
			
			//send email to user
			$this->load->library('email');
			$this->load->model('model_users');			

			//$this->email->initialize($config);
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			$this->email->from('john@itcorpug.com', 'UGFCS');
			$this->email->to($this->input->post('email'));
			$this->email->subject('UGFCS - Confirm Your Account Email');
			
			$message = "<p>Hello ".$this->input->post('email').",</p>";
			$message .= "<p>Thank you for signing up!</p>";
			$message .= "<p><a href='".base_url()."auth/register_user/$key'>Click here</a> to complete your registration.</p>";
			$message .= "<p>Thank you.</p>";
			$message .= "<p>UGFC Support Team</p>";
			
			$this->email->message($message);
			//add user to temp_user table in db
			if($this->model_users->add_temp_user($key)){
				if($this->email->send()){
					redirect('auth/confirm_email');
				}else{
					
					redirect('auth/signup');
				}
			}else{
				echo "User not added to temp db";
			}
			
		}else{
			
			$this->signup();
		}
	}
	
	public function validate_credentials(){
		$this->load->model('model_users');
		if($this->model_users->can_log_in()){
			return true;
		}else{
			$this->form_validation->set_message('validate_credentials', 'Incorrect Username or Password');
			return false;
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		$message = "<div class='alert alert-info'> 'You have logged out successfully!</div>";
		$this->session->set_flashdata("message", $message);
		redirect('auth/login');
	}
	
	public function register_user($key){
		$this->load->model('model_users');
		
		if($this->model_users->is_valid_key($key)){
			if($user_email = $this->model_users->add_user($key)){
				$data = array(
					'email' => $user_email,
					'is_logged_in' => 1
				);
				
				$this->session->set_userdata($data);
				redirect('auth/email_verified');
			}else{
				echo "Failed to add user. Please try again!";
			}
		}else{
			echo "invalid key";
		}
	}
	
	public function recover_password(){
		$data = array(
			'title' => "Recover password Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('recover_password');
	}
	
	public function recover_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		if($this->form_validation->run()){
			$this->load->model('model_users');
			$email = $this->input->post('email');
			if($this->model_users->email_exists($email)){
				$reset_key = md5(uniqid());
				if($this->model_users->update_reset_key($reset_key)){
				//send_recover_email() function goes here
					if($this->send_recover_email($reset_key)){
						$message = "<div class='alert alert-success'> Congratulations! Your password has been sent to your email!</div>";
					}else{
						$message = "<div class='alert alert-danger'> 'Sorry! An error has occurred. Please check confirm your email and try again!</div>";
					}
					//setting fals message to view!
					$this->session->set_flashdata("message", $message);
					redirect('auth/recover_password');
					}else{
						echo "Error updating key".$reset_key;
						$this->recover_password();
					}
			}else{
				$message = "<div class='alert alert-danger'> 'Sorry! Email does not exist. Please check confirm your email and try again!</div>";
				$this->session->set_flashdata("message", $message);
				redirect('auth/recover_password');
				}
	}else{
			$this->recover_password();
		}
}

						 
	public function send_recover_email($reset_key){
		$this->load->library('email');
		$this->load->model('model_users');
		
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from('john@itcorpug.com', 'UGFCS');
		$this->email->to($this->input->post('email'));
		$this->email->subject('Reset Your Password - UGFCS.com');
		
		$message = "<p>Hello ".$this->input->post('email').",</p>";
		$message .= "<p>We got a request to reset your UGFCS password!</p>";
		$message .= "<p><a href='".base_url()."auth/reset_password/".$reset_key."'>Click here</a> to reset password.</p>";
		$message .= "<p>If you ignore this email, your password will not be changed.</p>";
		$message .= "<p>Feel free to contact us incase you need any assistance by replying to this email.</p>";
		$message .= "<p>Thank you.</p>";
		$message .= "<p>UGFC Support Team</p>";
		
		$this->email->message($message);
		if($this->email->send()){
			return true;
		}else{
			return false;
		}
	}
	
	public function reset_password(){
		$data = array(
			'title' => "Reset password Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('reset_password');
	}
	
	public function password_validation(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
		
		if($this->form_validation->run()){
			$this->load->model('model_users');
			if($this->model_users->reset_password()){
				$message = "<div class='alert alert-success'> 'Congratulations! Your password has been reset successfuly</div>";
				$this->session->set_flashdata("message", $message);
				redirect('auth/reset_password_success');
			}else{
				$message = "<div class='alert alert-danger'> 'Sorry! Your password has not been reset. Please try again.</div>";
				$this->session->set_flashdata("message", $message);
				redirect('auth/reset_password');
			}
		}else{
			$this->reset_password();
		}
	}
	
		
	public function reset_password_success(){
		$data = array(
			'title' => "Reset password successful Page",
			'is_logged_in' => false,
		);
		$this->load->view('includes/user_header',$data);
		$this->load->view('reset_password_success');
	}
}
