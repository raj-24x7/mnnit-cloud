<?php
session_start();
	/**
 *  @author Raj Kumar
 * the page only for testing purposes
 * please do not modify
 */



	//include 'ssh.php'/*/*/*/*/*;

	//resizeVDIFromUUID('xenserver-trial','433b7123-631b-f2bb-dccf-8fd3cb60013a', '8');
/*		require_once "ssh.php";
		require_once "xen.php";
		require_once "db_connect.php";
		$xen = makeXenconnection("xenserver-trial");
		$host = $xen->getHostByNameLabel("xenserver-trial");
	$vm = $xen->getVMByNameLabel("centos7");//Ubuntu 14.04 Template
*/		

//		$x = $vm->setNameLabel("Ubuntu14.04");
//		echo $x->getValue().'<br>';
//		echo $x->getStatus().'<br>';
//		echo $vm->getIsATemplate()->getValue();
		
//		$val = true;
//		$vm->setIsATemplate($val);
		//$vm->start();*/*/*/*/*/

/*

		// $vm = $xen->getVMByNameLabel("pankaj");
		// $res = $vm->hardReboot();
		// echo 'Result : '.$res->getStatus();
		// echo 'Value : '.$res->getValue();*/
/*
		echo "UUID: ".$vm->getUUID()->getValue()."<br>
		";
		echo "PowerState: ".$vm->getPowerState()->getValue()."
		<br>";
		echo "GuestMetrics: ";print_r( $vm->getGuestMetrics()->getStatus()); echo "<br>";
		echo "Metrics: ";print_r($vm->getMetrics()->getValue());echo "<br>";
		//echo "Stats: ".$vm->getStats()->getValue()."
		//";

		echo "Consoles: ";print_r($vm->getConsoles()->getValue()); echo"<br>";
		echo "DiskSpace: ".$vm->getDiskSpace()->getValue()."<br>";
		echo "StarrtDelay: ".$vm->getStartDelay()->getValue()."<br>";
		echo "ShutdownDelay: ".$vm->getShutdownDelay()->getValue()."<br>";
		echo "ResidentOn: ".$vm->getResidentOn()->getValue()->getName()."<br>";
		echo "OtherConfig: ";print_r($vm->getOtherConfig()->getValue()); echo"<br>";
		echo "Platform: ";print_r($vm->getPlatform()->getValue());echo "<br>";
		echo "NameDescription: ".$vm->getNameDescription()->getValue()."<br>";
		echo "VmId: ".$vm->getVmId()."<br>";
		echo "Name: ".$vm->getName()."<br>";
		echo "PV-args".$vm->getPVArgs()->getValue()."<br>";
		echo "static max : ".$vm->getMemoryStaticMax()->getValue()."<br>";
		echo "static min : ".$vm->getMemoryStaticMin()->getValue()."<br>";
		echo "dynamic max : ".$vm->getMemoryDynamicMax()->getValue()."<br>";
		echo "dynamic min : ".$vm->getMemoryDynamicMin()->getValue()/(1024*1024)."<br>";
		$memory = 1024*1024*1024;
		//$vm->setMemoryLimits($memory, $memory, $memory, $memory);
		echo $memory;
		echo "<br>";
		$uuid = 12456;*/
		

		/*$VMparam = array(
			"name"=>"trail",
			"memory"=>"256",
			"ip"=>"172.1.2145",
			"netmask"=>"255.255.252.0",
			"gateway"=>"172.31.100.1",
			"hostname"=>"localhost",
			"description"=>"asdffert"
		);
		echo 'xe vm-param-set PV-args="graphical utf8 -- _ipaddr='.$VMparam['ip'].' _netmask='.$VMparam['netmask'].' _gateway='.$VMparam['gateway'].' _hostname='.$VMparam['hostname'].' _name=none _ip=none" uuid='.$uuid.'';*/

		// $var = '12';
		// echo (int)$var*2;
		// $vm->cleanShutdown();
		// $val = true;

		// $vm->setIsATemplate($val);
		
		


/*		echo "ADD: ";print_r($host->getMetrics()->getValue());

		echo "<br>OtherConfig: ";print_r($host->getOtherConfig()->getValue());
		echo '<br> List methods : '.$host->listMethods()->getValue();
		echo '<br> Allowed operations: ';print_r($host->getAllowedOperations()->getValue());
		echo '<br> Log : '.$host->getLog()->getValue();
		// echo '<br> dmesg : '.$host->dmesg()->getValue();
		echo '<br> CPU INFO : ';print_r($host->getCPUInfo()->getValue());
		echo '<br> HOSt CPU : ';print_r($host->getHostCPUs()->getValue());

		echo '<br> Status Capabilities : '.$host->getSystemStatusCapabilities()->getValue();
		echo '<br> Memory Overhead : '.$host->computeMemoryOverhead()->getValue()/(1024*1024);
		echo '<br> Free Memory : '.$host->computeFreeMemory()->getValue()/(1024*1024*1024);

		echo "<br>Software Version: ";print_r($host->getSoftwareVersion()->getValue());
		echo "<br>CPU Config: ";print_r($host->getCPUConfig()->getValue());
		echo "<br>Bios String: ";print_r($host->getBiosString()->getValue());
		echo "<br>Guest VCPU Param: ";print_r($host->getGuestVCPUParam()->getValue());
		echo "<br>Sche Policy: ";print_r($host->getSchedPolicy()->getValue());
*/

		/// Testing File listing tools
		/*$dir = "js";
		echo file_exists($dir);

		foreach( scandir($dir) as $f){
			echo $f.'<br>';
		}*/

//		include "ssh.php";

/*
function createHadoop($dom0name ,$name, $ram, $noofslaves, $ips){

		$connection = getHypervisorConnection($dom0name);

		$command = "bash ~/utilityScripts/createCluster.sh ".$name." ".$ram." ".$noofslaves;

		for($i=0; $i<=$noofslaves; $i++){
			$command = $command." ".$ips[$i];
		}

		$command = $command." "."&";

		echo $command;
		$stream = ssh2_exec($connection, $command);
		
		stream_set_blocking($stream, true);
		$uuid = stream_get_contents($stream);
		echo $uuid."<br>";

		fclose($stream);

		return true;
}

createHadoop("xenserver-trial", "test", "256MiB", "1", array(0=>"172.31.131.220", 1=>"172.31.131.221"));
*/

/*require_once('db_connect.php');
function createNewLinuxUser($username, $storage_server, $password){
		$db = getDBConnection();
		$sql = 'SELECT * FROM `storage_servers` WHERE `server_name`=:name';
		$param = array(":name"=>$storage_server);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		$row = $stmt->fetch();
		$ip=$row['ip'];
		$sr_username=$row['login_name'];
		$sr_password=$row['login_password'];
		$connection = null;
		if(!($connection = ssh2_connect($ip, 22))){
			header("location:error.php?error=1201");
			die();
		}
		if(!(ssh2_auth_password($connection, $sr_username, $sr_password))){
			header("location:error.php?error=1201");
			die();
		}

		$command = "openssl passwd -crypt ".$password;
		$stream = ssh2_exec($connection, $command);
		stream_set_blocking($stream, true);
		echo $encrypted_password = stream_get_contents($stream);
		fclose($stream);

		$command = "useradd ".$username." -p ".$encrypted_password;
		$stream = ssh2_exec($connection, $command);

		$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
		stream_set_blocking($errorStream, true);
		stream_set_blocking($stream, true);
/*
		echo "Output: " . stream_get_contents($stream);
		echo "Error: " . stream_get_contents($errorStream);
		*/
/*		fclose($stream);
}

*/

//include("ssh.php");

//print_r(getUsedSpace("admin","storage-server-1"));
include('db_connect.php');
include('ssh.php');

if(!isset($_SESSION['username'])){
	$_SESSION['username'] = "raj";
}
		

	function mountUserFiles($password){
		$username = "raj";
		$password = "iptables";
		//$ip = getStorageServer($username);
		$ip = "172.31.76.68";
		$cmd = "bash mount.bash ".$ip." ".$username." ".$password." 2>&1";
		//$cmd= "whoami";
		echo $cmd;
		$ret = "";
		exec($cmd,$ret);
		//echo " :: ";
		return $ret;
			
	}


function testing(){
	$username = "raj";
		$password = "iptables";
		//$ip = getStorageServer($username);
		$ip = "172.31.76.68";
		$cmd = "bash mount.bash ".$ip." ".$username." ".$password." 2>&1";
		//$cmd= "whoami";
		echo $cmd;
		$connection = getLocalServerShell();

		$command = "bash /var/www/html/project/mount.bash ".$ip." ".$username." ".$password." 2>&1";;
		$stream = ssh2_exec($connection, $command);
		stream_set_blocking($stream, true);
		$recv_data = stream_get_contents($stream);
		fclose($stream);

		return $recv_data;

	}


	print_r(testing());

//echo is_dir("files/admin/Arduino");


	//echo doesUserExists("user","storage-server-1");
?>		


