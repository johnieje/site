<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Members page - CI Authentication</title>
</head>
<body>

<div id="container">
	<h1>Members!</h1>
	
	<?php
	echo '<pre>';
	print_r($this->session->all_userdata());
	echo '</pre>';
	?>
	<a href="<?php echo base_url(). "auth/logout"?>">Logout</a>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
</div>

</body>
</html>