

<?php 
    require_once 'header.php';
    require_once 'checksession.php';
    require_once 'db_connect.php';
    require_once 'xen.php';
    
    if(isset($_GET['VM_name'])){
    	$query = "  SELECT 
    							* 
    							FROM `VMdetails`
    							WHERE `username`= :username 
    								and 
    							`VM_name`=:vm_name
    						";
        $param = array(
            ":vm_name"=>$_GET['VM_name'],
            ":username"=>$_SESSION['username']
          );   
        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        executeQuery($stmt,$param);
        $row = $stmt->fetch();

       	$xen = makeXenconnection();
       	$vm = $xen->getVMByNameLabel($_GET['VM_name']);
       	$metrics = $vm->getMetrics()->getValue(); 
       	$guestMetrics = $vm->getGuestMetrics()->getValue();        
    }
    ?>


<script type="text/javascript">
	function runAction(action){
		//alert("Action "+action.value);
		if(window.XMLHttpRequest){
          xmlHttp = new XMLHttpRequest();
       	} else {
          xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
       	}
    
       	xmlHttp.onreadystatechange = function() {
       		//alert(xmlHttp);
        	if(xmlHttp.readyState==4 && xmlHttp.status==200){
          		if(xmlHttp.response=='Wrong Action'){
          			alert(""+xmlHttp.response);
          		} else {
          	  		document.getElementById('powerState').innerHTML = xmlHttp.response;
          		}
          	}
          	if(xmlHttp.readyState==1){
          		document.getElementById('powerState').innerHTML = "fetching Data...";
        	}
        }
       		xmlHttp.open('POST','VMcontrol_ajax.php',true);
       		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       		xmlHttp.send("VM_name="+<?php echo '"'.$VM_name.'"';?>+"&action="+action.value);
	}
</script>
<br><br>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <?php
            require_once 'navigation_bar.php';
        ?>
    </div>
    <div id=”container”>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-10">
                    <!-- PANEL -->
                    <div class="panel panel-info">
                        <div id="VM_name" class="panel-heading"  >
                            <h4>Virtual Machine : <?php echo $row['VM_name']; ?></h4>
                        </div>
                        <div class="table-responsive ">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                     
                                            <td><strong>Requesting User : </strong></td>
                                            <td><?php echo $row['username'];?></td>
                                        
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>IP : </strong></td>
                                            <td><?php echo $row['ip'];?></td>
                                        
                                    </tr>
                                    <tr>
                                       
                                            <td><strong>Date of Expiry : </strong></td>
                                            <td><?php echo $row['doe'];?></td>
                                        
                                    </tr>
                                    <tr>
                                       
                                            <td><strong>Operating System : </strong></td>
                                            <td><?php echo $guestMetrics['os_version']['name'];?></td>
                                        
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>Alloted CPU : </strong></td>
                                            <td><?php echo $row['cpu'];?></td>
                                        
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>RAM : </strong></td>
                                            <td><?php echo $metrics['memory_actual']/(1024*1024)." MiB";?></td>
                                       
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>Power Status : </strong></td>
                                            <td id="powerState"><?php echo $vm->getPowerState()->getValue();?></td>
                                        
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>Storgae Disk Space : </strong></td>
                                            <td><?php echo $vm->getDiskSpace()->getValue()/(1024*1024*1024)." GiB";?></td>
                                        
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>UUID : </strong></td>
                                            <td><?php echo $vm->getUUID()->getValue();?></td>
                                        
                                    </tr>
                                   </tbody>
                                   </table>
                                   <div class="panel panel-body">
                                    <center>
                                    	<button class="btn btn-success" value="start" onclick="runAction(this);">Start</button>
                                    	<button class="btn btn-primary" value="cleanReboot" onclick="runAction(this);">Reboot</button>
                                    	<button class="btn btn-warning" value="cleanShutdown" onclick="runAction(this);">Shutdown</button>
                                    	<?php
                                    		if($_SESSION['privilege']=='A'){
                                    			echo '<button class="btn btn-danger" value="destroy" onclick="runAction(this)">Destroy</button>';
                                    		}
                                    	?>
                                      </center>
                                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="col-sm-1"></div>
</div>

