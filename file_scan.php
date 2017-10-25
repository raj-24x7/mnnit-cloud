<?php
session_start();

@ini_set("default_socket_timeout", 5);
include('db_connect.php');
include('checksession.php');
include('ssh.php');
$username = $_SESSION['username'];

	

	function mountUserFiles($username){
		$row = getStorageServer($username);

		// For mounting using sshfs
		$connection = getLocalServerShell();

		

		$command = "bash /var/www/html/project/mount.bash ".$row['ip']." ".$username." ".$row['login_password']." 2>&1";
		$stream = ssh2_exec($connection, $command);
		stream_set_blocking($stream, true);
		$recv_data = stream_get_contents($stream);
		fclose($stream);

		return $recv_data;
		
	}
	mountUserFiles($username);
	
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
					"items" => scan($name_dir . '/' . $f) // Recursively get the contents of the folder
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
