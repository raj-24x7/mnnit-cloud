<?php namespace Sircamp\Xenapi;
use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Element\XenVirtualMachine as  XenVirtualMachine;
use Sircamp\Xenapi\Element\XenHost as XenHost;
use Sircamp\Xenapi\Connection\XenConnection as  XenConnection;
use Sircamp\Xenapi\Connection\XenResponse as  XenResponse;
use Sircamp\Xenapi\Element\XenPool as XenPool;
use Sircamp\Xenapi\Exception as  XenConnectionException;

class Xen {

	private $xenconnection = NULL;

	public function __construct($url, $user, $password){

		
		if(! Validator::ip()->validate($url)){

			//throw new \InvalidArgumentException("'url' value mast be an ipv4 address", 1);
			
		}
		if(!Validator::stringType()->validate($user)){
			throw new \InvalidArgumentException("'user' value mast be an non empty string", 1);
		}

		if(!Validator::stringType()->validate($password)){
			throw new \InvalidArgumentException("'password' value mast be an non empty string", 1);
		}
		
		$this->xenconnection = new XenConnection();
		try{
			$this->xenconnection->_setServer($url,$user,$password);
		}
		catch(Exception $e){
			dd($e->getMessage());
		}
	}

	/**
	 * Get VM inside Hypervisor from name.
	 *
	 * @param mixed $name the name of VM
	 *
	 * @return mixed
	 */
	public function getVMByNameLabel($name){
		$response = new XenResponse($this->xenconnection->VM__get_by_name_label($name));
		return new XenVirtualMachine($this->xenconnection,$name,$response->getValue()[0]);
	}

	/**
	 * Get HOST from name.
	 *
	 * @param mixed $name the name of HOST
	 *
	 * @return mixed
	 */
	public function getHOSTByNameLabel($name){
		$response = new XenResponse($this->xenconnection->host__get_by_name_label($name));
		return new XenHost($this->xenconnection,$name,$response->getValue()[0]);
	}


    /**
     * get All records of all the pools known to system
     *
     * @param 
     *
     * @return mixed
     */
    public function getAllPools(){
        $response = new XenResponse($this->xenconnection->pool__get_all_records());
        $pool_array = $response->getValue();
        $pools = array();	
        foreach ($pool_array as $key => $value) {
			$name = $value['name_label'];
			$pool = new XenPool($this->xenconnection, $name, $key);
			$pools = array_merge($pools, array($pool));     	
        }
        return $pools;      
    }


	public function getAllVMs(){
		$response = new XenResponse($this->xenconnection->VM__get_all());
        $VM_array = $response->getValue();
        $VMs = array();	
        foreach ($VM_array as $key => $value) {
			
			$VM = new XenVirtualMachine($this->xenconnection, (string)$key, $value);
			$VMs = array_merge($VMs, array($VM));     	
        }
        return $VMs;
    }
	

	public function getAllHosts(){
		$response = new XenResponse($this->xenconnection->pool__get_all_records());
        $pool_array = $response->getValue();
        $pools = array();	
        foreach ($pool_array as $key => $value) {
			$name = $value['name_label'];
			$pool = new XenPool($this->xenconnection, $name, $key);
			$pools = array_merge($pools, array($pool));     	
        }
        return $pools;
    }
}

?>