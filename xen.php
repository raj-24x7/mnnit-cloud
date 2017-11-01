 <?php

	require_once __DIR__.'/vendor/autoload.php';
	require_once 'db_connect.php';
  require_once('logging.php');
	use Sircamp\Xenapi\Xen as Xen;
	
	function makeXenConnection($dom0name){
		$db = getDBConnection();
		$sql = 'SELECT * FROM `hypervisor` WHERE name=:name';
		$param = array(":name"=>$dom0name);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		$row = $stmt->fetch();
		$ip='http://'.$row['ip'];
		$username=$row['userid'];
		$password=$row['password'];

		try{
		 $xen = new Xen($ip,$username,$password);
		}catch(XenConnectionException $e){
			echo '<br>XENConnectionError : '.$e; 
		}
		return $xen;
	}


	function createVMFromXapi($xen,$VMparam,$template){
		$vm = $xen->getVMByNameLabel($template);
		$vm->clonevm($VMparam['name']);
		$val = false;
		$vmnew = $xen->getVMByNameLabel($VMparam['name']);
		$vmnew->setIsATemplate($val);

		$PVargs = "graphical utf8 -- _ipaddr=".$VMparam['ip']." _netmask=".$VMparam['netmask']." _gateway=".$VMparam['gateway']." _hostname=".$VMparam['hostname']." _name=none _ip=none";
		$vmnew->setPVArgs($PVargs);

		$memory = ((int)$VMparam['memory'])*1024*1024;
		$vmnew->setMemoryLimits($memory, $memory, $memory, $memory);

		$vmnew->setNameDescription($VMparam['description']);

		$vmnew->start();
	}

	
	function vmreboot($xen,$VM_name){
		$vm=$xen->getVMByNameLabel($VM_name);
		$vm->cleanReboot();
	} 



?>