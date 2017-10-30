<?php 
    session_start();
    require 'db_connect.php';
    require 'checksession.php';
    $username=$_SESSION['username'];
	$query="SELECT * from notification where `username`='$username'";
    	$db=getDBConnection();
    $stmt = prepareQuery($db,$query);
    $param=array();
    if (executeQuery($stmt,$param)) {
    	$co=0;
    	$result = $stmt->fetchAll();
    	echo json_encode($result);
    }
?>