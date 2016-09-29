<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container" class="container">
	<div class="form-page">
		<div class="form">
			<a href="<?php echo base_url(); ?>auth/"><img alt="Brand" src="<?php echo base_url(); ?>assets/img/logo.png" width="100px" height="100px"> </a>
			<?php echo $this->session->flashdata('message')?>
			<h1>Login!</h1>
			<?php
			echo form_open('auth/login_validation','class ="login-form"');
		
			echo validation_errors('<div class="alert alert-danger">', '</div>');
			
			echo '<p> Member ID ';
			echo form_input('member_id', $this->input->post('member_id'));
			echo '</p>';
			
			echo '<p> Password ';
			echo form_password('password');
			echo '</p>';
			
			echo '<p>';
			$attributes = array(
				'style' => "background: #4CAF50",
				'class' => "button_form",
			);
			echo form_submit('login_submit','Login',$attributes);
			echo '</p>';
			
			echo form_close();
		?>
	<p class="message" id="message"><a href="<?php echo base_url(); ?>auth/recover_password">Forgot Password?</a></p>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
		</div>
	</div>
	
</div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- // <script src="https://code.jquery.com/jquery.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootshape.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
</body>
</html>
