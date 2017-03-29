<?php
 
  session_start();
	require 'db_connect.php';
	$out = '';
	if(isset($_REQUEST['hadoop_name']) && !empty($_REQUEST['hadoop_name'])) {
	
	        
	    	$query = " 
	        SELECT 
	           hadoop_name
	        FROM hadoop
	        WHERE 
	            hadoop_name = :hadoop_name
	            ";

	    $param = array(
	    		":hadoop_name"=>$_REQUEST['hadoop_name']
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