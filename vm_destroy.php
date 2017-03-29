

<?php

		session_start();
	require_once "header.php";
	require_once 'xen.php';
	//require_once 'navigation_bar.php';

		if($_SESSION['privilege']!='A')
				{
					//die("ddddddd");
					header('location:VMcontrol.php?VM_name='.$_GET['VM_name']);
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
      // if($_SESSION['privilege']=='A'){
      //           $query = "  SELECT 
      //             * 
      //             FROM `VMdetails`
      //             WHERE 
      //             `VM_name`=:vm_name
      //           ";
      //               $param = array(
      //       ":vm_name"=>$_GET['VM_name'],
      //     );        
      // }
           
        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        $row = $stmt->fetch();
        echo $row['hypervisor_name'].'hello';
       	$xen = makeXenconnection($row['hypervisor_name']);
       	$vm = $xen->getVMByNameLabel($_GET['VM_name']);
       		$vm->cleanShutdown();
       		$vm->destroy();


       		$query=" delete from `VMdetails` where `VM_name`=:vm_name";
       		$stmt=prepareQuery($db,$query);

       		executeQuery($stmt,$param);



       //	$metrics = $vm->getMetrics()->getValue(); 
       	//$guestMetrics = $vm->getGuestMetrics()->getValue();


    }

	//$domname=$_GET['VM_name'];

	//makeXenConnection($domname);




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
				<div class="panel panel-red">
					<div class="panel-heading">
						<center><b>Alert</b></center>
					</div>
					<div class="panel-body">
						<?php echo $_GET['VM_name']?> is destroyed
					</div>
				</div>
		</div>
	</div>
</div>
</html>

