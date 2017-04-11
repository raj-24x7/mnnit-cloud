<?php
	session_start();
	require_once 'checksession.php';
	require_once 'db_connect.php';
	require_once 'xen.php';
	require_once 'ssh.php'; 

	$row ='';
	$ip = '';
	// If the Request is rejected. 
	if($_POST['button']=='Reject'){
		//inserting to notification table
		$parameter = array(
				":username"=>$_POST['username'],
				":vm_name"=>$_POST['VM_name']
			);
		$query="INSERT INTO notification (username,vmname,status) VALUES (:username,:vm_name,'r')";
		$db = getDBConnection();
		$statement = prepareQuery($db,$query);
        if(!executeQuery($statement,$parameter)){
        	header("location:error.php?error=1104");
        }



		//updating VMrequest table setting status as rejected
		$sql = 'UPDATE VMrequest SET status = "rejected" WHERE VM_name= :vm_name';
		$param = array(
				":vm_name"=>$_POST['VM_name']
			);
		//$db = getDBConnection();
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
		} else {
			header("location:error.php?error=1106");
		}

			header("location:pending_details.php");
			die();
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
				header("location:error.php?error=1301");	//ERROR
			}	
		} else {
			header("location:error.php?error=1104");
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
	
		// Code to create Virtual Machines
		//die("".$_POST['description']);
		$VMparam = array(
			"name"=>$_POST['VM_name'],
			"memory"=>$_POST['ram'],
			"ip"=>$ip,
			"netmask"=>"255.255.252.0",
			"gateway"=>"172.31.128.1",
			"hostname"=>"localhost",
			"description"=>$_POST['description']
		);
		//$xen = makeXenConnection($_POST['hypervisor']);
		//createVMFromXapi($xen,$VMparam,$_POST['os']);
		// the following function creates VM with given parameters
		createVMFromSSH($_POST['hypervisor'],$VMparam,$_POST['os']);

		// Insert New Created VM in the Table
		$sql = 'INSERT INTO VMdetails (username,VM_name,os,cpu,ram,storage,hypervisor_name,ip,doe) VALUES (:username,:VM_name,:os,:cpu,:ram,:storage,:hypervisor_name,:ip,:doe)';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			header("location:error.php?error=1104");	//ERROR
		}
		
		//set IP to allocated in database
		$ipParam = array(
				":ip"=>$param[':ip']
			);
		$sql = 'UPDATE ip_pool SET status = "allocated" WHERE ip =:ip';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$ipParam)){
			header("location:error.php?error=1107");	//ERROR
		}
		

		// Delete requested entry 
		$nameParam = array(
				":VM_name"=>$_POST['VM_name']
			);
		$sql = 'DELETE FROM VMrequest WHERE VM_name = :VM_name';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$nameParam)){
			die("cannot delete from VMrequest");	//ERROR
		}


		// create notification for user
		$parameter = array(
				":username"=>$_POST['username'],
				":vm_name"=>$_POST['VM_name']
			);
		$query="INSERT INTO notification (username,vmname,status) VALUES (:username,:vm_name,'a')";
		$statement = prepareQuery($db,$query);
        if(!executeQuery($statement,$parameter)){
        	die("NOT DONE");
        }
        
		header("location:VMdetails.php");
	} else {
		header("location:error.php?error=1101");
	}

?>