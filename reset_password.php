<?php
	session_start();
	require_once('logging.php');
	require_once('db_connect.php');

	if(!isset($_SESSION['username']) && empty($_SESSION['username'])){
		if(isset($_GET['username'])&&!empty($_GET['username'])){
			$username = $_GET['username'];
			$token = $_GET['token'];

			$query = "SELECT `timestamp` FROM `forgot_password` WHERE `username`=:username AND `token`=:token";
			$param = array(
					":username"=>$username,
					":token"=>$token
				);
			$stmt = prepareQuery(getDBConnection(),$query);
			if(!executeQuery($stmt, $param)){
				header("location:error.php?error=1104");
				die();
			}

			if($row=$stmt->fetch()){
				if(time() - $row['timestamp'] < 3*3600){
					$_SESSION['username']=$username;
					$_SESSION['privilege']='U';
				}else {
					header("location:error.php?error=1502");
					die();
				}
			}else{
				header("location:error.php?error=1503");
				die();
			}
		}else{
			header("location:error.php?error=1503");
			die();
		}
	}
	require_once('checksession.php');
	require_once("header.php");
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
	
	</div>
	<div class="col-sm-8">
	
		
		
		<br>
		<br>
		<br>
		<div class="panel">
			<div class="panel-heading">
				<div class="col-sm-4"> Change Password </div>
			</div>
					<form name="change_password" class="form-horizontal" method="POST" action="change_password.php">
						<div class="form-group">
							<label class="control-label  col-sm-3">New Password:  </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="new_password" name="new_password" >
							</div>
						</div>

						<div class="form-group">
							<label class="control-label  col-sm-3">Confirm Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="confirm_password" name="confirm_password" >
							</div>
						</div>

						<div class="form-group">
							<center><input type="submit" name="submit" class="btn btn-info" value="Submit" ></center>
						</div>
					</form>
			</div>
	</div>
	<div class="col-sm-1"></div>
</div>