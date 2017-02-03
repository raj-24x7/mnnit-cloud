 <?php

	require __DIR__.'/vendor/autoload.php';
	use Sircamp\Xenapi\Xen as Xen;
	function makeXenConnection(){
		$ip='http://172.31.100.51';
		$username='root';
		$password='root@123';
		try{
		 $xen = new Xen($ip,$username,$password);
		}catch(XenConnectionException $e){
			echo $e; 
		}
		return $xen;
	}

	function makevm($VM_name){
		$xen = makeXenConnection();
		$vm = $xen->getVMByNameLabel("centos6.7");
		$vm->clonevm($VM_name);
		$val = false;
		$vmnew = $xen->getVMByNameLabel($VM_name);
		$vmnew->setIsATemplate($val);
		$vmnew->start();
	}
	function vmreboot($VM_name){

		$xen=makeXenConnection();
		$vm=$xen->getVMByNameLabel($VM_name);
		$vm->cleanReboot();
	} 
?>