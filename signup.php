<?php 
    session_start();
    	require_once "db_connect.php";
  require_once('logging.php');
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
                    ":department" => $_POST['department'],
                    ":programme" => $_POST['programme']
                    // ":status" => 'p'
                );

        $query = "INSERT INTO new_user (username,password,name,email,contact,department,programme,status) VALUES (:username,:password,:name,:email,:contact,:department,:programme,'p')";

        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        if(!executeQuery($stmt,$param)){
            $l = logError("1101");
            $l[0]->log($l[1]);
            header("location:error.php?error=1104");
            die();
        }else{

            notifyAllAdmins("SIGNUP", "new user Requests pending : ".$_POST['username']);
            logSignupRequest($_POST['username']);
            header("location:success.php?id=1401");
            die();
        }
    }
}
?>