<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Connection\XenResponse as  XenResponse;
 
class XenVirtualDiskImage extends XenElement {

	private $name;
	private $vdiId;

	public function __construct($xenconnection,$vdiId){
		parent::__construct($xenconnection);
		$this->name = $xenconnection->VDI__get_name_label($vdiId);
		$this->vdiId = $vdiId;
	}
// yet to be done
	
	/**
	 * Get the UUID of a VDI .
	 *
	 * @param 
	 *
	 * @return mixed
	 */
	function getUUID(){
		return $this->getXenconnection()->VDI__get_uuid($this->getVdiId());
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
     * Gets the value of vdiId.
     *
     * @return mixed
     */
    public function getVdiId()
    {
        return $this->vdiId;
    }

    /**
     * Sets the value of vdiId.
     *
     * @param mixed $vdiId the vdi id
     *
     * @return self
     */
    private function _setVdiId($vdiId)
    {
        $this->vdiId = $vdiId;

        return $this;
    }

    /**
     * get SR on which VDI resides
     *
     * @param
     *
     * @return XenStorageRepository
     */
    public function getSR(){
    	$SR = $this->getXenconnection()->VDI__get_SR($this->getVdiId())->getValue();
    	return new XenStorageRepository($this->getXenconnection(), '', $SR);
    }

	/**
	 * Get the current operations field of the given VDI.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getCurrentOperations(){
		return $this->getXenconnection()->VDI__get_current_operations($this->getVdiId());
	}

	/**
	 * Get the allowed operations field of the given VDI.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getAllowedOperations(){
		return $this->getXenconnection()->VDI__get_allowed_operations($this->getVdiId());
	}



	/**
	 * Get the name/description field of the given VDI.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getNameDescription(){
		return $this->getXenconnection()->VDI__get_name_description($this->getVdiId());
	}

	/**
	 * Set the name/description field of the given VDI.
	 *
	 * @param string name
	 *
	 * @return XenResponse $response
	 */
	public function setNameDescription($name){
		return $this->getXenconnection()->VDI__set_name_description($this->getVdiId(),$name);
	}

	

	/**
	 * Get the other config field of the given VDI.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getOtherConfig(){
		return $this->getXenconnection()->VDI__get_other_config($this->getVdiId());
	}
	
	/**
	 * Set the other config field of the given VDI.
	 *
	 * @param $value array
	 *
	 * @return XenResponse $response
	 */
	public function setOtherConfig($array = array()){
		return $this->getXenconnection()->VDI__set_other_config($this->getVdiId(),$array);
	}

	/**
	 * Add the given key-value pair to the other config field of the given vdi.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function addToOtherConfig($key,$value){
		return $this->getXenconnection()->VDI__add_to_other_config($this->getVdiId(),$key,$value);
	}

	/**
	 * Remove the given key and its corresponding value from the other config field of the given vdi. If
     * the key is not in that Map, then do nothing.
	 *
	 * @param $key string
	 *
	 * @return XenResponse $response
	 */
	public function removeFromOtherConfig($key){
		return $this->getXenconnection()->VDI__remove_from_other_config($this->getVdiId(),$key);
	}

	/**
	 * Get name label VDI.
	 *
	 * @param 
	 *
	 * @return XenResponse $response
	 */
	public function getNameLabel(){
		return $this->getXenconnection()->VDI__get_name_label($this->getVdiId());
	}

	public function setNameLabel($new){
		return $this->getXenconnection()->VDI__set_name_label($this->getVdiId(),$new);
	}

	/**
	 * gives all records for the given vdi
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getRecords(){
		return $this->getXenconnection()->VDI__get_record($this->getVdiId());
	}

	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getType(){
		return $this->getXenconnection()->VDI__get_type($this->getVdiId());
	}

	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getVirtualSize(){
		return $this->getXenconnection()->VDI__get_virtual_size($this->getVdiId());
	}

	/**
	 *
	 *
	 * @param
	 * 
	 * @return
	 */
	public function getPhysicalUtilisation(){
		return $this->getXenconnection()->VDI__get_physical_utilisation($this->getVdiId());
	}

}
?>
	
