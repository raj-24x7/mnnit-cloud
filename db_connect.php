<?php 
    function getDBConnection(){

        $username = "raj"; 
        $password = "hello"; 
        $host = "localhost"; 
        $dbname = "cloud"; 
 
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        try 
        { 
            $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
        } 
        catch(PDOException $ex) 
        { 
              header("location:error.php?error=1104");
        
            die("Failed to connect to the database: " . $ex->getMessage());
        } 
       
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
         
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
        //header('Content-Type: text/html; charset=utf-8');

        return $db; 
    }

    function ExecuteQuery($stmt,$params){
        try{
            $result = $stmt->execute($params);
            
           	return $result;
        } catch(PDOException $ex) { 
            //die("<strong>Failed to run query:</strong><br> " . $ex->getMessage()."<br>");
            //echo "<strong>Failed to run query:</strong><br> " . $ex->getMessage()."<br>"; 
            return false;
        }     
    }

    function PrepareQuery($db,$query){
        try{
            return $db->prepare($query);
        }catch(PDOException $ex){
            //die("<strong>Failed to run query:</strong><br> " .$query.$ex->getMessage()."<br>");
            //  header("location:error.php?error=1104");
            //echo "<strong>Failed to run query:</strong><br> " .$query.$ex->getMessage()."<br>"; 
            return false;
        }
    }
?>