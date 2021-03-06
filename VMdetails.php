<?php 
  session_start();
  
  require 'checksession.php';
  require 'header.php';
  require 'db_connect.php';
?>
<script type="text/javascript">
  window.onload = function (){
    document.getElementById("VMdetails").className = "active";
      var prevClass = document.getElementById("vm-collapse").className;

      document.getElementById("vm-collapse").className = prevClass+" in";
  }
</script>
              <?php     

                $db = getDBConnection();
                if($_SESSION['privilege']=='A') {// A for admin
                    
                    $query = " 
                        SELECT * FROM `VMdetails` WHERE 1 AND `iscluster` IS NULL"; 
                    $param = array();
                } else {
                    $query = " 
                        SELECT * FROM `VMdetails` WHERE `username`=:username AND `iscluster` IS NULL"; 
                    $param = array(":username"=>$_SESSION['username']);
                }

                $stmt = prepareQuery($db,$query);
                if(!executeQuery($stmt,$param)){
                      $l = logError("1104");
                      $l[0]->log($l[1]);
                      header("location:error.php?error=1104");
                      die();
                }
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
          			<th>IP</th>
                <?php if($_SESSION['privilege']=='A'){
                  echo '<th>Username</th>';
                }?>
          			<th>Template</th>
          			<th>No Of vCPU</th>
          			<th>Storage(GB)</th>
          			<th>RAM(MB)</th>
          			<th>Expire On</th>
          			<th>Info</th>
        		</tr>
      		</thead>
    	
      		<tbody>
    	    	   
    				<?php 
            		while($row = $stmt->fetch()){
            
    					     echo '<tr>'.'<td>'.$row['VM_name'].'</td>'.'<td>'.$row['ip'].'</td>' ;
                    if($_SESSION['privilege']=='A'){
                      echo '<td>'.$row['username'].'</td>';
                    }
                  echo '
    							
    							<td>'.$row['os'].'</td>
    							<td>'.$row['cpu'].'</td>
    							<td>'.$row['storage'].'  GiB</td>
    							<td>'.$row['ram'].' MiB</td>
    							<td>'.$row['doe'].'</td>
                  <div class="container">
                    <td><a href="VMcontrol.php?VM_name='.$row['VM_name'].'"><span class="glyphicon glyphicon-info-sign"></span></a></td>
                  </div>
    						</tr>';      
    				}
    	    	?>
    	  	</tbody>	 
      </table>
      <br>
      <h4 style="color:red;">Note</h4>
      <ul class="list-group list">
        <li class="list-group-item list-group-item-info">
          <span class="glyphicon glyphicon-pencil"></span>All Centos Virtual Machines's have username: <b>centos</b> and password: <b>user@mnnit</b>
        </li>
        <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-pencil"></span>
          All Virtual Machines take nearly 2-3 minutes to start and 4 minutes to reboot. So <b>Please wait 4 minutes after starting VM's before SSH Login</b> 
        </li>
      </ul>
    </div>

    <div class="col-sm-1">
    </div>
  </div>
