<?php
	session_start();
	require_once('db_connect.php');
	require_once('checksession.php');
	require_once('logging.php');
	require_once('ssh.php');
	require_once('xen.php');

	function getPort($dom0name,$vm_name){
		#echo $dom0name.$vm_name;
		$xen = makeXenconnection($dom0name);
		$host = $xen->getHostByNameLabel($dom0name);
		$vm = $xen->getVMByNameLabel($vm_name);
		$num = $vm->getDomID()->getValue();
		$connection = getHypervisorConnection($dom0name);

		$command = "xenstore-read /local/domain/".$num."/console/vnc-port";

		if(!($stream = ssh2_exec($connection, $command))){
			header("location:error.php?error=1201");
		}
		
		stream_set_blocking($stream, true);
		$port = stream_get_contents($stream);
		
		fclose($stream);
		return $port;
	}

	if($_SERVER['REQUEST_METHOD']=="GET"){
		if(isset($_GET['VM_name']) && !empty($_GET['VM_name'])){
			$vm_name = $_GET['VM_name'];
			if($_GET['operation']=='start'){
				$opr = "get_console";
			} else { 
				$opr = "release_console";
			}
			$port = getPort(getVMHypervisor($vm_name), $vm_name);
			$xendata = getHypervisorDetails(getVMHypervisor($vm_name));
			$data = array(
				"REQUEST_TYPE"=>$opr,
				"REQUEST_DATA"=>array(
						"REMOTE_HOST"=>array(
								"IP"=>$xendata['ip'],
								"USERNAME"=>$xendata['userid'],
								"PASSWORD"=>$xendata['password']
							),
						"REMOTE_BIND_ADDRESS"=>array(
								"PORT"=>$port
							)
					)
				);
			$jsondata = json_encode($data);

			$socket = getMiddleWareSocket();
			if($socket === false){
				// Middleware not running
				echo "error";
				die();
			}

			socket_write($socket, $jsondata, strlen($jsondata));
			$out = socket_read($socket, 2048);

			if($opr == "get_console"){
				echo "http://172.31.76.68:".$out."/vnc_lite.html";
				#header("Refresh: 0; url=http://172.31.76.68:".$out."/vnc_lite.html");

			} else if($opr == "release_console"){ 
				echo "released";
			}
		}
	}
	

?>