<?php
		//require_once "ssh.php";
		require_once "xen.php";
		require_once "db_connect.php";
		$xen = makeXenconnection("xenserver-slave3");
		$host = $xen->getHostByNameLabel("xenserver-slave3");
		//$vm = $xen->getVMByNameLabel("Ubuntu14.04");//Ubuntu 14.04 Template
		/*$x = $vm->setNameLabel("Ubuntu14.04");
		echo $x->getValue().'<br>';
		echo $x->getStatus().'<br>';
		echo $vm->getIsATemplate()->getValue();*/
		
//		$val = true;
//		$vm->setIsATemplate($val);



		// $vm = $xen->getVMByNameLabel("pankaj");
		// $res = $vm->hardReboot();
		// echo 'Result : '.$res->getStatus();
		// echo 'Value : '.$res->getValue();
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
*/
		


		echo "ADD: ";print_r($host->getMetrics()->getValue());

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

?> 