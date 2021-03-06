<?php 

  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';
  require_once('logging.php');

?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("pending_details").className = "active";
  }
</script>
<?php 
      

    $db = getDBConnection();
    // Delete VM Entry
    if(isset($_GET['VM_name']) 
      && !empty($_GET['VM_name']) ){

        $sql = 'DELETE FROM `VMrequest` WHERE `VM_name`=:VM_name';
        $param = array(
            ":VM_name"=>$_GET['VM_name']
          );
        $stmt = prepareQuery($db,$sql);
        if(!executeQuery($stmt,$param)){
          $l = logError("1101");
          $l[0]->log($l[1]);
        }

        $sql = 'DELETE FROM `name_description` WHERE `name`=:VM_name';
        $stmt = prepareQuery($db,$sql);
        if(!executeQuery($stmt,$param)){
          $l = logError("1101");
          $l[0]->log($l[1]);
          header("location:");
          die();
        }


    }
  // Delete Hadoop Entry 
    if(isset($_GET['hadoop_name']) 
      && !empty($_GET['hadoop_name']) ){
        $sql = 'DELETE FROM `hadoop` WHERE `hadoop_name`=:hadoop_name';
        $param = array(
            ":hadoop_name"=>$_GET['hadoop_name']
          );
        $stmt = prepareQuery($db,$sql);
        if(!executeQuery($stmt,$param)){
          $l = logError("1104");
            $l[0]->log($l[1]);
          die("Cannot Delete Entry for hadoop");
        }

        $sql = 'DELETE FROM `name_description` WHERE `name`=:hadoop_name';
        $stmt = prepareQuery($db,$sql);
        if(!executeQuery($stmt,$param)){
          $l = logError("1104");
            $l[0]->log($l[1]);
          die("Cannot Delete Entry for hadoop");
        }
    }

    // Delete Storage Entry
    if(isset($_GET['storage']) 
      && !empty($_GET['storage']) ){
        $sql = 'DELETE FROM `storage_request` WHERE `username`=:username';
        $param = array(
            ":username"=>$_GET['storage']
          );
        $stmt = prepareQuery($db,$sql);
        if(!executeQuery($stmt,$param)){
          $l = logError("1104");
            $l[0]->log($l[1]);
          die("Cannot Delete Entry for Storage");
        }

    }


    if($_SESSION['privilege']=='A') {// A for admin
        
        $query = " 
            SELECT * FROM `VMrequest` WHERE 1"; 
        $param = array();
    } else {
        $query = " 
            SELECT * FROM `VMrequest` WHERE `username`=:username"; 
        $param = array(":username"=>$_SESSION['username']);
    }

    $stmt = prepareQuery($db,$query);
    executeQuery($stmt,$param);
   ?>
<div class="row">
  
    <div class="col-sm-3">
      <?php include 'navigation_bar.php'; ?>
    </div>

    <div class="col-sm-8">
    <br>
    <h2>Virtual Machine Requests : </h2><br>
    	<table class="table">
      		<thead class="thead-inverse">
        		<tr>
          			<th>VM_Name</th>
                <?php if($_SESSION['privilege']=='A'){
                  echo '<th>Username</th>';
                }?>
                <th>Operating System</th>
          			<th>No of vCPU</th>
          			<th>Storage(GB)</th>
          			<th>RAM(MB)</th>
          			<th>Expire On</th>

          			<th>Status</th>
        		</tr>
      		</thead>
    	
      		<tbody>
    	    	  
              <?php   
            		while($row=$stmt->fetch()){
        					  echo '
        						<tr>
        							<td>'.$row['VM_name'].'</td>';
                      if($_SESSION['privilege']=='A'){
                        echo '<td>'.$row['username'].'</td>';
                      }
                      echo '
                      <td>'.$row['os'].'</td>
        							<td>'.$row['cpu'].'</td>
        							<td>'.$row['storage'].'</td>
        							<td>'.$row['ram'].'</td>
        							<td>'.$row['doe'].'</td>';

                    if($row['status']!='rejected'){
                        if($row['status']=='deactivated'){
                          echo '<th>Deactivated</th>';
                        }else if($_SESSION['privilege']=='A'){
                          echo '<th>'.'<a href="VM_approval.php?VM_name='.$row['VM_name'].'">approve/reject</a>'.'</th>';
                        } else {
                          echo '<th>Pending...</th>';
                        }
                    } else {
                      echo '<th>Rejected <a href="pending_details.php?VM_name='.$row['VM_name'].'"><span class="glyphicon glyphicon-remove"></span></a></th>';
                    }
                      echo '</tr>';         
    				}
    	    	?>

    	  	</tbody>	 
      </table>
<?php
  $db=null;
  $db=getDBConnection();
    if($_SESSION['privilege']=='A') {// A for admin
                    
                    $query = " 
                        SELECT * FROM `hadoop` WHERE `status`='pending' OR `status`='rejected' OR `status`='deactivated'"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `hadoop` WHERE `username`=:username AND (`status`='pending' OR `status`='rejected' OR `status`='deactivated')"; 
                    $param = array(":username"=>$_SESSION['username']);
                }

                $stmt = prepareQuery($db,$query);
                executeQuery($stmt,$param);

?>

<br>
    <h2>Hadoop Cluster Requests : </h2><br>
      <table class="table">
          <thead class="thead-inverse">
            <tr>
                <th>Hadoop_Name</th>
                <?php if($_SESSION['privilege']=='A'){
                  echo '<th>Username</th>';
                }?>
                <th>Number of VMs</th>
                <th>No of vCPU</th>
                <th>Storage(GB)</th>
                <th>RAM(MB)</th>
                <th>Expire On</th>

                <th>Status</th>
            </tr>
          </thead>
      
          <tbody>
              
              <?php   
                while($row=$stmt->fetch()){
                    echo '
                    <tr>
                      <td>'.$row['hadoop_name'].'</td>';
                      if($_SESSION['privilege']=='A'){
                        echo '<td>'.$row['username'].'</td>';
                      }
                      echo 
                      ' 
                      <td>'.(string)((int)($row['number_slave'])+1).'</td>
                      <td>'.$row['cpu'].'</td>
                      <td>'.$row['storage'].'</td>
                      <td>'.$row['ram'].'</td>
                      <td>'.$row['doe'].'</td>';

                    if($row['status']!='rejected'){
                        if($_SESSION['privilege']=='A'){
                          echo '<th>'.'<a href="hadoop_approval.php?hadoop_name='.$row['hadoop_name'].'">approve/reject</a>'.'</th>';
                        } else {
                          echo '<th>Pending...</th>';
                        }
                    } else {
                      echo '<th>Rejected <a href="pending_details.php?hadoop_name='.$row['hadoop_name'].'"><span class="glyphicon glyphicon-remove"></span></a></th>';
                    }
                    
                      echo '</tr>';         
            }
            ?>

          </tbody>   
      </table>
<?php
  $db=null;
  $db=getDBConnection();
    if($_SESSION['privilege']=='A') {// A for admin
                    
                    $query = " 
                        SELECT * FROM `storage_request` WHERE 1"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `storage_request` WHERE `username`=:username"; 
                    $param = array(":username"=>$_SESSION['username']);
                }

                $stmt = prepareQuery($db,$query);
                executeQuery($stmt,$param);

?>


      <h2>Storage Requests : </h2><br>
      <table class="table">
          <thead class="thead-inverse">
            <tr>
                <?php if($_SESSION['privilege']=='A'){
                  echo '<th>Username</th>';
                }?>
                <th>Alloted Space</th>
                <th>New Requirement</th>
                <!--<th>Description</th>-->
                <th>Status</th>
            </tr>
          </thead>
      
          <tbody>
              
              <?php   
                while($row=$stmt->fetch()){
                    echo '
                    <tr>';
                      if($_SESSION['privilege']=='A'){
                        echo '<td>'.$row['username'].'</td>';
                      }
                      echo '
                      <td>'.getMemoryString($row['alloted_space']).'</td>
                      <td>'.getMemoryString($row['new_demand']).'</td>
                      <!--<td>'.$row['description'].'</td>-->';

                    if($row['status']!='Rejected'){
                        if($_SESSION['privilege']=='A'){
                          echo '<th>'.'<a href="storage_approval.php?username='.$row['username'].'">approve/reject</a>'.'<a href="pending_details.php?storage='.$row['username'].'" data-toggle="tooltip" title="Cancel Request" ><span class="glyphicon glyphicon-remove"></span></a>'.'</th>';
                        } else {
                          echo '<th>Pending...</th>';
                        }
                    } else {
                      echo '<th>Rejected <a href="pending_details.php?storage='.$row['username'].'"><span class="glyphicon glyphicon-remove"></span></a></th>';
                    }
                    
                      echo '</tr>';         
              }
            ?>

          </tbody>   
      </table>

      </div>





    <div class="col-sm-1">
    </div>
</div>



