<?php 
    session_start();
    require 'db_connect.php';
    require 'checksession.php';
    $username=$_SESSION['username'];
    $s = $_GET['s'];
	$query="SELECT * from `notification` where `username`=:username AND `status`=:s ORDER BY `id` DESC";
    	$db=getDBConnection();
    $stmt = prepareQuery($db,$query);
    $param=array(":username"=>$username, ":s"=>$s );
    if (executeQuery($stmt,$param)) {
    	$co=0;
    	$result = $stmt->fetchAll();
    	echo json_encode($result);
    }
?>