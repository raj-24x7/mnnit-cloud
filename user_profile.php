<?php
	session_start();
	require "checksession.php";
	require "db_connect.php";

	$db = getDBConnection();
	if(isset($_POST['old_password'])){
		$sql = "SELECT  * FROM `user` WHERE password=:password AND username=:username";
		$param = array(
				":password"=>md5($_POST['old_password']),
				":username"=>$_SESSION['username']
			);
		$stmt = prepareQuery($db,$sql);
		executeQuery($stmt,$param);
		$row = $stmt->fetch();
		if(!$row){
			header("location:user_profile.php?err=1");
		} else {
			$sql = "UPDATE `user` SET password=:password WHERE username=:username";
			$param = array(
				":username"=>$_SESSION['username'],
				":password"=>md5($_POST['new_password'])
				);
			$stmt = prepareQuery($db,$sql);
			executeQuery($stmt,$param);
			header("location:user_profile.php");
		}

	}

	require "header.php";
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
		<?php include "navigation_bar.php";?>
	</div>
	<div class="col-sm-8">
		<!-- Your Code Goes Here -->
		<?php 
			if(isset($_GET['err'])){
		?>

		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4>The Old Password did not match !</h4>
			</div>
		</div>
		<?php } ?>
		<div class="">
		<br>
			<h2><strong><?php echo $_SESSION['username'];?></strong></h2>
		<br>	
		</div>
		<!-- Collapse Controller header-->
		<div class="panel">
			<div class="panel-heading">
				<div class="col-sm-4"> Change Password ***</div>
				<a class="glyphicon glyphicon-plus" data-toggle="collapse" href="#fill-collapse"></a>
			</div>
			<!-- Collapsible Panel -->
			<div id="fill-collapse" class="panel-collapse collapse">
				<div class="panel-body">
					<form name="change_password" class="form-horizontal" method="POST" action="user_profile.php">
						<div class="form-group">
							<label class="control-label  col-sm-3">Old Password:  </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="old_password" name="old_password" >
							</div>
						</div>

						<div class="form-group">
							<label class="control-label  col-sm-3">New Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="new_password" name="new_password" >
							</div>
						</div>

						<div class="form-group">
							<center><input type="submit" name="submit" class="btn btn-info" value="Submit" ></center>
						</div>
					</form>
				</div>
            </div>               
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>