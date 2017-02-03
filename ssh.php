
<?php
//$connection = ssh2_connect('https://172.31.100.51/console?uuid=98e0b0c5-0d7c-62f9-4386-ea5e08058ca9', 443);
//ssh2_auth_password($connection, 'root', 'password');

/*
$connection = ssh2_connect("172.31.100.51", 22);
ssh2_auth_password($connection, 'root', 'root@123');

$stream = ssh2_exec($connection, 'scp  rc.local root@');


$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

*/

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
	
}
//changeip("172.31.102.69");
/*

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
?>
