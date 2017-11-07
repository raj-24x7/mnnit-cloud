<?php
	session_start();
	require_once 'checksession.php';
	require_once 'db_connect.php';
	require_once 'ssh.php';
	require_once 'logging.php';
	
	// If the Request is rejected. 
	if($_POST['button']=='Reject'){
		$sql = 'UPDATE hadoop SET status = "rejected" WHERE hadoop_name= :hadoop_name';
		$param = array(
				":hadoop_name"=>$_POST['hadoop_name']
			);
		$db = getDBConnection();
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
			logHadoopRejected($_POST['hadoop_name'], $_SESSION['username']);
			notifyUser($_POST['username'], "HADOOP", "Your Request for hadoop cluster '".$_POST['hadoop_name']."' has been Rejected");
			header("location:pending_details.php");
			die();
		}
	}


	//If the request is accepted.
	if($_POST['button']=='Approve' ){
		
		logHadoopApproved($_POST['hadoop_name']);	
		$noofslaves=$_POST['number_slave'];
		if(countAvailableIP() < $noofslaves+1){
			$l = logError("1301");
            $l[0]->log($l[1]);
			header("location:error.php?error=1301");
			die();
		}

		$db = getDBConnection();
		$query = "SELECT `ip` FROM `ip_pool` WHERE `status`!='allocated'";
		$stmt = prepareQuery($db, $query);
		if(!executeQuery($stmt, array())){
			$l = logError("1104");
            $l[0]->log($l[1]);
			header("location:error.php?error=1104");
			die();
		}
		$ip = array();
		for($i=0; $i<=$noofslaves; $i++){
			$row=$stmt->fetch();
			$ip[$i] = $row['ip'];
		}

		// creating the hadoop cluster
		//Here
		createHadoopCluster($_POST['hypervisor'], $_POST['hadoop_name'], $_POST['ram'], $noofslaves, $ip);
			logHadoopCreated($_POST['hadoop_name']);
		// Updating the request
		
		$query = "UPDATE `hadoop` SET `status`='created'";
		$stmt = prepareQuery($db, $query);
		if(!executeQuery($stmt, array())){
			$l = logError("1104");
            $l[0]->log($l[1]);
			header("location:error.php?error=1104");
			die();
		}

		// PArameter of VMs
		$param = array(
				":VM_name" => $_POST['hadoop_name'],
				":cpu" => $_POST['cpu'],
				":ram" => $_POST['ram'],
				":storage" => $_POST['storage'],
				":hypervisor_name" => $_POST['hypervisor'],
				":username" => $_POST['username'],
				":doe" => $_POST['doe'],
				":iscluster" => $_POST['hadoop_name']
				);

		////// Adding VMs ///////

		// Master
		$param[':ip'] = $ip[0];
		$param[':VM_name'] = $_POST['hadoop_name']."Master";
		// Insert New Created VM in the Table
		$sql = 'INSERT INTO VMdetails (username,VM_name,cpu,ram,storage,hypervisor_name,ip,doe,iscluster) VALUES (:username,:VM_name,:cpu,:ram,:storage,:hypervisor_name,:ip,:doe,:iscluster)';
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			$l = logError("1204");
            $l[0]->log($l[1]);
			header("location:error.php?error=1204");	//ERROR
			die();
		}

		// SLaves
		for($i=1; $i<=$noofslaves; $i++){
			$param[':ip'] = $ip[$i];
			$param[':VM_name'] = $_POST['hadoop_name']."Slave".$i;
			// Insert New Created VM in the Table
			$sql = 'INSERT INTO VMdetails (username,VM_name,cpu,ram,storage,hypervisor_name,ip,doe,iscluster) VALUES (:username,:VM_name,:cpu,:ram,:storage,:hypervisor_name,:ip,:doe,:iscluster)';
			$stmt = prepareQuery($db,$sql);
			if(!executeQuery($stmt,$param)){
				$l = logError("1104");
                $l[0]->log($l[1]);
				header("location:error.php?error=1104");	//ERROR
				die();
			}
		}

		// Setting IP's to allocated
		$query = "UPDATE `ip_pool` SET `status`='allocated' WHERE `ip`=:ip";
		$stmt = prepareQuery($db, $query);
		for($i=0; $i<=$noofslaves; $i++){
			$param = array(
					":ip" => $ip[$i]
				);
			if(!executeQuery($stmt, $param)){
				$l = logError("1104");
                $l[0]->log($l[1]);
				header("location:error.php?error=1104");
				die();
			}
		}
		
			notifyUser($_POST['username'], "HADOOP", "Your Request for hadoop cluster '".$_POST['hadoop_name']."' has been Approved");
		header("location:hadoop_details.php");
		die();
	}else{
		header("location:dashboard.php");
		die();
	}	



	/*
	 * UTILITY FUNCTIONS
	 * 
	 */

	/**
	 * Returns the number of Free IPs in the IP pool
	 */
	function countAvailableIP(){
		$db = getDBConnection();
		$query = "SELECT COUNT(*) as count FROM `ip_pool` WHERE `status`!='allocated'";
		$stmt = prepareQuery($db, $query);
		if(!executeQuery($stmt, array())){
			$l = logError("1105");
            $l[0]->log($l[1]);
			header("location:error.php?error=1105");
			die("cannot count * ");
		}
		$row = $stmt->fetch();
		return $row['count']; 
	} 


?>
