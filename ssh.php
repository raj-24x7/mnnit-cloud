
<?php

require_once 'db_connect.php';

function createVMFromSSH($dom0name,$VMparam,$template){
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

		$stream = ssh2_exec($connection,'xe vm-start name-label='.$VMparam['name']);
		
		fclose($stream);
		//echo "created VM";


}


function resizeVDIFromUUID($dom0name, $uuid, $newSize){

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

function createHadoopCluster($dom0name ,$name, $ram, $noofslaves, $ips){

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

		$command = "bash ~/utilityScripts/createCluster.sh ".$name." ".$ram." ".$noofslaves;

		for($i=0; $i<=$noofslaves; $i++){
			$command = $ccommand." ".$ips[$i];
		}

		$command = $command." "."&";

		$stream = ssh2_exec($connection, $command);
		
		fclose($stream);

		return true;
}

?>
