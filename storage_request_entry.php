<?php
	session_start();

	require_once('checksession.php');
	require_once('db_connect.php');

	if(isset($_POST) && !empty($_POST)){
		$username = $_SESSION['username'];
		$alloted_space = getAllotedUserStorage();
		$new_demand = getMemoryFromString($_POST['new_demand']." ".$_POST['unit']);
		$status = "pending";

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

	


  function getMemoryFromString($data){
    $new_data = explode(" ", $data);
   // echo $data." ".$new_data[0];
    $size = array("KiB", "MiB", "GiB", "TiB");
    $index = array_search($new_data[1], $size);
    return (int)$new_data[0]*pow(1024, $index);
  }
?>