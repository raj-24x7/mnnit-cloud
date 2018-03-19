<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;

class XenHost extends XenElement {

	private $name;
	private $hostId;

	public function __construct($xenconnection,$name,$hostId){
		parent::__construct($xenconnection);
		$this->name = $name;
		$this->hostId = $hostId;
	}

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function _setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of hostId.
     *
     * @return mixed
     */
    public function getHostId()
    {
        return $this->hostId;
    }

    /**
     * Sets the value of hostId.
     *
     * @param mixed $hostId the host id
     *
     * @return self
     */
    public function _setHostId($hostId)
    {
        $this->hostId = $hostId;

        return $this;
    }

	/**
     * Puts the host into a state in which no new VMs can be started. Currently active VMs on the host
	 * continue to execute.
     *
     * @param 
     *
     * @return mixed
     */
    public function disable(){
        
        return $this->getXenconnection()->host__disable($this->getHostId());      
    }

	/**
     * Puts the host into a state in which  new VMs can be started.
     *
     * @param 
     *
     * @return mixed
     */
    public function enable(){
        
        return $this->getXenconnection()->host__enable($this->getHostId());      
    }


	/**
     * Shutdown the host. (This function can only be called if there are no currently running VMs on
	 * the host and it is disabled.).
     *
     * @param 
     *
     * @return mixed
     */
    public function shutdown(){
        
        return $this->getXenconnection()->host__shutdown($this->getHostId());      
    }
   
	/**
     * Reboot the host. (This function can only be called if there are no currently running VMs on
	 * the host and it is disabled.).
     *
     * @param 
     *
     * @return mixed
     */
    public function reboot(){
        
        return $this->getXenconnection()->host__reboot($this->getHostId());      
    } 

	
    /**
     * Get the host xen dmesg.
     *
     * @param 
     *
     * @return mixed
     */
    public function dmesg(){
        
        return $this->getXenconnection()->host__dmesg($this->getHostId());      
    }

    /**
     * Get the host xen dmesg, and clear the buffer
     *
     * @param 
     *
     * @return mixed
     */
    public function dmesgClear(){
        
        return $this->getXenconnection()->host__dmesg_clear($this->getHostId());      
    }

    /**
     * Get the host’s log file.
     *
     * @param 
     *
     * @return mixed
     */
    public function getLog(){
        
        return $this->getXenconnection()->host__get_log($this->getHostId());      
    }

   /**
     * List all supported methods.
     *
     * @param 
     *
     * @return mixed
     */  
    public function listMethods(){
        
        return $this->getXenconnection()->host__list_methods();      
    }


	/**
     * Apply a new license to a host.
     *
     * @param $license The contents of the license file, base64 en-coded
     *
     * @return mixed
     */  
    public function licenseApply($license = ""){
        
        return $this->getXenconnection()->host__license_apply($this->getHostId(),$license);      
    }


	/**
     * Check this host can be evacuated.
     *
     * @param 
     *
     * @return mixed
     */  
    public function assertCanEvacuate(){
        
        return $this->getXenconnection()->host__assert_can_evacuate($this->getHostId());      
    } 
    
    /**
     * Migrate all VMs off of this host, where possible.
     *
     * @param 
     *
     * @return mixed
     */  
    public function evacuate(){
        
        return $this->getXenconnection()->host__evacuate($this->getHostId());      
    } 
    

    /**
     * This call queries the host’s clock for the current time.
     *
     * @param 
     *
     * @return mixed
     */  
    public function  getServertime(){
        
        return $this->getXenconnection()->host__get_servertime($this->getHostId());      
    } 

    /**
     * This call queries the host's clock for the current time in the host’s local timezone.
     *
     * @param 
     *
     * @return mixed
     */  
    public function getServerLocaltime(){
        
        return $this->getXenconnection()->host__get_server_localtime($this->getHostId());      
    }

    /**
     * Get the installed server SSL certificate. (pem file)
     *
     * @param 
     *
     * @return mixed
     */  
    public function getServerCertificate(){
        
        return $this->getXenconnection()->host__get_server_certificate($this->getHostId());      
    }


    /**
     * Change to another edition, or reactivate the current edition after a license has expired. This may
     * be subject to the successful checkout of an appropriate license.
     *
     * @param $edition The requested edition, $force Update the license params even if the apply
     * 		  call fails
     *
     * @return mixed
     */  
    public function applyEdition($edition,$force = false){
        
        return $this->getXenconnection()->host__apply_edition($this->getHostId(),$edition,$force);      
    }
    

    /**
     * Refresh the list of installed Supplemental Packs.
     *
     * @param 
     *
     * @return mixed
     */  
    public function refreshPackInfo(){
        
        return $this->getXenconnection()->host__refresh_pack_info($this->getHostId());      
    }


    /**
     * Enable the use of a local SR for caching purposes.
     *
     * @param string SR ref sr
     *
     * @return mixed
     */  
    public function enableLocalStorageCaching($srRef){
        
        return $this->getXenconnection()->host__enable_local_storage_caching($this->getHostId(),$srRef);      
    }



    /**
     * Disable the use of a local SR for caching purposes. 	
     *
     * @param 
     *
     * @return mixed
     */  
    public function disableLocalStorageCaching(){
        
        return $this->getXenconnection()->host__disable_local_storage_caching($this->getHostId());      
    }    

    /**
     * Prepare to receive a VM, returning a token which can be passed to VM.migrate. 	
     *
     * @param string network ref network, array features
     *
     * @return mixed
     */  
    public function migrateReceive($networkRef, $features = array()){
        
        return $this->getXenconnection()->host__migrate_receive($this->getHostId(),$networkRef,$features);      
    }      
        
    /**
     * Get the uuid field of the given host. 	
     *
     * @param 
     *
     * @return mixed
     */  
    public function getUUID(){
    	return $this->getXenconnection()->host__get_uuid($this->getHostId());      
    }

    /**
     * Get the name/label field of the given host. 	
     *
     * @param 
     *
     * @return mixed
     */  
    public function getNameLabel(){
    	return $this->getXenconnection()->host__get_name_label($this->getHostId());      
    }  
   
    /**
     * Set the name/label field of the given host. 	
     *
     * @param string $name
     *
     * @return mixed
     */  
    public function setNameLabel($name){
    	return $this->getXenconnection()->host__set_name_label($this->getHostId(),$name);      
    }    
	
	/**
	 * Get the name/description field of the given HOST.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription(){
		return $this->getXenconnection()->host__get_name_description($this->getHostId());
	}

	/**
	 * Set the name/description field of the given HOST.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name){
		return $this->getXenconnection()->host__set_name_description($this->getHostId(),$name);
	}

	/**
	 * Get the current operations field of the given HOST.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations(){
		return $this->getXenconnection()->host__get_current_operations($this->getHostId());
	}

	/**
	 * Get the allowed operations field of the given HOST.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations(){
		return $this->getXenconnection()->host__get_allowed_operations($this->getHostId());
	}

	/**
	 * Get the software version field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getSoftwareVersion(){
		return $this->getXenconnection()->host__get_software_version($this->getHostId());
	}

	/**
	 * Get the other config field of the given HOST.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig(){
		return $this->getXenconnection()->host__get_other_config($this->getHostId());
	}
	
	/**
	 * Set the other config field of the given HOST.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array()){
		return $this->getXenconnection()->host__set_other_config($this->getHostId(),$array);
	}

	/**
	 * Add the given key-value pair to the other config field of the given host.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToOtherConfig($key,$value){
		return $this->getXenconnection()->host__add_to_other_config($this->getHostId(),$key,$value);
	}

	/**
	 * Remove the given key and its corresponding value from the other config field of the given host. If
     * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key){
		return $this->getXenconnection()->host__remove_from_other_config($this->getHostId(),$key);
	}

	/**
	 * Get the supported bootloaders field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getSupportedBootloaders(){
		return $this->getXenconnection()->host__get_supported_bootloaders($this->getHostId());
	}

	/**
	 * Get the resident VMs field of the given host.
	 *
	 * @param 
	 *
	 * @return Array of XenVirtualMachine
	 */
	public function getResidentVMs(){
		$response = $this->getXenconnection()->host__get_resident_VMs($this->getHostId());
		$VMs = array();
		if($response->getValue() != ""){
			foreach ($response->getValue() as $key => $vm) {
				$xenVM = new XenVirtualMachine($this->getXenconnection(),null,$vm);
				$name = $xenVM->getNameLabel()->getValue();
				array_push($VMs,new XenVirtualMachine($this->getXenconnection(),$name,$vm));
			}
			$response->_setValue($VMs);
		}
		return $VMs;
	}

	/**
	 * Get the patches field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getPatches(){
		return $this->getXenconnection()->host__get_patches($this->getHostId());
	}
	
	/**
	 * Get the host CPUs field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getHostCPUs(){
		return $this->getXenconnection()->host__get_host_CPUs($this->getHostId());
	}


	/**
	 * Get the cpu info field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getCPUInfo(){
		return $this->getXenconnection()->host__get_cpu_info($this->getHostId());
	}	

	/**
	 * Get the hostname of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getHostname(){
		return $this->getXenconnection()->host__get_hostname($this->getHostId());
	}	
	
	/**
	 * Set the hostname of the given host.
	 *
	 * @param $name string
	 *
	 * @return XenResponse $response
	 */
	public function setHostname($name){
		return $this->getXenconnection()->host__set_hostname($this->getHostId(),$name);
	}	

	/**
	 * Get the address field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getAddress(){
		return $this->getXenconnection()->host__get_address($this->getHostId());
	}

	/**
	 * Set the address field of the given host. 
	 *
	 * @param $address string
	 *
	 * @return XenResponse $response
	 */
	public function setAddress($address){
		return $this->getXenconnection()->host__set_address($this->getHostId(),$address);
	}
	
	/**
	 * Get the metrics field of the given host 
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getMetrics(){
		return $this->getXenconnection()->host__get_metrics($this->getHostId());
	}

	/**
	 * Get the license params field of the given host. 
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getLicenseParam(){
		return $this->getXenconnection()->host__get_license_params($this->getHostId());
	}

	/**
	 * Get the edition field of the given host. 
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getEdition(){
		return $this->getXenconnection()->host__get_edition($this->getHostId());
	}
	
	/**
	 * Get the license server field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getLicenseServer(){
		return $this->getXenconnection()->host__get_license_server($this->getHostId());
	}

	/**
	 * Set the license server field of the given host. 
	 *
	 * @param $license_server string
	 *
	 * @return XenResponse $response
	 */
	public function setLicenseServer($license_server){
		return $this->getXenconnection()->host__license_server($this->getHostId(),$license_server);
	}

	/**
	 * Add the given key-value pair to the license server field of the given host.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToLicenseServer($key,$value){
		return $this->getXenconnection()->host__add_to_license_server($this->getHostId(),$key,$value);
	}

	/**
	 * Remove the given key and its corresponding value from the license server field of the given host.
	 * If the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromLicenseServer($key){
		return $this->getXenconnection()->host__remove_from_license_server($this->getHostId(),$key);
	}

	/**
	 * Get the chipset info field of the given host.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getChipsetInfo(){
		return $this->getXenconnection()->host__get_chipset_info($this->getHostId());
	}

	public function getSystemStatusCapabilities(){
		return $this->getXenconnection()->host__get_system_status_capabilities($this->getHostId());
	}
	public function computeMemoryOverhead(){
		return $this->getXenconnection()->host__compute_memory_overhead($this->getHostId());
	}
	public function computeFreeMemory(){
		return $this->getXenconnection()->host__compute_free_memory($this->getHostId());
	}
	public function getCPUConfig(){
		return $this->getXenconnection()->host__get_cpu_config($this->getHostId());
	}
	public function getSchedPolicy(){
		return $this->getXenconnection()->host__get_sched_policy($this->getHostId());
	}
	public function getBiosString(){
		return $this->getXenconnection()->host__get_bios_string($this->getHostId());
	}
	public function getGuestVCPUParam(){
		return $this->getXenconnection()->host__get_guest_VCPUs_param($this->getHostId());
	}
}
?>
	