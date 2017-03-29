<?php
	session_start();
	require 'checksession.php';
	require 'db_connect.php';
	require 'xen.php';

		$msg = '';
		//$msg.=$_POST['VM_name'];
		//$msg.=$_POST['action'];

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

	if(isset($_POST['VM_name']) && !empty($_POST['VM_name'])){

		$xen = makeXenconnection($row['hypervisor_name']);
		$vm = $xen->getVMByNameLabel($_POST['VM_name']);
		$action = $_POST['action'];
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
			echo 'Wrong Action';
			die();
		}

		if($res->getStatus() == 'Success'){
			$msg .= $vm->getPowerState()->getValue();
		} else {
			$msg .= 'Error';	
		}
		echo $msg;
	} else {
		echo $msg.'<error>Invalid Request</error>';
	}


?>