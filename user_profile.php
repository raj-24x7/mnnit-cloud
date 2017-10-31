<?php
	session_start();
	require "checksession.php";
	require "db_connect.php";
	require "header.php";
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
		<?php include "navigation_bar.php";?>
	</div>
	<div class="col-sm-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2><strong><?php echo $_SESSION['username'];?></strong></h2>
			<div>	
			<div class="panel-body">
				<div>
					<a class="btn btn-sm" href="reset_password.php">Change Password</a>
				</div>
				<form class="form-control">
					
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>