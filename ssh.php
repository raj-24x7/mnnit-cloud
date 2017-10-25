
<?php

require_once 'db_connect.php';

function getLocalServerShell(){
	$ip = $_SERVER['SERVER_ADDR'];
	$username = "raj";
	$password = "iptables";
	$connection = null;
	if(!($connection = ssh2_connect($ip, 22))){
		return false;
		header("location:error.php?error=1201");
		die();
	}
	if(!(ssh2_auth_password($connection, $username, $password))){
		header("location:error.php?error=1201");
		die();
	}
	return $connection;
}

function createVMFromSSH($dom0name,$VMparam,$template){
		$connection = getHypervisorConnection($dom0name);

		$stream = ssh2_exec($connection, 'xe vm-install template="'.$template.'" new-name-label='.$VMparam['name']);
		stream_set_blocking($stream, true);
		$uuid = stream_get_contents($stream);

		fclose($stream);
		//echo "uuid".$uuid;

		$stream = ssh2_exec($connection,'xe vm-memory-limits-set dynamic-max='.$VMparam['memory'].'MiB dynamic-min='.$VMparam['memory'].'MiB static-max='.$VMparam['memory'].'MiB static-min='.$VMparam['memory'].'MiB name-label='.$VMparam['name']);
		fclose($stream);

		$stream = ssh2_exec($connection,'xe vm-param-set PV-args="graphical utf8 -- _ipaddr='.$VMparam['ip'].' _netmask='.$VMparam['netmask'].' _gateway='.$VMparam['gateway'].' _hostname='.$VMparam['hostname'].' _name=none _ip=none" uuid='.$uuid.'');
		
		fclose($stream);


		$stream = ssh2_exec($connection,'xe vm-param-set name-description='.$VMparam['description'].' uuid='.$uuid);
		
		fclose($stream);

		resizeVDIFromSSH($connection, $uuid, $VMparam['storage']);
		setVDIname($dom0name, $uuid, $VMparam['name']);

		$stream = ssh2_exec($connection,'xe vm-start name-label='.$VMparam['name']);
		
		fclose($stream);
		//echo "created VM";


}


function resizeVDIFromUUID($dom0name, $uuid, $newSize){

		$sonnection = getHypervisorConnection($dom0name);

		$stream = ssh2_exec($connection, 'xe vm-disk-list uuid='.$uuid);
		stream_set_blocking($stream, true);
		$data = stream_get_contents($stream);
		fclose($stream);
		//echo $data;
		$pos = strpos($data, "VDI:\nuuid ( RO)");
		$pos=$pos+10;
		$newpos1=strpos($data, ":",$pos);
		$newpos1=$newpos1+2;
		$newpos2=strpos($data,"\n",$newpos1);
		$vdiUUID =  substr($data, $newpos1, $newpos2-$newpos1);
		/*if($vdiUUID === '26581f32-f0c6-4c06-aae7-a582b6b9cbbf'){
			echo 'YES';
		}*/

		$stream = ssh2_exec($connection, 'xe vdi-resize uuid='.$vdiUUID.' disk-size='.$newSize.'GiB');
		fclose($stream);
}

function resizeVDIFromSSH($connection, $uuid, $newSize){

		$stream = ssh2_exec($connection, 'xe vm-disk-list uuid='.$uuid);
		stream_set_blocking($stream, true);
		$data = stream_get_contents($stream);
		fclose($stream);
		//echo $data;
		$pos = strpos($data, "VDI:\nuuid ( RO)");
		$pos=$pos+10;
		$newpos1=strpos($data, ":",$pos);
		$newpos1=$newpos1+2;
		$newpos2=strpos($data,"\n",$newpos1);
		$vdiUUID =  substr($data, $newpos1, $newpos2-$newpos1);
		/*if($vdiUUID === '26581f32-f0c6-4c06-aae7-a582b6b9cbbf'){
			echo 'YES';
		}*/

		$stream = ssh2_exec($connection, 'xe vdi-resize uuid='.$vdiUUID.' disk-size='.$newSize.'GiB');
		fclose($stream);
}


function setVDIname($dom0name, $VMuuid, $newName){

		$connection = getHypervisorConnection($dom0name);

		$stream = ssh2_exec($connection, 'xe vm-disk-list uuid='.$VMuuid);
		stream_set_blocking($stream, true);
		$data = stream_get_contents($stream);
		fclose($stream);
		//echo $data;
		$pos = strpos($data, "VDI:\nuuid ( RO)");
		$pos=$pos+10;
		$newpos1=strpos($data, ":",$pos);
		$newpos1=$newpos1+2;
		$newpos2=strpos($data,"\n",$newpos1);
		$vdiUUID =  substr($data, $newpos1, $newpos2-$newpos1);
		/*if($vdiUUID === '26581f32-f0c6-4c06-aae7-a582b6b9cbbf'){
			echo 'YES';
		}*/

		$stream = ssh2_exec($connection, 'xe vdi-param-set uuid='.$vdiUUID.' name-label='.$newName);
		fclose($stream);
}

function createHadoopCluster($dom0name ,$name, $ram, $noofslaves, $ips){

		$connection = getHypervisorConnection($dom0name);

		$command = "bash ~/utilityScripts/createCluster.sh ".$name." ".$ram." ".$noofslaves;

		for($i=0; $i<=$noofslaves; $i++){
			$command = $command." ".$ips[$i];
		}

		$command = $command." "."";

		if(!($stream = ssh2_exec($connection, $command))){
			header("location:error.php?error=");
		}
		
		stream_set_blocking($stream, true);
		$uuid = stream_get_contents($stream);
		//echo $uuid;
		fclose($stream);

		return true;
}

function getHypervisorConnection($dom0name){
		
		$db = getDBConnection();
		$sql = 'SELECT * FROM `hypervisor` WHERE name=:name';
		$param = array(":name"=>$dom0name);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		$row = $stmt->fetch();
		$ip=$row['ip'];
		$username=$row['userid'];
		$password=$row['password'];

		if(!($connection = ssh2_connect($ip, 22))){
			header("location:error.php?error=1201");
		}
		if(!(ssh2_auth_password($connection, $username, $password))){
			header("location:error.php?error=1201");
		}
		return $connection;
}

function setQuota($storage_server, $username, $new_limit){
		$db = getDBConnection();
		$sql = 'SELECT * FROM `storage_servers` WHERE `server_name`=:name';
		$param = array(":name"=>$storage_server);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		$row = $stmt->fetch();
		$ip=$row['ip'];
		$sr_username=$row['login_name'];
		$password=$row['login_password'];
		$connection = null;
		if(!($connection = ssh2_connect($ip, 22))){
			header("location:error.php?error=1201");
			die();
		}
		if(!(ssh2_auth_password($connection, $sr_username, $password))){
			header("location:error.php?error=1201");
			die();
		}

		$command = "setquota -u ".$username." 0 ".$new_limit." 0 0 /home";

		$stream = ssh2_exec($connection, $command);
		stream_set_blocking($stream, true);
		$encrypted_password = stream_get_contents($stream);

		fclose($stream);
}

function createNewLinuxUser($username, $storage_server, $password){
		$db = getDBConnection();
		$sql = 'SELECT * FROM `storage_servers` WHERE `server_name`=:name';
		$param = array(":name"=>$storage_server);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		$row = $stmt->fetch();
		$ip=$row['ip'];
		$sr_username=$row['login_name'];
		$sr_password=$row['login_password'];
		$connection = null;
		if(!($connection = ssh2_connect($ip, 22))){
			header("location:error.php?error=1201");
			die();
		}
		if(!(ssh2_auth_password($connection, $sr_username, $sr_password))){
			header("location:error.php?error=1201");
			die();
		}

		$command = "openssl passwd -crypt ".$password;
		$stream = ssh2_exec($connection, $command);
		stream_set_blocking($stream, true);
		$encrypted_password = stream_get_contents($stream);
		fclose($stream);

		$command = "useradd ".$username." -p ".$encrypted_password;
		$stream = ssh2_exec($connection, $command);

		$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
		stream_set_blocking($errorStream, true);
		stream_set_blocking($stream, true);
/*
		echo "Output: " . stream_get_contents($stream);
		echo "Error: " . stream_get_contents($errorStream);
		*/
		fclose($stream);
}


function getUsedSpace($username, $storage_server){
	$db = getDBConnection();
		$sql = 'SELECT * FROM `storage_servers` WHERE `server_name`=:name';
		$param = array(":name"=>$storage_server);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		$row = $stmt->fetch();
		$ip=$row['ip'];
		$sr_username=$row['login_name'];
		$sr_password=$row['login_password'];
		$connection = null;
		if(!($connection = ssh2_connect($ip, 22))){
			return false;
			header("location:error.php?error=1201");
			die();
		}
		if(!(ssh2_auth_password($connection, $sr_username, $sr_password))){
			header("location:error.php?error=1201");
			die();
		}

		$command = "repquota -avug | awk '{ if($1==\"".$username."\") print $3 }'";
		$stream = ssh2_exec($connection, $command);
		stream_set_blocking($stream, true);
		$recv_data = stream_get_contents($stream);
		fclose($stream);
		$data = explode("\n", $recv_data);

		$db = getDBConnection();
		$query = "UPDATE `user_storage` SET `used_space`=:used_space WHERE `username`=:username AND `storage_server`=:storage_server";
		$param = array(
			":used_space"=>$data[0],
			":username"=>$username,
			":storage_server"=>$storage_server
			);
		$stmt_new = prepareQuery($db, $query);

		if(!executeQuery($stmt_new,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		return $data[0];
}

function isActive($storage_server){
	$db = getDBConnection();
		$sql = 'SELECT * FROM `storage_servers` WHERE `server_name`=:name';
		$param = array(":name"=>$storage_server);
		$stmt = prepareQuery($db,$sql);
		if(!executeQuery($stmt,$param)){
			echo '<br>Cannot Execute : '.$stmt->queryString;
		}
		
		$row = $stmt->fetch();
		$ip=$row['ip'];
		$sr_username=$row['login_name'];
		$sr_password=$row['login_password'];
		$connection = null;
		if(!($connection = ssh2_connect($ip, 22))){
			//return "Unable to connect";
			header("location:error.php?error=1201");
			die();
		}

		else return true;
}


?>
