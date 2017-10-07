<?php 

  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';

  function getMemoryString($data){
    $size = array("Bytes", "KiB", "MiB", "GiB", "TiB");
    $div = 1;
    $i = 0;
    while($data/$div >= 1024){
      $div = $div*1024;
      $i = $i + 1;
    }
    return round((float)$data/$div, 3)." ".$size[$i];
  }
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
                      die("Cannot Delete Entry for VM");
                    }

                    $sql = 'DELETE FROM `name_description` WHERE `name`=:VM_name';
                    $stmt = prepareQuery($db,$sql);
                    if(!executeQuery($stmt,$param)){
                      die("Cannot Delete Entry for VM");
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
                      die("Cannot Delete Entry for hadoop");
                    }

                    $sql = 'DELETE FROM `name_description` WHERE `name`=:hadoop_name';
                    $stmt = prepareQuery($db,$sql);
                    if(!executeQuery($stmt,$param)){
                      die("Cannot Delete Entry for hadoop");
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
          			<th>CPU#</th>
          			<th>Storage</th>
          			<th>RAM</th>
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
                        if($_SESSION['privilege']=='A'){
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
                        SELECT * FROM `hadoop` WHERE `status`='pending'"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `hadoop` WHERE `username`=:username AND `status`='pending'"; 
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
                <th>Number of Slaves</th>
                <th>CPU#</th>
                <th>Storage</th>
                <th>RAM</th>
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
                      <td>'.$row['number_slave'].'</td>
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
                        SELECT * FROM `storage_request` WHERE `status`='pending'"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `storage_request` WHERE `username`=:username AND `status`='pending'"; 
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
                <th>Description</th>
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
                      <td>'.$row['description'].'</td>';

                    if($row['status']!='rejected'){
                        if($_SESSION['privilege']=='A'){
                          echo '<th>'.'<a href="create_storage_repo.php?username">approve/reject</a>'.'</th>';
                        } else {
                          echo '<th>Pending...</th>';
                        }
                    } else {
                      echo '<th>Rejected <a href="#"><span class="glyphicon glyphicon-remove"></span></a></th>';
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



