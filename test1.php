
<?php
$connection = ssh2_connect('172.31.100.51', 22);
ssh2_auth_password($connection, 'root', 'root@123');

$stream = ssh2_exec($connection, 'xe console vm=kali');

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


?>
