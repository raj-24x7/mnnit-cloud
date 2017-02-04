 <?php

	require_once __DIR__.'/vendor/autoload.php';
	require_once 'db_connect.php';
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

	function makevm($xen,$VM_name,$template){
		$vm = $xen->getVMByNameLabel($template);
		$vm->clonevm($VM_name);
		$val = false;
		$vmnew = $xen->getVMByNameLabel($VM_name);
		$vmnew->setIsATemplate($val);
		$vmnew->start();
	}
	function vmreboot($xen,$VM_name){
		$vm=$xen->getVMByNameLabel($VM_name);
		$vm->cleanReboot();
	} 
?>