<?php
	session_start();
	require_once "db_connect.php";
	if($_SESSION['privilege']!='A'){
		header("location:index.php");
	}

	$db = getDBConnection();

	if(isset($_GET['username'])){
		$sql = "DELETE FROM `user` WHERE username=:username";
		$param = array(
				":username"=>$_GET['username']
			);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			header("location:error.php?error=1108");
			die();
		}
		header("location:user_details.php");
	}

	

	require "header.php";
	$sql = "SELECT * FROM `user` WHERE privilege!='A'";
	$stmt = prepareQuery($db,$sql);
	executeQuery($stmt,array());

?>

<script type="text/javascript">
    window.onload = function (){
      document.getElementById("user_details").className = "active";

      var prevClass = document.getElementById("manage-collapse").className;
      document.getElementById("manage-collapse").className = prevClass+" in";
    }
</script>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2">
		<?php include "navigation_bar.php";?>
	</div>
	<div class="col-sm-8">
	
		<br>
		<h4>Users : </h4>
		<div class="panel panel-default">
		<?php
			$c = 1;
			while($row = $stmt->fetch()){

		?>
				<div class="panel-heading">
                    <div class="col-sm-1"><?php echo $c."."; $c = $c + 1;?></div>
                    <div class="col-sm-5"><?php echo $row['username'];?></div>
                    <div class="col-sm-5"><?php echo $row['privilege'];?></div>
                    <a class="glyphicon glyphicon-minus " style="color: red;" href="user_details.php?username=<?php echo $row['username'];?>"></a>
                </div>
			

		<?php 	}
		?>
		</div>
		<div class="panel">
			<div class="panel-heading">
				<div class="col-sm-2"> Add More ...</div>
				<a class="glyphicon glyphicon-plus" data-toggle="collapse" href="#fill-collapse"></a>
			</div>
			<div id="fill-collapse" class="panel-collapse collapse">
				<div class="panel-body">
					<form name="user_details" class="form-horizontal" method="POST" action="user_details.php">
						<div class="form-group">
							<label class="control-label  col-sm-3">Username :  </label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="username" name="username" >
							</div>
						</div>

						<div class="form-group">
							<label class="control-label  col-sm-3">Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" id="password" name="password" >
							</div>
						</div>

						<div class="form-group">
							<label class="control-label  col-sm-3">Privilege : </label>
							<div class="col-sm-5">
								<select class="form-control" name="privilege" id="privilege"> 
									<option value="U">User</option>
									<option value="A">Admin</option>
								</select>
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