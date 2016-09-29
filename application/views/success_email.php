<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container" class="container">
	<div class="form-page">
		<div class="form">
			<a href="<?php echo base_url(); ?>auth/"><img alt="Brand" src="<?php echo base_url(); ?>assets/img/logo.png" width="100px" height="100px"> </a>
			<h1>Confirm Email!</h1>
			<p class="alert alert-success">A cofirmation email has been sent to your emaill address. Please check your ermail to complete your account activation.</p>
			<p class="message">Back to <a href="<?php echo base_url(); ?>auth/login">Login!</a></p>
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
