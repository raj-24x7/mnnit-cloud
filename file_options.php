<?php
session_start();
require_once('db_connect.php');
require_once('logging.php');

if(isset($_POST)){
	$path = $_POST['path'];
	$target_dir = "files/";
	$target_file = $target_dir . $path .'/'. basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if($uploadOk && $_FILES["fileToUpload"]["size"]==0){
		echo "Nothing Sent. Send a file. \n";
		$uploadOk = 0;
	}
	if ($uploadOk && file_exists($target_file)) {
	    echo "Sorry, file already exists. \n";
	    $uploadOk = 0;
	}
	// Check file size
	$row = getUserStorage();
	if ($uploadOk && $_FILES["fileToUpload"]["size"] > 1024*($row['alloted_space'] - $row['used_space'])) {
	    echo "Sorry, your file is too large. \n";
	    $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	    	logFileUpload($_SESSION['username'],$_FILES["fileToUpload"]["name"]);
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}
?>