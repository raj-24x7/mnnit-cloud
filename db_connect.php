<?php 
    function getDBConnection(){

        $username = "cloud-user"; 
        $password = "mnnitcloud"; 
        $host = "172.31.76.68"; 
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
            die("<strong>Failed to run query:</strong><br> " . $ex->getMessage()."<br>".print_r($params));
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

    function getStorageServerIP($storage_server){
    $db = getDBConnection();
    $query = "SELECT ip FROM `storage_servers` WHERE `server_name`=:server_name";
    $stmt = prepareQuery($db, $query);
    executeQuery($stmt, array(":server_name"=>$storage_server));
    $row = $stmt->fetch();
    return $row['ip'];
  }

  function doesUserExists($username, $storage_server){

        $db = getDBConnection();
        $query = " 
            SELECT alloted_space,used_space FROM `user_storage` WHERE `username`=:username AND `storage_server`=:storage_server"; 
        $param = array(":username"=>$username, ":storage_server"=>$storage_server);
    

        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        if($row=$stmt->fetch()){
            return true;
        }else{
            return false;
        }
    }


    function getUsedSpaceOn($storage_server){
        $db = getDBConnection();
        $query = "SELECT `used_space` FROM `storage_servers` WHERE `server_name`=:server_name";
        $stmt = prepareQuery($db, $query);
        executeQuery($stmt, array(":server_name"=>$storage_server));
        $row = $stmt->fetch();

        return $row['used_space']; 
      }

    function getTotalSpaceOn($storage_server){
        $db = getDBConnection();
        $query = "SELECT `total_space` FROM `storage_servers` WHERE `server_name`=:server_name";
        $stmt = prepareQuery($db, $query);
        executeQuery($stmt, array(":server_name"=>$storage_server));
        $row = $stmt->fetch();

        return $row['total_space']; 
    }


  function setUsedSpaceOn($storage_server, $used_space){
        $db = getDBConnection();
        $query = "UPDATE `storage_servers` SET `used_space`=:used_space WHERE `server_name`=:server_name";
        $stmt = prepareQuery($db, $query);
        executeQuery($stmt, array(":used_space"=>$used_space, ":server_name"=>$storage_server));
    }

  function getAllotedUserStorage(){

        $db = getDBConnection();
        $query = " 
            SELECT alloted_space,used_space FROM `user_storage` WHERE `username`=:username"; 
        $param = array(":username"=>$_SESSION['username']);
    

        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        if($row=$stmt->fetch()){
            return $row['alloted_space'];
        }else{
            return 0;
        }
    }


    function getUserStorageServer($username){
        $db = getDBConnection();
                
        $query = " 
                  SELECT * FROM `user_storage` WHERE `username`=:username"; 
        $param = array(":username"=>$_SESSION['username']);
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        $row=$stmt->fetch();
        return getStorageServer($row['storage_server']);
    }

    function getStorageServer($storage_server){
        $db = getDBConnection();
        $query = "SELECT * FROM `storage_servers` WHERE `server_name`=:server_name";
        $stmt = prepareQuery($db, $query);
        executeQuery($stmt, array(":server_name"=>$storage_server));
        $row = $stmt->fetch();
        return $row;
    }

    function getRemainingSpaceOn($storage_server){
        return getTotalSpaceOn($storage_server) - getUsedSpaceOn($storage_server);
    }

    function getMemoryString($data){
        $size = array("KiB", "MiB", "GiB", "TiB");
        $div = 1;
        $i = 0;
        while($data/$div >= 1024){
            $div = $div*1024;
            $i = $i + 1;
        }
        return round((float)$data/$div, 3)." ".$size[$i];
    }
  
    function getMemoryFromString($data){
        $new_data = explode(" ", $data);
        $size = array("KiB", "MiB", "GiB", "TiB");
        $index = array_search($new_data[1], $size);
        return (int)$new_data[0]*pow(1024, $index);
    }

    function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function getUserStorage(){
        $db = getDBConnection();  
        $query = "SELECT * FROM `user_storage` WHERE `username`=:username"; 
        $param = array(":username"=>$_SESSION['username']);


        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        return $stmt->fetch();
    }

?>