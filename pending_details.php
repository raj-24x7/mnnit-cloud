<?php 
  require 'header.php';
  require 'db_connect.php';
  require 'checksession.php';
?>

<script type="text/javascript">
  window.onload = function (){
    document.getElementById("pending_details").className = "active";
  }
</script>
            <?php 
                  

                $db = getDBConnection();
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
                      echo '<th>Rejected</th>';
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

