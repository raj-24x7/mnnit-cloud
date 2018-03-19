<?php namespace Sircamp\Xenapi;
use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Element\XenVirtualMachine as  XenVirtualMachine;
use Sircamp\Xenapi\Element\XenHost as XenHost;
use Sircamp\Xenapi\Connection\XenConnection as  XenConnection;
use Sircamp\Xenapi\Connection\XenResponse as  XenResponse;
use Sircamp\Xenapi\Element\XenPool as XenPool;
use Sircamp\Xenapi\Element\XenStorageRepository as XenStorageRepository;
use Sircamp\Xenapi\Element\XenVirtualDiskImage as XenVirtualDiskImage;
use Sircamp\Xenapi\Element\XenConsole as  XenConsole;
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

    /**
     * get All records of all the VMs known to system
     *
     * @param 
     *
     * @return mixed
     */

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
	

    /**
     * get All records of all the Hosts known to system
     *
     * @param 
     *
     * @return mixed
     */

	public function getAllHosts(){
		$response = new XenResponse($this->xenconnection->host__get_all_records());
        $host_array = $response->getValue();
        $hosts = array();	
        foreach ($host_array as $key => $value) {
			
			$host = new XenHost($this->xenconnection, $key, $value);
			$hosts = array_merge($hosts, array($host));     	
        }
        return $hosts;
    }


    /**
     * get All records of all the SRs known to system
     *
     * @param 
     *
     * @return mixed
     */

	public function getAllStorageRepository(){
		$response = new XenResponse($this->xenconnection->SR__get_all());
        $SR_array = $response->getValue();
        $SRs = array();	
        foreach ($SR_array as $key => $value) {
			
			$SR = new XenStorageRepository($this->xenconnection, $key, $value);
			$SRs = array_merge($SRs, array($SR));     	
        }
        return $SRs;
    }

    /**
     * get All records of all the VDIs known to system
     *
     * @param 
     *
     * @return mixed
     */

	public function getAllVDIs(){
		$response = new XenResponse($this->xenconnection->VDI__get_all());
        $VDI_array = $response->getValue();
        $VDIs = array();	
        foreach ($VDI_array as $key => $value) {
			
			$VDI = new XenVirtualDiskImage($this->xenconnection, $key, $value);
			$VDIs = array_merge($VDIs, array($VDI));     	
        }
        return $VDIs;
    }

    
}

?>