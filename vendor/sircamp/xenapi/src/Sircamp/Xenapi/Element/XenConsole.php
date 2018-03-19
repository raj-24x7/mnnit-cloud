<?php namespace Sircamp\Xenapi\Element;

use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client as Client;
use Sircamp\Xenapi\Connection\XenResponse as  XenResponse;

class XenConsole extends XenElement {

	private $consoleId;

	public function __construct($xenconnection,$consoleId){
		parent::__construct($xenconnection);
		$this->consoleId = $consoleId;
	}

	public function getConsoleID(){
		return $this->consoleId;
	}

	
	public function getUUID(){
		return $this->getXenconnection()->console__get_uuid($this->getConsoleID());
	}

	public function getProtocol(){
		return $this->getXenconnection()->console__get_protocol($this->getConsoleId());
	}

	public function getLocation(){
		return $this->getXenconnection()->console__get_location($this->getConsoleId());
	}

	public function getVM(){
		return new XenVirtualMachine($this->getXenconnection(), '', $this->getXenconnection()->console__get_VM($this->getConsoleId()));
	}

	public function getPort(){
		return $this->getXenconnection()->console__get_port($this->getConsoleId());
	}
		

	public function setPort($port){
		return $this->getXenconnection()->console__set_port($this->getConsoleId(), $port);
	}
		
}
?>
	
