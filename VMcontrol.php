

<?php 
  session_start();
    require_once 'checksession.php';
    require_once 'db_connect.php';
    require_once 'xen.php';
    require_once('logging.php');
    
    if(isset($_GET['VM_name'])){
    	$query = "  SELECT 
    							* 
    							FROM `VMdetails`
    							WHERE `username`= :username 
    								and 
    							`VM_name`=:vm_name
                   and `status`!='deactive'
    						";
                $param = array(
            ":vm_name"=>$_GET['VM_name'],
            ":username"=>$_SESSION['username']
          );
      if($_SESSION['privilege']=='A'){
                $query = "  SELECT 
                  * 
                  FROM `VMdetails`
                  WHERE 
                  `VM_name`=:vm_name
                  and
                  `status`!='deactive'
                ";
                    $param = array(
            ":vm_name"=>$_GET['VM_name'],
          );        
      }
           
        $db = getDBConnection();
        $stmt = prepareQuery($db,$query);
        if(!executeQuery($stmt,$param)){
            $l = logError("1103");
            $l[0]->log($l[1]);
            header("location:error.php?error=1103");
            die();
        }
        $row = $stmt->fetch(); 
        if(empty($row)){
              $l = logError("1103");
            $l[0]->log($l[1]);
            header("location:error.php?error=1109");
            die();
        }
     //   echo $row['hypervisor_name'].'hello';
        $os = $row['os'];
       	try {
          $xen = makeXenconnection($row['hypervisor_name']);  
        } catch (Exception $e) {
          $l = logError("1201");
          $l[0]->log($l[1]);
          header("location:error.php?error=1201");
          die();
        }
        try{
            $vm = $xen->getVMByNameLabel($_GET['VM_name']);
           	$metrics = $vm->getMetrics()->getValue(); 
           	$guestMetrics = $vm->getGuestMetrics()->getValue(); 
        }catch(Exception $e){
          $l = logError("1202");
          $l[0]->log($l[1]);
          header("location:error.php?error=1202");
          die();
        }
        $sql = 'SELECT description FROM `name_description` WHERE `name` = :VM_name';
        $param = array(":VM_name"=>$_GET['VM_name']);
        $stmt2 = prepareQuery($db,$sql);
        if(!(executeQuery($stmt2,$param))){
            $l = logError("1102");
            $l[0]->log($l[1]);
            header("location:error.php?error=1102");
          die();
        }
        $val = $stmt2->fetch();
        $description = $val['description'];
        //die($description);
    }
    ?>


<script type="text/javascript">
  window.onload = function(){
    var powerState = document.getElementById("powerState");    
    if(powerState.innerHTML == 'Halted'){
        document.getElementById("start-button").disabled = false;
        document.getElementById("shutdown-button").disabled = true;
    }
    if(powerState.innerHTML == 'Running'){
        document.getElementById("start-button").disabled = true;
        document.getElementById("shutdown-button").disabled = false;
    }
  }
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
              var reply = JSON.parse(xmlHttp.response)
          		if(reply.status == 'failiure'){
          			alert(reply.message);
          		} else {
          	  		document.getElementById('powerState').innerHTML = reply.power_state;
                  if(reply.power_state == 'Running'){
                      document.getElementById("start-button").disabled = true;
                      document.getElementById("shutdown-button").disabled = false;
                  }

                  if(reply.power_state == 'Halted'){
                      document.getElementById("start-button").disabled = false;
                      document.getElementById("shutdown-button").disabled = true;
                  }
          		}
          	}
          	if(xmlHttp.readyState==1){
          		document.getElementById('powerState').innerHTML = "fetching Data...";
        	}
        }
       		xmlHttp.open('POST','VMcontrol_ajax.php',true);
       		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       		xmlHttp.send("VM_name="+<?php echo '"'.$row['VM_name'].'"';?>+"&action="+action.value);
	}


  function destroyVM(){
     /* if(document.getElementById('powerState').innerHTML != 'Halted'){
        alert('Virtual Machine must be shutdown for this operation');
        return false;
      }*/

      if(confirm("Are you sure you want to delete this Virtual Machine ? ")){
        window.location="vm_destroy.php?VM_name="+"<?php echo $row['VM_name']?>";
      } else {
        return false;
      }

  }
</script>
<?php 
    require_once 'header.php';
?>
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
                            <h4>Virtual Machine : <a id="VMname"><?php echo $row['VM_name']; ?></a></h4>
                        </div>
                        <div class="table-responsive ">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                     
                                            <td><strong>Requesting User : </strong></td>
                                            <td><?php echo $row['username'];?></td>
                                        
                                    </tr>
                                    <tr>
                                        
                                            <td><strong>Description : </strong></td>
                                            <td><?php echo $description;?></td>
                                        
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
                                       
                                            <td><strong>Template : </strong></td>
                                            <td><?php echo $os;?></td>
                                        
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
                                    	<button class="btn btn-success" value="start" id="start-button" onclick="runAction(this);">Start</button>
                                    	<button class="btn btn-primary" value="cleanReboot" id="reboot-button" onclick="runAction(this);">Reboot</button>
                                    	<button class="btn btn-warning" value="cleanShutdown" id="shutdown-button" onclick="runAction(this);">Shutdown</button>
                                    	<?php
                                    		if($_SESSION['privilege']=='A'){
                                    			echo '<button class="btn btn-danger" value="destroy" id="destroy-button" onclick="destroyVM();">Destroy</button>';
                                    		}
                                    	?>
                                      </center>
                                    </div>
                    </div>
                </div>
                <a class="btn btn-info" id="start-console" >Console</a>
                <a class="btn btn-danger" id="delete-console" >Destroy Console</a>
            </div><br><br>
            <div id="console-frame" >
            </div>
        </div>
    </div> 
    <div class="col-sm-1"></div>
</div>
