<?php
	session_start();
	require_once 'checksession.php';
	require_once 'db_connect.php';
	//require_once 'xen.php';
	//require_once 'ssh.php'; 

	// If the Request is rejected. 
	if($_POST['button']=='Reject'){
		$sql = 'UPDATE hadoop SET status = "rejected" WHERE hadoop_name= :hadoop_name';
		$param = array(
				":hadoop_name"=>$_POST['hadoop_name']
			);
		$db = getDBConnection();
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
			header("location:pending_details.php");
		}
	}


	//If the request is accepted.
	if($_POST['button']=='Approve' ){
			
		$noofslaves=$_POST['number_slave'];


		$db = getDBConnection();
			
		// Selecting an unallocated IP from the provided set
		$sql = 'SELECT ip FROM ip_pool WHERE status != "allocated"';
		$stmt = prepareQuery($db,$sql);

		if(executeQuery($stmt,array())){
			$cc=0;
			while($row=$stmt->fetch()){
				$cc++;
			}
		}
	if($cc>$noofslaves){
		$db=null;
		$db = getDBConnection();
			
		// Selecting an unallocated IP from the provided set
		$sql = 'SELECT ip FROM ip_pool WHERE status != "allocated"';
		$stmt = prepareQuery($db,$sql);

		if(executeQuery($stmt,array())){
		for($i=0;$i<$noofslaves+1;$i++){	
			$row = $stmt->fetch();
		

			

			$ip[$i] = $row['ip'];
			if(empty($ip)){
				die("No IP is Available.");
			}	
		}

		}
	}
	else{
			echo "sorry";
			header("location:hadoop_approval.php");
	}

for($i=0;$i<1;$i++){
	if($i==0){
		$param = array(
				":hadoop_name" => $_POST['hadoop_name'],
				// ":os" => $_POST['os'],
				// ":cpu" => $_POST['cpu'],
				// ":ram" => $_POST['ram'],
				// ":storage" => $_POST['storage'],
				// ":hypervisor" => $_POST['hypervisor'],
				// ":username" => $_POST['username'],
				// ":doe" => $_POST['doe'],
				":vm_name"=>$_POST['hadoop_name']."master",
				":ip" => $ip[$i],
				":role"=>"m"
				);
	}
	else
		{

			$param = array(
				":hadoop_name" => $_POST['hadoop_name'],
				// ":os" => $_POST['os'],
				// ":cpu" => $_POST['cpu'],
				// ":ram" => $_POST['ram'],
				// ":storage" => $_POST['storage'],
				// ":hypervisor" => $_POST['hypervisor'],
				// ":username" => $_POST['username'],
				// ":doe" => $_POST['doe'],
				":vm_name"=>$_POST['hadoop_name']."slave".$i,
				":ip" => $ip[$i],
				":role"=>"s"
				);
			
		}

		echo $param[":vm_name"];

	
		// Code to create Virtual Machines
		
		// $VMparam = array(
		// 	"name"=>$_POST['VM_name'],
		// 	"memory"=>$_POST['ram'],
		// 	"ip"=>$ip,
		// 	"netmask"=>"255.255.252.0",
		// 	"gateway"=>"172.31.100.1",
		// 	"hostname"=>"localhost"
		// );

	// 	// createVM($_POST['hypervisor'],$VMparam,$_POST['os']);


		 // Insert New Created VM in the Table
		$db=null;
		$db = getDBConnection();
		$sql = 'INSERT INTO cluster (hadoop_name,VM_name,ip,role) VALUES (:hadoop_name,:vm_name,:ip,:role)';
		$stmt = prepareQuery($db,$sql);
		if(executeQuery($stmt,$param)){
			die("" . $sql . "<br>" . $db->error);
		}
		// //set IP to allocated in database

		// $sql = 'UPDATE ip_pool SET status = "allocated" WHERE ip =:ip';
		// $stmt = prepareQuery($db,$sql);
		// executeQuery($stmt,$param);

	// 	// Delete requested entry 
	// 	$sql = 'DELETE FROM VMrequest WHERE VM_name = :vm_name';
	// 	$stmt = prepareQuery($db,$sql);
	// 	if(executeQuery($stmt,$param)){
	// 		die("" . $sql . "<br>" . $db->error);
	// 	}


	// }
	}
		//	header("location:VMdetails.php");
	}

?>