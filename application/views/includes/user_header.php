<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Uganda Goat Farmers Cooperative Society">
    <meta name="author" content="itcorp ict for business">
    <link rel="icon" href="<?php echo base_url(); ?>favicon.png" type="image/png">

    <title><?php echo $title;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    
    <!--Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Duru+Sans|Actor' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    
    <!--Bootshape-->
    <link href="<?php //echo base_url(); ?>assets/css/bootshape.css" rel="stylesheet">
	 
	  <!--Custom CSS-->
	 <link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet">
	 <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
	 <link href="<?php echo base_url(); ?>assets/css/form.css" rel="stylesheet">
   
  </head>

<?php
if($is_logged_in == TRUE){
?>
<body id="dashboard">
<nav class="navbar-inverse navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><span><img alt="Brand" src="<?php echo base_url(); ?>assets/img/logo.png" width="55px" height="50px"></span> 
			<!-- Uganda Goat Farmers Cooperative Society (UGFCS) -->
			</a>
			
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">	
      <ul class="nav navbar-nav navbar-right">
      	<li role="presentation" class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			      Action Center <span class="caret"></span></a>
			    <ul class="dropdown-menu">
			      <li><a href="<?php echo base_url(); ?>member/dashboard"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Make Deposit <span class="sr-only">(current)</span></a></li>
						<li><a href="<?php echo base_url(); ?>member/deposits"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> View Deposits</a></li>
						
						<?php if($user_type == 'admin'){?>
						<li><a href="<?php echo base_url(); ?>member/member_list"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Members</a></li>
            <li><a href="<?php echo base_url(); ?>auth/members"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a></li>
						<?php } ?>
						
						<li><a href="<?php echo base_url(); ?>auth/members"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> Help</a></li>
			    </ul>
		   	</li>
				<li>
		       <a href=""><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
				</li>
		   	<li>
		   		<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			      <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
			    <ul class="dropdown-menu">
		        <li>
		        <a href="<?php echo base_url(); ?>auth/logout">Logout (<?php echo 'Member ID: '.$member_id. '-' .$user_type ; ?>)</a>
						</li>
			    </ul>
		   	</li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php
}		
?>
<div class="container-fluid">
  <div class="row">

