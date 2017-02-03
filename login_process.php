<?php

require "db_connect.php";

if (!empty($_POST)) {
    
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = " SELECT username , privilege FROM user WHERE  username = :username  AND password = :password ";
    $param = array(
        ":username"=>$username,
        ":password"=>$password
        );

    $db = getDBConnection();
    $stmt = prepareQuery($db,$query);
    executeQuery($stmt,$param);
    
    if ($row = $stmt->fetch()) {
        session_start();
        $_SESSION['username']  = $row['username'];
        $_SESSION['privilege'] = $row['privilege'];
        header('location:VMrequest.php');
    } else {
        header('location:index.php');
    }
}



?>