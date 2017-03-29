
<?php

require_once 'db_connect.php';
//$connection = ssh2_connect('https://172.31.100.51/console?uuid=98e0b0c5-0d7c-62f9-4386-ea5e08058ca9', 443);
//ssh2_auth_password($connection, 'root', 'password');

/*
$connection = ssh2_connect("172.31.100.51", 22);
ssh2_auth_password($connection, 'root', 'root@123');
$stream = ssh2_exec($connection, 'ls -l');
$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

// Enable blocking for both streams
stream_set_blocking($errorStream, true);
stream_set_blocking($stream, true);

// Whichever of the two below commands is listed first will receive its appropriate output.  The second command receives nothing
echo "Output: " . stream_get_contents($stream);
echo "Error: " . stream_get_contents($errorStream);

// Close the streams       
fclose($errorStream);
fclose($stream);
//echo "Output: " . stream_get_contents($stream);
*/

/*
function changeip($ip){
	$connection = ssh2_connect('172.31.102.67', 22);
	ssh2_auth_password($connection, 'root', 'password');

	$myfile = fopen("rc.local", "w") or die("Unable to open file!");
	$txt = "
#!/bin/sh
#
# This script will be executed *after* all the other init scripts.
# You can put your own initialization stuff in here if you don't
# want to do the full Sys V style init stuff.

touch /var/lock/subsys/local

ifconfig eth0 ".$ip."
ifconfig eth0 netmask 255.255.252.0
route add default gw 172.31.100.1
ping -c 2 172.31.100.1
";
	fwrite($myfile, $txt);


	if(ssh2_scp_send($connection, 'rc.local', '/etc/rc.d/rc.local', 0755)){
		//echo "dhoom machale";
	}
	else
	{
		//echo "kaam abhi baki hai";
	}
	
}*/

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

		$stream = ssh2_exec($connection,'xe vm-memory-limits-set dynamic-max='.$VMparam['memory'].'MiB dynamic-min='.$VMparam['memory'].'MiB static-max='.$VMparam['memory'].'MiB static-min='.$VMparam['memory'].'MiB name-description='.$VMparam['description'].' name-label='.$VMparam['name']);
		fclose($stream);

		$stream = ssh2_exec($connection,'xe vm-param-set PV-args="graphical utf8 -- _ipaddr='.$VMparam['ip'].' _netmask='.$VMparam['netmask'].' _gateway='.$VMparam['gateway'].' _hostname='.$VMparam['hostname'].' _name=none _ip=none" uuid='.$uuid.'');
		
		fclose($stream);


		$stream = ssh2_exec($connection,'xe vm-start name-label='.$VMparam['name']);
		
		fclose($stream);
		//echo "created VM";


}


/*$param = array(
	"name"=>"newCentos",
	"memory"=>"512",
	"ip"=>"172.31.102.70",
	"netmask"=>"255.255.252.0",
	"gateway"=>"172.31.100.1",
	"hostname"=>"localhost"
	);

createVM("xenserver-slave3",$param,"CENTOS");
*/
//changeip("172.31.102.69");
/*
		$ip = '172.31.100.51';
		$username = 'root';
		$password = 'root@123';
		$connection = ssh2_connect($ip, 22);
		ssh2_auth_password($connection, $username, $password);

		$stream = ssh2_exec($connection,'ls');
		stream_set_blocking($stream, true);
		$uuid = stream_get_contents($stream);
		fclose($stream);
		echo "uuid".$uuid;*/


?>
