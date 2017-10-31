<?php

	/**
	 * @author
	 * RAJ KUMAR - 20145117 241096raj@gmail.com
	 * 
	 */

	require_once('Log.php');

	/**
	 * 
	 * User Log for all users login details
	 * signup requests and acceptance of signup requests
	 * forgot Password requests and change passwords
	 * details of failed login attempts 
	 * Useer details changed
	 */
	$LOGIN_LOG = "logs/login.log";
	$LOGIN_CONF = array(	'mode' => 0644,
							'timeFormat' => '%x %X', 
							'lineFormat'=>'%{timestamp} %{file}:%{line} [INFO]:[%{ident}] : %{message}'
						);
	/**
	 * getLoginLogger
	 * @param string identifier log identifier
	 * @return logger handle for logging
	 */
	function getLoginLogger($identifier){
		return Log::singleton('file', $LOGIN_LOG, $identifier, $LOGIN_CONF);
	}

	/**
	 * resource log for : 
	 * Logging All VM, Hadoop, Storage Request
	 * Logging All VM, Hadoop, Storage Approval and creation
	 *
	 */
	$REQUEST_LOG = "logs/resource.log";
	$REQUEST_CONF = array(	'mode' => 0644,
							'timeFormat' => '%x %X', 
							'lineFormat'=>'%{timestamp} %{file}:%{line} [INFO]:[%{ident}] : %{message}'
						);
	/**
	 * getResourceLogger
	 * @param string identifier log identifier
	 * @return logger handle for logging
	 */
	function getResourceLogger($identifier){
		return Log::singleton('file', $REQUEST_LOG, $identifier, $REQUEST_CONF);
	}

	/**
	 * Application Error Logs
	 * logging general application errors
	 *
	 *
	 */
	$ERROR_LOG  = 'logs/error.log';
	$ERROR_CONF = array(	'mode' => 0644,
							'timeFormat' => '%x %X', 
							'lineFormat'=>'%{timestamp} %{file}:%{line} [ERROR] : %{message}'
						);
	function logError($code){
		$logger = Log::singleton('file', $ERROR_LOG, 'ERROR', $ERROR_CONF);
		$file_handle = fopen("error_codes.txt", "r");
		$str = fread($file_handle,8192);
		$pos = strpos($str, $code);
		$pos = $pos + 5;
		$nl = strpos($str, "\n",$pos);
		$out = substr($str, $pos, $nl - $pos);

		fclose($file_handle);
		$logger->log($out);
	}

	// Login logs

	function logUserLogin($username, $ip){
		$logger = getLoginLogger("LOGIN");
		$logger->log($username." logged in from ".$ip);
	}

	function logFailedUserLogin($username, $ip){
		$logger = getLoginLogger("LOGIN");
		$logger->log($username." Failed login atttempt from ".$ip);
	}

	function logSignupRequest($username){
		$logger = getLoginLogger("SIGNUP");
		$logger->log($username." made account request.");
	}

	function logSignupApproved($username,$admin){
		$logger = getLoginLogger("SIGNUP");
		$logger->log($username." signup request approved by ".$admin);
	}
	
	function logSignupRejected($username,$admin){
		$logger = getLoginLogger("SIGNUP");
		$logger->log($username." signup request rejected by ".$admin);
	}

	function logUserCreated($username){
		$logger = getLoginLogger("SIGNUP");
		$logger->log("");
	}

	function logForgotPassword($username){
		$logger = getLoginLogger("FORGOT PASSWORD");
		$logger->log($username." request made ");		
	}

	function logPasswordResetSuccess($username){
		$logger = getLoginLogger("PASSWORD RESET");
		$logger->log("for ".$username." successful ");		
	}

	function logPasswordResetFailed($username){
		$logger = getLoginLogger("PASSWORD RESET");
		$logger->log("for ".$username." failed ");		
	}

	// Request Log 

	function logVMRequest($vm_name, $username){
		$logger = getResourceLogger("VM");
		$logger->log($vm_name." vm request made by ".$username);
	}

	function logVMApproval($vm_name, $username){
		$logger = getResourceLogger("VM");
		$logger->log($vm_name." vm request approved by ".$username);
	}

	function logVMRejected($vm_name, $username){
		$logger = getResourceLogger("VM");
		$logger->log($vm_name." vm request rejected by ".$username);
	}

	function logVMCreated($vm_name){
		$logger = getResourceLogger("VM");
		$logger->log($vm_name." vm  Created ");
	}

	function logHadoopRequest($cluster_name, $username){
		$logger = getResourceLogger("HADOOP");
		$logger->log("cluster".$cluster_name." request made by ".$username);
	}

	function logHadoopApproval($cluster_name, $username){
		$logger = getResourceLogger("HADOOP");
		$logger->log("cluster".$cluster_name." request Approved by ".$username);
	}

	function logHadoopRejected($cluster_name, $username){
		$logger = getResourceLogger("HADOOP");
		$logger->log("cluster".$cluster_name." request rejected by ".$username);
	}

	function logHadoopCreated($cluster_name){
		$logger = getResourceLogger("HADOOP");
		$logger->log("cluster".$cluster_name." Created");
	}


	function logStorageRequest($username){
		$logger = getResourceLogger("STORAGE");
		$logger->log($username." storage extension request made");
	}

	function logStorageApproved($username, $admin){
		$logger = getResourceLogger("STORAGE");
		$logger->log($username." storage extension request approved by ".$admin);
	}

	function logStorageRejected($username){
		$logger = getResourceLogger("STORAGE");
		$logger->log($username." storage extension request Rejected by ".$admin);
	}

	function logFileUpload($username,$filename){
		$logger = getResourceLogger("STORAGE");
		$logger->log($username." uploaded file ".$file);
	}



?>