<?php
	session_start();
	require 'checksession.php';
	require 'db_connect.php';
	require 'xen.php';
	require 'ssh.php'; 

	// If the Request is rejected. 
	if($_POST['button']=='Reject'){
		$sql = 'UPDATE VMrequest SET status = "rejected" WHERE VM_name= :vm_name';
		$param = array(
				":vm_name"=>$_POST['VM_name']
			);
		$db = getDBConnection();
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
			header("location:pending_details.php");
		}
	}


	//If the request is accepted.
	if($_POST['button']=='Approve' ){
			$db = getDBConnection();
			
		// Selecting an unallocated IP from the provided set
		$sql = 'SELECT ip FROM ip_pool WHERE status != "allocated"';
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,array())){
			$row = $stmt->fetch();
			$ip = $row['ip'];
			if(empty($ip)){
				die("No IP is Available.");
			}	
		}

		$param = array(
				":VM_name" => $_POST['VM_name'],
				":os" => $_POST['os'],
				":cpu" => $_POST['cpu'],
				":ram" => $_POST['ram'],
				":storage" => $_POST['storage'],
				":hypervisor" => $_POST['hypervisor'],
				":username" => $_POST['username'],
				":doe" => $_POST['doe'],
				":ip" => $ip
				);

		// Code to create Virtual Machines
		//makevm($VM_name);
		//sleep(90);
		//changeip($ip);
		//vmreboot($VM_name);

		// Insert New Created VM in the Table
		$sql = 'INSERT INTO VMdetails (username,VM_name,os,cpu,ram,storage,hypervisor_name,ip) VALUES (:username,:vm_name,:os,:cpu,:ram,:storage,:hypervisor,:ip)';
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
			die("" . $sql . "<br>" . $db->error);
		}
		//set IP to allocated in database

		$sql = 'UPDATE ip_pool SET status = "allocated" WHERE ip =:ip';
		$stmt = prepareQuery($db,$sql);
		executeQuery($stmt,$param);

		// Delete requested entry 
		$sql = 'DELETE FROM VMrequest WHERE VM_name = :vm_name';
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
			die("" . $sql . "<br>" . $db->error);
		}
		header("location:VMdetails.php");
	}

?>