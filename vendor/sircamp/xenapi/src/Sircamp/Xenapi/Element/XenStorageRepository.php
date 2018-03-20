<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Connection\XenResponse as  XenResponse;
 
class XenStorageRepository extends XenElement {

	private $name;
	private $srId;

	public function __construct($xenconnection,$name,$srId){
		parent::__construct($xenconnection);
		$this->name = $name;
		$this->srId = $srId;
	}

	
	/**
	 * Get the UUID of a SR .
	 *
	 * @param 
	 *
	 * @return mixed
	 */
	function getUUID(){
		return $this->getXenconnection()->SR__get_uuid($this->getSrId());
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
    private function _setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of srId.
     *
     * @return mixed
     */
    public function getSrId()
    {
        return $this->srId;
    }

    /**
     * Sets the value of srId.
     *
     * @param mixed $srId the sr id
     *
     * @return self
     */
    private function _setSrId($srId)
    {
        $this->srId = $srId;

        return $this;
    }

	/**
	 * Get the current operations field of the given SR.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations(){
		return $this->getXenconnection()->SR__get_current_operations($this->getSrId());
	}

	/**
	 * Get the allowed operations field of the given SR.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations(){
		return $this->getXenconnection()->SR__get_allowed_operations($this->getSrId());
	}



	/**
	 * Get the name/description field of the given SR.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription(){
		return $this->getXenconnection()->SR__get_name_description($this->getSrId());
	}

	/**
	 * Set the name/description field of the given SR.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name){
		return $this->getXenconnection()->SR__set_name_description($this->getSrId(),$name);
	}

	

	/**
	 * Get the other config field of the given SR.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig(){
		return $this->getXenconnection()->SR__get_other_config($this->getSrId());
	}
	
	/**
	 * Set the other config field of the given SR.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array()){
		return $this->getXenconnection()->SR__set_other_config($this->getSrId(),$array);
	}

	/**
	 * Add the given key-value pair to the other config field of the given sr.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToOtherConfig($key,$value){
		return $this->getXenconnection()->SR__add_to_other_config($this->getSrId(),$key,$value);
	}

	/**
	 * Remove the given key and its corresponding value from the other config field of the given sr. If
     * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key){
		return $this->getXenconnection()->SR__remove_from_other_config($this->getSrId(),$key);
	}

	/**
	 * Get name label SR.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getNameLabel(){
		return $this->getXenconnection()->SR__get_name_label($this->getSrId());
	}

	public function setNameLabel($new){
		return $this->getXenconnection()->SR__set_name_label($this->getSrId(),$new);
	}

	/**
	 * gives all records for the given sr
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getRecords(){
		return $this->getXenconnection()->SR__get_record($this->getSrId());
	}

	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getPhysicalSize(){
		return $this->getXenconnection()->SR__get_physical_size($this->getSrId());
	}

	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getVirtualAllocation(){
		return $this->getXenconnection()->SR__get_virtual_allocation($this->getSrId());
	}

	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getPhysicalUtilisation(){
		return $this->getXenconnection()->SR__get_physical_utilisation($this->getSrId());
	}


	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getType(){
		return $this->getXenconnection()->SR__get_type($this->getSrId());
	}

}
?>
	
