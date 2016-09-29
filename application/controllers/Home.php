<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This is the main page default controller.

/**
 * 
 */
class home extends CI_Controller {
	
	public function index(){
		$data['title'] = "Uganda Goat Farmers Cooperative Society";
		$this->load->view('includes/header', $data);
		//$this->load->view('slide');
		$this->load->view('home');
		$this->load->view('includes/footer');
	}
	
}
