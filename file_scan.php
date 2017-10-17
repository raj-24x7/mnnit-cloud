<?php
session_start();

include('db_connect.php');
include('checksession.php');
include('ssh.php');

$username = $_SESSION['username'];
$password = $_GET['password'];

	function getStorageServerIP($storage_server){
	    $db = getDBConnection();
	    $query = "SELECT ip FROM `storage_servers` WHERE `server_name`=:server_name";
	    $stmt = prepareQuery($db, $query);
	    executeQuery($stmt, array(":server_name"=>$storage_server));
	    $row = $stmt->fetch();
	    return $row['ip'];
  	}

	function getStorageServer($username){
		$db = getDBConnection();
                
        $query = " 
                  SELECT * FROM `user_storage` WHERE `username`=:username"; 
        $param = array(":username"=>$_SESSION['username']);
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        $row=$stmt->fetch();
        return getStorageServerIP($row['storage_server']);
	}

	function mountUserFiles($password){
		$username = $_SESSION['username'];
		$cmd = "echo \"".$password."\" | sshfs -o allow_other -o password_stdin ".$username."@".getStorageServer($username).": files/".$username." ";
		
		$ret = "";
		exec($cmd,$ret);
		//echo " :: ";
		return $ret;		
	}
	mountUserFiles($password);
	
$dir = $username;

// Run the recursive function 

$response = scan($dir);


// This function scans the files folder recursively, and builds a large array

function scan($dir){

	$files = array();

	// Is there actually such a folder/file?
	$name_dir = $dir;
	$dir = "files/".$dir;

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}

			if(is_dir($dir . '/' . $f)) {

				// The path is a folder

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $name_dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
				);
			}
			
			else {

				// It is a file

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $name_dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
			}
		}
	
	}

	return $files;
}



// Output the directory listing as JSON

header('Content-type: application/json');

echo json_encode(array(
	"name" => $dir,
	"type" => "folder",
	"path" => $dir,
	"items" => $response
));
