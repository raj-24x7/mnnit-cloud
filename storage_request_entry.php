<?php
	session_start();

	require_once('checksession.php');
	require_once('db_connect.php');

	if(isset($_POST) && !empty($_POST)){
		$username = $_SESSION['username'];
		$alloted_space = getAllotedUserStorage();
		$new_demand = getMemoryFromString($_POST['new_demand']." ".$_POST['unit']);
		$status = "pending";

		if($new_demand < getUsedSpace($username)){
			header("location:error.php?error=1702");
			die();
		}

		$db = getDBConnection();
		$query = "INSERT INTO `storage_request` VALUES (:username,:alloted_space,:new_demand,'',:status)";
		$param = array(
			":username"=>$username,
			":alloted_space"=>$alloted_space,
			":new_demand"=>$new_demand,
			":status"=>$status
			);		
		$stmt = prepareQuery($db, $query);
		if(!ExecuteQuery($stmt, $param)){
			header("location:error.php?error=1104");
			die();
		} else {
			header("location:pending_details.php");
		}

	} else {
		header("location:error.php?error=1601");
		die();
	}

?>