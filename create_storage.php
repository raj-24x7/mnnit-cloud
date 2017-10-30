<?php 
	session_start();

	require_once('checksession.php');
	require_once('db_connect.php');
	require_once('ssh.php');

	if($_SESSION['privilege']!=='A'){
		header("location:error.php?error=1002");
	}

	if(isset($_POST)){

		if($_POST['button']==='Reject'){
			// For Rejected Requests
			//die("hello");
			$db = getDBConnection();
			$query = "UPDATE `storage_request` SET `status`='Rejected' WHERE `username`=:username";
			$stmt = prepareQuery($db, $query);
			if(!executeQuery($stmt, array(":username"=>$_POST['username']))){
				header("location:error.php?error=1106");
			}
		} else if($_POST['button']==='Approve') {
			// For Approved Requests

			$username = $_POST['username'];
			$storage_server = $_POST['storage_server'];
			$alloted_space = getMemoryFromString($_POST['alloted_space']);
			$new_demand = getMemoryFromString($_POST['new_demand']);

			
			if($new_demand < getUsedSpace($username)){
				header("location:error.php?error=1702");
				die();
			}
			
			if(getTotalSpaceOn($storage_server) - getUsedSpaceOn($storage_server) <= $new_demand - $alloted_space){
				header("location:error.php?error=1701");
				die();
			}

			if(doesUserExists($username, $storage_server)){
				setQuota($storage_server, $username, $new_demand);
				$db = getDBConnection();
				$query = "UPDATE `user_storage` SET `alloted_space`=:alloted_space WHERE `username`=:username AND `storage_server`=:storage_server";
				$stmt = prepareQuery($db, $query);
				$param = array(
					":alloted_space"=>$new_demand,
					":username"=>$username,
					":storage_server"=>$storage_server,
					);
				if(!executeQuery($stmt, $param)){
					header("location:error.php?error=1104");
				}
			} else {
				$password = generateRandomString();
				createNewLinuxUser($username, $storage_server, $password);
				setQuota($storage_server, $username, $new_demand);
				$db = getDBConnection();
				$query = "INSERT INTO `user_storage` VALUES (:username,:storage_server,:alloted_space,:used_space,:login_password)";
				$stmt = prepareQuery($db, $query);
				$param = array(
					":username"=>$username,
					":storage_server"=>$storage_server,
					":alloted_space"=>$new_demand,
					":used_space"=>0,
					":login_password"=>$password
					);
				if(!executeQuery($stmt, $param)){
					header("location:error.php?error=1104");
				}
				
			shell_exec("mkdir files/".$username);
			shell_exec("chmod a+rwx files/".$username);

			}

			
			$space_new = getUsedSpaceOn($storage_server) + $new_demand - $alloted_space;
			setUsedSpaceOn($storage_server, $space_new); 

			$db = getDBConnection();
			$query = "DELETE FROM `storage_request` WHERE `username`=:username";
			$stmt = prepareQuery($db, $query);
			executeQuery($stmt, array(":username"=>$username));

		} else {
			header('location:error.php?error=1601');
			die();
		}

	} else {
		header("location:error.php?error=1601");
		die();
	}

	header("location:user_storage.php");


  
?>