<?php
 
  session_start();
	require 'db_connect.php';
	$out = '';
	if(isset($_GET['username']) && !empty($_GET['username'])) {
	
	        
	    	$query = " 
	        SELECT 
	           username
	        FROM user
	        WHERE 
	            username = :username
	        UNION
	        SELECT 
	           username
 	        FROM new_user
	        WHERE 
	            	username = :username

	    ";

	    $param = array(
	    		":username"=>$_GET['username']
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
	   // die();
	}
	

?>