<?php 
	require_once('db_connect.php');

	function notifyUser($username, $type, $message){
		$date = new DateTime();
		$tm = $date->format("Y-m-d H:i:s");
		$parameter = array(
				":username"=>$username,
				":type"=>$type,
				":message"=>$message,
				":timestamp"=> $tm,
				":status"=>"n"
			);
		$query="INSERT INTO notification (username,type,message,timestamp ,status) VALUES (:username,:type, :message,:timestamp,:status)";
		$db = getDBConnection();
		$statement = prepareQuery($db,$query);
        if(!executeQuery($statement,$parameter)){
        	$l = logError("1104");
            $l[0]->log($l[1]);
        	header("location:error.php?error=1104");
        	die();
        }
	}

	function getAllNotifications(){
		$username = $_SESSION['username'];
		$parameter = array(
				":username"=>$username,
			);
		$query="SELECT * FROM `notification` WHERE `username`=:username ORDER BY `id` DESC";
		$db = getDBConnection();
		$statement = prepareQuery($db,$query);
        if(!executeQuery($statement,$parameter)){
        	$l = logError("1104");
            $l[0]->log($l[1]);
        	header("location:error.php?error=1104");
        	die();
        }	
        return $statement;
	}
?>