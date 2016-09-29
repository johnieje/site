<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container" class="container">
	<div class="form-page">
		<div class="form">
			<a href="<?php echo base_url(); ?>auth/"><img alt="Brand" src="<?php echo base_url(); ?>assets/img/logo.png" width="100px" height="100px"> </a>
			<h1>You do not have access to this page!</h1>
			<a href="<?php echo base_url(). "auth/login"?>"><div class="button">
				Login
				</div></a>
			<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
		</div>
	</div>
</div>
</body>
</html>