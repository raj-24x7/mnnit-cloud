<?php

	session_start();
	require_once('checksession.php');
	require_once('db_connect.php');
	

		$db = getDBConnection();
	if(isset($_POST['new_password'])){
		if($_POST['new_password']!==$_POST['confirm_password']){
			$l = logError("1504");
            $l[0]->log($l[1]);
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
		notifyUser($_SESSION['username'], "PASSWD", " Your Password Changed Successfully");
		header("location:success.php?id=1501");
		die();	
	} else {
		$l = logError("1002");
        $l[0]->log($l[1]);
		header("location:error.php?error=1002");
		die();
	}
?>