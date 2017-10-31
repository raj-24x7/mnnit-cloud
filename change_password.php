<?php
		$db = getDBConnection();
	if(isset($_POST['new_password'])){
		if($_POST['new_password']!==$_POST['confirm_password']){
			header("location:error.php?error=1504");
			die();
		}	
		$sql = "UPDATE `user` SET password=:password WHERE username=:username";
		$param = array(
			":username"=>$_SESSION['username'],
			":password"=>md5($_POST['new_password'])
			);
		$stmt = prepareQuery($db,$sql);
		executeQuery($stmt,$param);
		$sql = "UPDATE `new_user` SET password=:password WHERE username=:username";
		$param = array(
			":username"=>$_SESSION['username'],
			":password"=>md5($_POST['new_password'])
			);
		$stmt = prepareQuery($db,$sql);
		executeQuery($stmt,$param);
		header("location:error.php?error=1505");
		die();	
	} else {
		header("location:error.php?error=1002");
	}
?>