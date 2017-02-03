<?php
	session_start();
	require 'checksession.php';
	require 'xen.php';

		$msg = '';
		//$msg.=$_POST['VM_name'];
		//$msg.=$_POST['action'];
	if(isset($_POST['VM_name']) && !empty($_POST['VM_name'])){

		$xen = makeXenconnection();
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