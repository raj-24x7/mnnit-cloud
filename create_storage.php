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


	function doesUserExists($username, $storage_server){

		$db = getDBConnection();
        $query = " 
            SELECT alloted_space,used_space FROM `user_storage` WHERE `username`=:username AND `storage_server`=:storage_server"; 
        $param = array(":username"=>$username, ":storage_server"=>$storage_server);
    

   		$stmt = prepareQuery($db,$query);
    	executeQuery($stmt,$param);
    	if($row=$stmt->fetch()){
    		return true;
    	}else{
    		return false;
    	}
	}

  function getMemoryString($data){
    $size = array("KiB", "MiB", "GiB", "TiB");
    $div = 1;
    $i = 0;
    while($data/$div >= 1024){
      $div = $div*1024;
      $i = $i + 1;
    }
    return round((float)$data/$div, 3)." ".$size[$i];
  }
  
  function getMemoryFromString($data){
    $new_data = explode(" ", $data);
    $size = array("KiB", "MiB", "GiB", "TiB");
    $index = array_search($new_data[1], $size);
    return (int)$new_data[0]*pow(1024, $index);
  }

  function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }


  function getUsedSpaceOn($storage_server){
  	$db = getDBConnection();
  	$query = "SELECT `used_space` FROM `storage_servers` WHERE `server_name`=:server_name";
  	$stmt = prepareQuery($db, $query);
  	executeQuery($stmt, array(":server_name"=>$storage_server));
  	$row = $stmt->fetch();

  	return $row['used_space']; 
  }

  function getTotalSpaceOn($storage_server){
  	$db = getDBConnection();
  	$query = "SELECT `total_space` FROM `storage_servers` WHERE `server_name`=:server_name";
  	$stmt = prepareQuery($db, $query);
  	executeQuery($stmt, array(":server_name"=>$storage_server));
  	$row = $stmt->fetch();

  	return $row['total_space']; 
  }


  function setUsedSpaceOn($storage_server, $used_space){
  	$db = getDBConnection();
  	$query = "UPDATE `storage_servers` SET `used_space`=:used_space WHERE `server_name`=:server_name";
  	$stmt = prepareQuery($db, $query);
  	executeQuery($stmt, array(":used_space"=>$used_space, ":server_name"=>$storage_server));
  }
?>