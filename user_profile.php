<?php
	session_start();
	require "checksession.php";
	require "db_connect.php";
	require "header.php";
  require_once('logging.php');
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
		<?php include "navigation_bar.php";?>
	</div>
	<div class="col-sm-8">
		<div class="panel panel-info">
			<div class="panel panel-heading">
				<center><h2><strong><?php echo $_SESSION['username'];?></strong></h2></center>
			<div>	
			<div class="panel panel-body">
				<a class="btn btn-info" href="reset_password.php">Change Password</a>
				<form class="form-control">
					
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>