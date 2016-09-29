<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container" class="container">
	<div class="form-page">
		<div class="form">
			<a href="<?php echo base_url(); ?>auth/"><img alt="Brand" src="<?php echo base_url(); ?>assets/img/logo.png" width="100px" height="100px"> </a>
			<h1>Reset Password!</h1>
			<?php
			$reset_key = $this->uri->segment(3);
			echo validation_errors();

			echo form_open('auth/password_validation');
			
			echo form_hidden('reset_key',set_value('reset_key',$reset_key));
			
			echo '<p> Password';
			echo form_password('password');
			echo '</p>';

			echo '<p> Confirm Password';
			echo form_password('cpassword');
			echo '</p>';

			echo '<p>';
			$attributes = array(
				'style' => "background: #4CAF50",
				'class' => "button_form",
			);
			echo form_submit('password_submit', 'Reset Password!',$attributes);
			echo '</p>';

			echo form_close();

			?>
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
