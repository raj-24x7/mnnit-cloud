
<?php

	session_start();
  
  require_once 'checksession.php';
	require_once "header.php";
	require_once 'xen.php';
  require_once('ssh.php');
  require_once('logging.php');
	//require_once 'navigation_bar.php';

		if($_SESSION['privilege']!='A')
		{
			//die("ddddddd");
			header('location:VMcontrol.php?VM_name='.$_GET['VM_name']);
      die();
		}
//echo "hello";

    if(isset($_GET['VM_name'])){
    	$query = "  SELECT 
    							* 
    							FROM `VMdetails`
    							WHERE 
    							`VM_name`=:vm_name
    						";
                $param = array(
            ":vm_name"=>$_GET['VM_name']
          );
         
        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        $row = $stmt->fetch();
        
       	$xen = makeXenconnection($row['hypervisor_name']);
       	$vm = $xen->getVMByNameLabel($_GET['VM_name']);
     		$vm->cleanShutdown();
        $uuid = $vm->getUUID()->getValue();
     		//$vm->destroy();
        $connection = getHypervisorConnection($row['hypervisor_name']);
        $command = "xe vm-uninstall uuid=".$uuid." force=true";
        if(!($stream = ssh2_exec($connection, $command))){
          header("location:error.php?error=1201");
        }
        stream_set_blocking($stream, true);
        fclose($stream);


        $ip = $row['ip'];

     		$query=" delete from `VMdetails` where `VM_name`=:vm_name";
     		$stmt=prepareQuery($db,$query);

       	if(!executeQuery($stmt,$param)){
            die("Cannot Delete Entry from VMdetails"); 
        }
        logVMdestroy($_GET['VM_name'], $_SESSION['username']);
        $param = array(
            ":ip"=>$ip 
          );


        $sql = "UPDATE `ip_pool` SET `status` = ' ' WHERE ip = :ip ";
        $stmt = prepareQuery($db,$sql);
        if(!executeQuery($stmt,$param)){
          die("Cannot Update IP table");
        }


        $sql = 'DELETE FROM `name_description` WHERE `name`=:VM_name';
        $stmt = prepareQuery($db,$sql);
        $param = array(":VM_name"=>$_GET['VM_name']);
        if(!executeQuery($stmt,$param)){
          die("Cannot Delete Entry for VM");
        }

    }

?>

<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <?php
            require_once 'navigation_bar.php';
        ?>
    </div>
    <div id=”container”>
        <div class="col-sm-8">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<center><h3><b>Alert</b></h3></center>
					</div>
					<div class="panel-body"><p>
						<?php echo $_GET['VM_name']?> is destroyed<br>
            IP <?php echo $ip; ?> is free.</p>
					</div>
				</div>
		</div>
	</div>
</div>
</html>

