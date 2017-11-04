
<?php
	session_start();

	require_once('checksession.php');
	require_once('db_connect.php');
	require_once('logging.php');
	require_once('ssh.php');

	if(isset($_POST) && !empty($_POST)){
		$username = $_SESSION['username'];
		$alloted_space = getAllotedUserStorage();
		$new_demand = getMemoryFromString($_POST['new_demand']." ".$_POST['unit']);
		$status = "pending";

		if($new_demand < getUsedSpace($username)){
			$l = logError("1702");
            $l[0]->log($l[1]);
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
			$l = logError("1104");
            $l[0]->log($l[1]);
			header("location:error.php?error=1104");
			die();
		} else {
			logHadoopRequest($_SESSION['username']);
			header("location:pending_details.php");
			die();
		}

	} else {
		$l = logError("1601");
        $l[0]->log($l[1]);
		header("location:error.php?error=1601");
		die();
	}

?>