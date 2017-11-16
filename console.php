<?php
	session_start();
	require_once('db_connect.php');
	require_once('checksession.php');
	require_once('logging.php');
	require_once('ssh.php');
	require_once('xen.php');
	function getPort($dom0name,$vm_name){

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
		//echo $uuid;
		fclose($stream);
		return $port;
	}
	//print_r(getPort("xenserver-trial","trest"));

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

			/* Create a TCP/IP socket. */
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if ($socket === false) {
			    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
			} else {
			    echo "OK.\n";
			}

			$address = "127.0.0.1";
			$service_port = 1234;
			echo "Attempting to connect to '$address' on port '$service_port'...";
			$result = socket_connect($socket, $address, $service_port);
			if ($result === false) {
			    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
			} else {
			    echo "OK.\n";
			}
			socket_write($socket, $jsondata, strlen($jsondata));
			$out = socket_read($socket, 2048);
			//echo "Refresh: 0; url=http://172.31.76.68:".$out."/vnc_lite.html";
			if($opr == "get_console"){
				header("Refresh: 0; url=http://172.31.76.68:".$out."/vnc_lite.html");
			} else { 
				header("location:error.php?error=1805");
			}

		}
	}
	

?>