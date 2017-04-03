<?php 
    session_start();
    	require_once "db_connect.php";
    if(isset($_SESSION['username'])){
    header("location:dashboard.php");
    }
    
    
    else{
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $param = array(
                    ":username" => $_POST['username'],
                    ":password" => md5($_POST['password']),
                    ":name" => $_POST['name'],
                    ":email" => $_POST['email'],
                    ":contact" => $_POST['contact'],
                    ":department" => $_POST['department']
                    // ":status" => 'p'
                );

        $query = "INSERT INTO new_user (username,password,name,email,contact,department,status) VALUES (:username,:password,:name,:email,:contact,:department,'p')";

        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        if(executeQuery($stmt,$param)){
                    header("location:index.php");
        }
    }
}
?>