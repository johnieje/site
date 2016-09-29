<?php


$this->load->view('includes/user_header', $content);
$this->load->view('side_menu');
$this->load->view($content);
$this->load->view('includes/user_footer', $content);
