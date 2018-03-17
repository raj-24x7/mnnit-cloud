<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;

class XenPool extends XenElement {

    private $name;
    private $poolId;

    public function __construct($xenconnection,$name,$poolId){
        parent::__construct($xenconnection);
        $this->name = $name;
        $this->poolId = $poolId;
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
     * Gets the value of poolId.
     *
     * @return mixed
     */
    public function getPoolId()
    {
        return $this->poolId;
    }

    /**
     * Sets the value of poolId.
     *
     * @param mixed $poolId the pool id
     *
     * @return self
     */
    public function _setPoolId($poolId)
    {
        $this->poolId = $poolId;

        return $this;
    }

    /**
     *  Gives the uuid of the pool
     *
     * @param 
     *
     * @return mixed
     */
    public function getUUID(){
        
        return $this->getXenconnection()->pool__get_uuid($this->getPoolId());      
    }



    /**
     * Get the name/label field of the given pool.  
     *
     * @param 
     *
     * @return mixed
     */  
    public function getNameLabel(){
        return $this->getXenconnection()->pool__get_name_label($this->getPoolId());      
    }  
   
    /**
     * Set the name/label field of the given POOL.  
     *
     * @param string $name
     *
     * @return mixed
     */  
    public function setNameLabel($name){
        return $this->getXenconnection()->pool__set_name_label($this->getPoolId(),$name);      
    }    
    
    /**
     * Get the name/description field of the given POOL.
     *
     * @param 
     *
     * @return XenResponse $response
     */
    public function getNameDescription(){
        return $this->getXenconnection()->pool__get_name_description($this->getPoolId());
    }

    /**
     * Set the name/description field of the given POOL.
     *
     * @param string name
     *
     * @return XenResponse $response
     */
    public function setNameDescription($name){
        return $this->getXenconnection()->pool__set_name_description($this->getPoolId(),$name);
    }


    /**
     * Get the pool xen dmesg.
     *
     * @param 
     *
     * @return XenHost
     */
    public function getMaster(){
        
        $master_host = $this->getXenconnection()->pool__get_master($this->getPoolId())->getValue();
        $host = new XenHost($this->getXenconnection(), "", $master_host);
        return $host;
    }

    /**
     * Get the pool xen dmesg, and clear the buffer
     *
     * @param 
     *
     * @return mixed
     */
    public function getRecords(){
        
        return $this->getXenconnection()->pool__get_record($this->getPoolId());      
    }

    /**
     * Get the pool xen dmesg, and clear the buffer
     *
     * @param 
     *
     * @return mixed
     */
    public function getDefaultSR(){
        
        return $this->getXenconnection()->pool__get_default_SR($this->getPoolId());      
    }

    /**
     * Get the pool’s log file.
     *
     * @param 
     *
     * @return mixed
     */
    public function setDefaultSR(){
        
        return $this->getXenconnection()->pool__set_default_SR($this->getPoolId());      
    }

   /**
     * List all supported methods.
     *
     * @param 
     *
     * @return mixed
     */  
    public function getHAEnabled(){
        
        return $this->getXenconnection()->pool__get_ha_enabled($this->getPoolId());      
    }



    
    /**
     * Get the other config field of the given HOST.
     *
     * @param 
     *
     * @return XenResponse $response
     */
    public function getOtherConfig(){
        return $this->getXenconnection()->pool__get_other_config($this->getPoolId());
    }
    
    /**
     * Set the other config field of the given HOST.
     *
     * @param $value array
     *
     * @return XenResponse $response
     */
    public function setOtherConfig($array = array()){
        return $this->getXenconnection()->pool__set_other_config($this->getPoolId(),$array);
    }

    /**
     * Add the given key-value pair to the other config field of the given pool.
     *
     * @param $key string
     *
     * @return XenResponse $response
     */
    public function addToOtherConfig($key,$value){
        return $this->getXenconnection()->pool__add_to_other_config($this->getPoolId(),$key,$value);
    }

    /**
     * Remove the given key and its corresponding value from the other config field of the given pool. If
     * the key is not in that Map, then do nothing.
     *
     * @param $key string
     *
     * @return XenResponse $response
     */
    public function removeFromOtherConfig($key){
        return $this->getXenconnection()->pool__remove_from_other_config($this->getPoolId(),$key);
    }
}
?>
    