
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

		$connection = ssh2_connect($ip, 22);
		ssh2_auth_password($connection, $username, $password);

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

		$stream = ssh2_exec($connection,'xe vm-start name-label='.$VMparam['name']);
		
		fclose($stream);
		//echo "created VM";


}


function resizeVDIFromVMName($dom0name,$VMname){

}



?>
