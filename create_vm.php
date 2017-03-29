<?php
	session_start();
	require_once 'checksession.php';
	require_once 'db_connect.php';
	require_once 'xen.php';
	require_once 'ssh.php'; 

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
				":hypervisor_name" => $_POST['hypervisor'],
				":username" => $_POST['username'],
				":doe" => $_POST['doe'],
				":ip" => $ip
				);
		echo "Retrieved Data";
		// Code to create Virtual Machines
		
		$VMparam = array(
			"name"=>$_POST['VM_name'],
			"memory"=>$_POST['ram'],
			"ip"=>$ip,
			"netmask"=>"255.255.252.0",
			"gateway"=>"172.31.100.1",
			"hostname"=>"localhost",
			"description"=>"testing..."
		);
		//$xen = makeXenConnection($_POST['hypervisor']);
		//createVMFromXapi($xen,$VMparam,$_POST['os']);
		createVMFromSSH($_POST['hypervisor'],$VMparam,$_POST['os']);

		// Insert New Created VM in the Table
		$sql = 'INSERT INTO VMdetails (username,VM_name,os,cpu,ram,storage,hypervisor_name,ip,doe) VALUES (:username,:VM_name,:os,:cpu,:ram,:storage,:hypervisor_name,:ip,:doe)';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			die("Error Inserting in VMdetails");
		}
		
		//set IP to allocated in database
		$ipParam = array(
				":ip"=>$param[':ip']
			);
		$sql = 'UPDATE ip_pool SET status = "allocated" WHERE ip =:ip';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$ipParam)){
			die("Error Updating ip pool");
		}
		

		// Delete requested entry 
		$nameParam = array(
				":VM_name"=>$_POST['VM_name']
			);
		$sql = 'DELETE FROM VMrequest WHERE VM_name = :VM_name';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$nameParam)){
			die("cannot delete from VMrequest");
		}
		header("location:VMdetails.php");
	}

?>