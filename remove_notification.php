<?php 
    session_start();
    
    require 'db_connect.php';
    require 'checksession.php';
    ?>

<?php
	$data = json_decode(stripslashes($_POST['data']));

  // here i would like use foreach:

  foreach($data as $d){
    $query="UPDATE `notification` SET `status`='o' WHERE `id`='$d'";
    $db=getDBConnection();
    $stmt = prepareQuery($db,$query);
    $param=array();
    if (executeQuery($stmt,$param)) {
    	
    }
  }
  echo 'Done';
?>