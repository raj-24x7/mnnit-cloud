<?php
 
  session_start();
	require 'db_connect.php';
	$out = '';
	if(isset($_REQUEST['VM_name']) && !empty($_REQUEST['VM_name'])) {
	
	        
	    	$query = " 
	        SELECT 
	           VM_name
	        FROM VMrequest
	        WHERE 
	            VM_name = :vm_name
	        UNION
	        SELECT 
	           VM_name
 	        FROM VMdetails
	        WHERE 
	            	VM_name = :vm_name

	    ";

	    $param = array(
	    		":vm_name"=>$_REQUEST['VM_name']
	    	);
	    $db = getDBConnection();
	    $stmt = prepareQuery($db,$query);
	    executeQuery($stmt,$param);
	    if(!$stmt->fetch())
	    {
	    	$out = $out.'Valid';
	    } else {
	    		$out = $out.'Invalid';
	
	    }	
	    echo $out;
	}
	

?>