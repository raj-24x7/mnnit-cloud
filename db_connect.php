<?php
    
  require_once('logging.php'); 
  require_once('notification.php');
  require_once('mail.php');
    function getDBConnection(){
        $conn_data = parse_ini_file("cloud.ini", true);
        $username = $conn_data["database-connection-settings"]["username"]; 
        $password = $conn_data["database-connection-settings"]["password"]; 
        $host = $conn_data["database-connection-settings"]["host"];
        $dbname = $conn_data["database-connection-settings"]["db-name"]; 
 
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
            //die("<strong>Failed to run query:</strong><br> " . $ex->getMessage()."<br>".print_r($params));
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

    function getVMHypervisor($vm_name){
        $db = getDBConnection();
        $query = "  SELECT * FROM `VMdetails` WHERE `VM_name`=:VM_name";
        $param = array(
            ":VM_name"=>$vm_name
          );
        $stmt = prepareQuery($db, $query);
        executeQuery($stmt, $param);
        $row = $stmt->fetch();
        return $row['hypervisor_name'];
    }

    function notifyAllAdmins($type, $message){
        $db = getDBConnection();
        $sql = "SELECT * FROM `user` WHERE `privilege`='A'";
        $stmt = prepareQuery($db, $sql);
        executeQuery($stmt, array());

        while($row = $stmt->fetch()){
            notifyUser($row['username'], $type, $message);
        }
    }

    function getUserEmail($username){
        $db = getDBConnection();
        $sql = "SELECT * FROM `new_user` WHERE `username`=:username";
        $stmt = prepareQuery($db, $sql);
        executeQuery($stmt, array(":username"=>$username));
        $row = $stmt->fetch();
        return $row['email'];
    }

    function getMiddleWareSocket(){
        $conn_data = parse_ini_file("cloud.ini", true);

        $ip = $conn_data["middleware-connection-settings"]["host"];
        $port = (int)$conn_data["middleware-connection-settings"]["port"];
        $socket = getNetworkSocket($ip, $port);
        $jsondata = json_encode(
            array(
                    "REQUEST_TYPE"=>'if_alive',
                    "REQUEST_DATA"=>array(
                            "USERNAME"=>"a",
                            "PASSWORD"=>"a"
                        )
                )
        );
        socket_write($socket, $jsondata, strlen($jsondata));
        $out = socket_read($socket, 2048);
        if($out === 'alive'){
            #echo "ALIVE";
            return $socket;
        }
        return false;
    }

    function getNetworkSocket($address, $service_port){
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        //echo "Attempting to connect to '$address' on port '$service_port'...";
        $result = socket_connect($socket, $address, $service_port);
        if ($result === false) {
            echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
        }
        return $socket;
    }

?>
