<?php
		require "ssh.php";
		require "xen.php";
		$xen = makeXenconnection();
		$vm = $xen->getVMByNameLabel("pankaj");

		echo "UUID: ".$vm->getUUID()->getValue()."<br>
		";
		echo "PowerState: ".$vm->getPowerState()->getValue()."
		<br>";
		echo "GuestMetrics: ";print_r( $vm->getGuestMetrics()->getValue()); echo "<br>";
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

?> 