<?php
	session_start();
	require 'checksession.php';
	require 'db_connect.php';
	require 'xen.php';

	$reply = '';
	if(isset($_POST['VM_name']) && !empty($_POST['VM_name'])){
		$query = "  SELECT 
					* 
					FROM `VMdetails`
					WHERE
					`VM_name`=:vm_name
				";
	    $param = array(
	        ":vm_name"=>$_POST['VM_name']
	      );   
	    $db = getDBConnection();
	    $stmt = prepareQuery($db,$query);
	    executeQuery($stmt,$param);
	    $row = $stmt->fetch();

		$xen = makeXenconnection($row['hypervisor_name']);
		$vm = $xen->getVMByNameLabel($_POST['VM_name']);
		$action = $_POST['action'];
		try{
			if($action == 'hardShutdown'){
				$res = $vm->hardShutdown();
			}	else if($action == 'cleanShutdown') {
				$res = $vm->cleanShutdown();
			} else if ($action == 'start') {
				$res = $vm->start();
			} else if ($action == 'cleanReboot') {
				$res = $vm->cleanReboot();
			} else if($action == 'destroy') {  
				
			} else {
				//echo 'Wrong Action';
				die();
			}
		} catch(Exception $e){
			$reply = array(
				"status"=>"failure",
				"message"=>'Unable to connect to cloud Servers
				');
		}
		$metrics = $vm->getMetrics()->getValue();
		$reply = array(
			"status"=>"success",
			"power_status"=> $vm->getPowerState()->getValue(),
			"RAM"=>$metrics['memory_actual']
			);
	} else {
		$reply = array(
			"status"=>"failiure",
			"message"=>'false Callback'
			);
	}
		

	echo json_encode($reply);

?>